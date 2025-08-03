<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Models\SocialLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialLinkController extends Controller
{
    public function index()
{
    $socialLinks = SocialLink::where('status', 1)
        ->orderBy('id', 'desc')
        ->get();

    $socialLinks = $socialLinks->map(function ($socialLink) {
        return [
            'id'   => $socialLink->id,
            'name' => $socialLink->name,
            'icon' => $socialLink->icon 
                ? asset($socialLink->icon)
                : asset('default/logo.png'),
            'url'  => $socialLink->url,
        ];
    });

    return response()->json([
        'success' => true,
        'message' => 'Social links retrieved successfully.',
        'data' => $socialLinks,
    ], 200);
}

    
}
