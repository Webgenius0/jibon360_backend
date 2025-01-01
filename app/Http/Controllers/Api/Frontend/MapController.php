<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
class MapController extends Controller
{

    public function index(float $lat = 0, float $long = 0, $cat = 0)
    {
        $category = PostCategory::find($cat);
        if (!$category && $cat != 0) {
            return Helper::jsonResponse(false, 'Category does not exist', 404);
        }
        $posts = Post::scopeNearby($lat, $long, $cat);
        
        return Helper::jsonResponse(true, 'Posts fetched successfully', 200, $posts);
    }
}
