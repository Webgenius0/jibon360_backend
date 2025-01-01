<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reach;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ReachController extends Controller
{
    public function status(Request $request, $post_id, $status)
    {
        // Validate the request
        $validator = Validator::make(['status' => $status], [
            'status' => 'required|in:like,dislike',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Ensure the user is authenticated
        $user_id = auth('api')->user()->id;

        // Ensure the post exists
        $post = Post::find($post_id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found.',
            ], 404);
        }

        // Find or create the Reach record
        $data = Reach::firstOrCreate(['post_id' => $post_id, 'user_id' => $user_id]);

        // Check if the record was recently created
        $isCreated = !$data->wasRecentlyCreated;

        // Update the status
        if ($data->status === $status) {
            $data->update(['status' => 'none']);
        } else {
            $data->update(['status' => $status]);
        }

        // Return the response
        return response()->json([
            'success' => true,
            'code' => $isCreated ? 201 : 200,
            'message' => $isCreated ? 'Created Successfully.' : 'Updated Successfully.',
            'data' => $data,
        ], $isCreated ? 201 : 200);
    }

}
