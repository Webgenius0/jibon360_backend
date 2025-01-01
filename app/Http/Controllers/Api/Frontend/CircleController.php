<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Circle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use App\Models\CircleUser;
use Illuminate\Support\Facades\DB;

class CircleController extends Controller
{
    public function store(Request $request)
    {
        $count = Circle::where('owner', auth('api')->user()->id)->count();
        if ($count <= 4) {
            try {
                DB::beginTransaction();
                $validator = Validator::make($request->all(), [
                    'name'    => 'required|string|max:50',
                ]);

                if ($validator->fails()) {
                    return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
                }

                do {
                    $uniqueCode = Str::random(6);
                    $circle = Circle::where('code', $uniqueCode)->exists();
                } while ($circle);

                $circle = new Circle();
                $circle->name = $request->name;
                $circle->code = $uniqueCode;
                $circle->owner = auth('api')->user()->id;
                $circle->save();

                $circleuser = new CircleUser();
                $circleuser->circle_id = $circle->id;
                $circleuser->user_id = auth('api')->user()->id;
                $circleuser->save();

                DB::commit();

                return response()->json([
                    'status'     => true,
                    'message'    => 'Circle Created Successfully',
                    'code'       => 200,
                    'data'       => $circle,
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return Helper::jsonResponse(false, 'An error occurred during circle creation.', 500, ['error' => $e->getMessage()]);
            }
        } else {
            return response()->json([
                'status'     => false,
                'message'    => 'Circle is full',
                'code'       => 200,
                'data'       => [],
            ]);
        }
    }
    public function destroy(Circle $circle)
    {
        $circle->delete();
        return response()->json([
            'status'     => true,
            'message'    => 'Circle Deleted Successfully',
            'code'       => 200,
            'data'       => $circle,
        ], 200);
    }

    public function join($code)
    {

        $circle = Circle::where('code', $code)->first();
        if (!$circle) {
            return response()->json([
                'status'     => false,
                'message'    => 'Circle Not Found',
                'code'       => 200,
                'data'       => [],
            ], 200);
        }
        $count = CircleUser::where('circle_id', $circle->id)->count();
        if ($count <= 4) {
            if ($circle) {
                $exists = CircleUser::where('circle_id', $circle->id)->where('user_id', auth('api')->user()->id)->exists();
                if ($exists) {
                    return response()->json([
                        'status'     => false,
                        'message'    => 'Already joined',
                        'code'       => 200,
                        'data'       => $circle,
                    ], 200);
                }
                $circleuser = new CircleUser();
                $circleuser->circle_id = $circle->id;
                $circleuser->user_id = auth('api')->user()->id;
                $circleuser->save();
                return response()->json([
                    'status'     => true,
                    'message'    => 'Joined Circle Successfully',
                    'code'       => 200,
                    'data'       => $circle,
                ], 200);
            }
        } else {
            return response()->json([
                'status'     => false,
                'message'    => 'Circle is full',
                'code'       => 200,
                'data'       => $circle,
            ], 200);
        }
    }

    public function all()
    {
        $circles = Circle::join('circle_users', 'circles.id', '=', 'circle_users.circle_id')
            ->where('circle_users.user_id', auth('api')->user()->id)
            ->select('circles.id', 'circles.name', 'circles.code', DB::raw('count(circle_users.user_id) as total_members'))
            ->groupBy('circles.id', 'circles.name', 'circles.code')
            ->get();
        $circleusers = CircleUser::join('users', 'users.id', '=', 'circle_users.user_id')
            ->select('circle_users.circle_id', 'users.name', 'users.phone', 'users.avatar')
            ->get();
        $allcircles = [];
        foreach ($circles as $key => $circle) {
            $allcircles[$key]['circle'] = $circle;
            $allcircles[$key]['users'] = $circleusers->where('circle_id', $circle->id)->values();
        }
        return response()->json([
            'status'     => true,
            'message'    => 'All Circles',
            'code'       => 200,
            'data'       => $allcircles,
        ], 200);
    }
}
