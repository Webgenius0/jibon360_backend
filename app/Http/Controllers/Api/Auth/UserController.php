<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\CircleUser;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me()
    {
        return response()->json([
            'status'     => true,
            'code'       => 200,
            'token_type' => 'bearer',
            'data'       => auth('api')->user(),
        ], 200);
    }
    public function deleteAccount()
    {
        try {
            CircleUser::where('user_id', auth('api')->user()->id)->delete();
            User::find(auth('api')->user()->id)->delete();
            auth('api')->logout();
            return response()->json([
                'status'     => true,
                'message'    => 'Account deleted successfully',
                'code'       => 200,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'     => false,
                'message'    => $th->getMessage(),
                'code'       => 200,
            ], 200);
        }
    }
}
