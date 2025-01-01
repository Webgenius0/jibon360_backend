<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $date = date('Y-m-d H:i:s', strtotime('-24 hours'));
        $pending = Post::where('created_at', '>=', $date)->where('status', '0')->count();
        $published = Post::where('created_at', '>=', $date)->where('status', '1')->count();
        $total = Post::where('created_at', '>=', $date)->count();

        $posts = \App\Models\Post::select('latitude as lat', 'longitude as lng')
            ->where('created_at', '>=', now()->subHours(24))
            ->get()
            ->map(function ($post) {
                return [
                    'lat' => (float) $post->lat,
                    'lng' => (float) $post->lng,
                ];
            })
            ->toArray();

        return view('backend.layout.index',compact('date', 'pending', 'published', 'total', 'posts'));
    }
}
