<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostImage;
use App\Models\User;
use App\Notifications\PostNoti;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index($cat = 0)
    {
        /* $date = date('Y-m-d H:i:s', strtotime('-24 hours'));
        if ($cat == 0) {
            $posts = Post::with('postCategtory:id,name')->where('status', 1)->where('created_at', '>', $date)->orderBy('id', 'desc')->get();
        } else {

            //validate category
            $category = PostCategory::find($cat);
            if (!$category) {
                return Helper::jsonResponse(false, 'Category does not exist', 404);
            }

            $posts = Post::with('postCategtory:id,name')->where('status', 1)->where('post_category_id', $cat)->where('created_at', '>', $date)->orderBy('id', 'desc')->get();
        }
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $posts); */
    }
    public function myPosts($cat = 0)
    {
        $posts = Post::with(['postCategtory:id,name,image', 'postImages:id,post_id,image'])->where('user_id', auth()->user()->id);
        $category = PostCategory::find($cat);
        if ($category && $cat > 0) {
            $posts = $posts->where('post_category_id', $cat);
        }
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $posts->orderBy('id', 'desc')->get());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'post_category_id' => 'required',
            'i_am_hard' => 'required',
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
            'report_date' => 'required|date_format:Y-m-d H:i',
            'district' => 'required',
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            $post = new Post();
            $post->user_id = auth('api')->user()->id;

            //validate category
            $category = PostCategory::find($request->post_category_id);
            if (!$category) {
                return Helper::jsonResponse(false, 'Category does not exist', 404);
            }

            $post->post_category_id = $request->post_category_id;
            $post->i_am_hard = $request->i_am_hard;
            $post->location = $request->location;
            $post->latitude = $request->latitude;
            $post->longitude = $request->longitude;
            $post->description = $request->description;
            $post->report_date = $request->report_date;
            $post->district = $request->district;
            $post->save();

            //image upload code start
            if (!empty($request['images']) && count($request['images']) > 0 && count($request['images']) <= 3) {
                foreach ($request['images'] as $image) {
                    $imageName = 'images_' . Str::random(10);
                    $image = Helper::fileUpload($image, 'posts', $imageName);
                    PostImage::create(['post_id' => $post->id, 'image' => $image]);
                }
            }else{
                return Helper::jsonResponse(false, 'Maximum 3 images allowed', 422, $validator->errors());
            }
            //image upload code end

            //database notification code start
            $users = User::where('role', 'admin')->get();
            $notiData = [
                'post_id' => $post->id,
                'avatar' => Auth::user()->avatar != null ? Auth::user()->avatar : "",
                'type' => 'post',
                'url' => '/dashboard/post/' . $post->id,
                'message' => 'New post created by ' . Auth::user()->name
            ];
            foreach($users as $user){
                $user->notify(new PostNoti($notiData));
            }
            //database notification code end

            $post = Post::with(['postCategtory:id,name,image', 'postImages:id,post_id,image'])->where('id', $post->id)->first();

            return Helper::jsonResponse(true, 'Post created successfully', 200, $post);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred while creating new post', 500, ['error' => $e->getMessage()]);
        }
    }

    public function show(Post $post, $id)
    {
        $posts = Post::with(['postCategtory:id,name,image', 'postImages:id,post_id,image'])->where('id', $id)->get();
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $posts);
    }

    public function edit(Post $post, $id)
    {
        $posts = Post::with('postCategtory:id,name,image')->where('user_id', auth()->user()->id)->where('id', $id)->get();
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $posts);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        /* $validator = Validator::make($request->all(), [
            'post_category_id' => 'required',
            'i_am_hard' => 'required',
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
            //'report_date' => 'required|date_format:Y-m-d',
            'report_date' => 'required',
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            $post = Post::find($request->id);

            //validate category
            $category = PostCategory::find($cat);
            if (!$category) {
                return Helper::jsonResponse(false, 'Category does not exist', 404);
            }

            $post->post_category_id = $request->post_category_id;
            $post->i_am_hard = $request->i_am_hard;
            $post->location = $request->location;
            $post->latitude = $request->latitude;
            $post->longitude = $request->longitude;
            $post->description = $request->description;
            $post->report_date = $request->report_date;
            $post->save();
            return Helper::jsonResponse(true, 'Post updated successfully', 200, $post);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred while creating new post', 500, ['error' => $e->getMessage()]);
        } */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, $id)
    {
        $post = Post::find($id);
        if ($post->user_id != auth()->user()->id) {
            return Helper::jsonResponse(false, 'You are not authorized to delete this post', 401);
        }
        $post->delete();
        return Helper::jsonResponse(true, 'Post deleted successfully', 200, $post);
    }

    public function postCategory()
    {
        $posts = PostCategory::all();
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $posts);
    }
}
