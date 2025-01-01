<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Notifications\StatusPaid;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function index(Request $request, $status = null)
    {

        if ($request->ajax()) {

            $date = date('Y-m-d H:i:s', strtotime('-48 hours'));
            $data = Post::with(['postCategtory:id,name,image', 'user:id,name', 'postImages:id,image'])->where('created_at', '>', $date);
            if ($status != null) {
                $data->where('status', $status);
            }
            if(Auth::user()->role == 'moderator'){
                $permissions = Auth::user()->permissions->pluck('district')->toArray();
                $data->whereIn('district', $permissions);
            }
            $data->orderBy('id', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    $status = ' <div class="form-check form-switch">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input d-none" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
                    if ($data->status == 1) {
                        $status .= "checked";
                    }
                    $status .= '>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label">';
                    if ($data->status == 1) {
                        $status .= "<img style='width: 20px;' src='" . asset('default/on.png') . "'>";
                    } else {
                        $status .= "<img style='width: 20px;' src='" . asset('default/off.png') . "'>";
                    }
                    $status .= '</label></div>';
                    return $status;
                })
                ->addColumn('action', function ($data) {
                    $html = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">';
                    $html .= "<button onclick='openModel(" . json_encode($data) . ")' class='btn btn-sm btn-success'><i class='bi bi-info-circle-fill'></i></button>";
                    $html .= "<a href='" . route('post.show', $data->id) . "' class='btn btn-sm btn-primary'><i class='bi bi-eye-fill'></i></a>";
                    /* $html .= "<a href='#' class='btn btn-sm btn-danger' onclick='alert('you can't delete this post')' ><i class='bi bi-trash-fill'></i></a>"; */
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['status', 'action'])
                ->make();
        }
        return view('backend.layout.post.index', compact('status'));
    }
    public function history(Request $request, $status = null)
    {
        if ($request->ajax()) {
            $data = Post::with(['postCategtory:id,name,image', 'user:id,name', 'postImages:id,image']);
            if ($status != null) {
                $data->where('status', $status);
            }
            if(Auth::user()->role == 'moderator'){
                $permissions = Auth::user()->permissions->pluck('district')->toArray();
                $data->whereIn('district', $permissions);
            }
            $data->orderBy('id', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $html = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">';
                    $html .= "<button onclick='openModel(" . json_encode($data) . ")' class='btn btn-sm btn-success'><i class='bi bi-info-circle-fill'></i></button>";
                    $html .= "<a href='" . route('post.show', $data->id) . "' class='btn btn-sm btn-primary'><i class='bi bi-eye-fill'></i></a>";
                    /* $html .= "<a href='#' class='btn btn-sm btn-danger' onclick='alert('you can't delete this post')' ><i class='bi bi-trash-fill'></i></a>"; */
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('backend.layout.post.history', compact('status'));
    }


    public function report(Request $request)
    {

        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));


        $data = Post::with(['postCategtory:id,name,image', 'user:id,name', 'postImages:id,image'])->whereYear('created_at', $year)->whereMonth('created_at', $month);

        $day = $request->input('day');
        if ($day) {
            $data->whereDay('created_at', $day);
        }

        $post_category_id = $request->input('post_category_id');
        if ($post_category_id) {
            $data->where('post_category_id', $post_category_id);
        }

        $location = $request->input('location');
        if ($location) {
            $data->where('location', $location);
        }

        $posts = $data->orderBy('id', 'desc')->get();
        $postMaps = $data->select('latitude', 'longitude')
            ->get()
            ->map(function ($post) {
                return [
                    'lat' => (float) $post->latitude,
                    'lng' => (float) $post->longitude,
                ];
            })
            ->toArray();

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = Carbon::create($year, $month, 1)->endOfMonth();
        $dailyPosts = [];
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $dailyPosts[] = Post::whereDate('created_at', $date)->count();
        }


        $categories = PostCategory::all();
        $locations = Post::select('location')->distinct()->get();

        return view('backend.layout.post.report', compact('posts', 'postMaps', 'dailyPosts', 'categories', 'locations'));
    }

    public function status($id)
    {
        $data = Post::with(['postCategtory:id,name,image', 'user:id,name'])->where('id', $id)->first();
        $user = User::where('id', $data->user_id)->first();

        if (Auth::user()->role == 'moderator') {
            $permissions = Auth::user()->permissions->pluck('district')->toArray();
            if (!in_array($data->district, $permissions)) {
                return response()->json([
                    'error' => true,
                    'message' => 'you have no permission',
                ]);
            }
        }

        $title = "";
        if ($data->status == 1) {
            $data->status = '0';
            $title = "your post is unpublished";
            $data->save();

            // send notification start
            $notiData = [
                'title' => $title,
                'description' => Str::limit($data->description, 50),
                'status' => $data->status,
                'created_at' => $data->created_at,
            ];
            if ($user) {
                $user->notify(new StatusPaid($notiData));
            }
            // send notification end

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
            ]);
        } else {
            $data->status = '1';
            $title = "your post is published";
            $data->save();
            // send notification start
            $notiData = [
                'title' => $title,
                'description' => Str::limit($data->description, 50),
                'status' => $data->status,
                'created_at' => $data->created_at,
            ];
            if ($user) {
                $user->notify(new StatusPaid($notiData));
            }
            // send notification end
            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
            ]);
        }
    }

    public function show($id, $notify = null)
    {
        $notification = null;
        if ($notify) {
            $notification = auth('web')->user()->notifications()->find($notify);
            if ($notification) {
                $notification->markAsRead();
            }
        }
        $post = Post::with(['postCategtory:id,name,image', 'postImages:id,post_id,image'])->findOrFail($id);
        // check permission
        if (Auth::user()->role == 'moderator') {
            $permissions = Auth::user()->permissions->pluck('district')->toArray();
            if (!in_array($post->district, $permissions)) {
                abort(403, 'Unauthorized action.');
            }
        }
        return view('backend.layout.post.show', compact('post', 'notification'));
    }
}
