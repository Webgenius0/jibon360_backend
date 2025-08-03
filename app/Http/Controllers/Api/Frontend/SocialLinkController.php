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
            ->get(['id', 'name', 'icon', 'url']);

        return response()->json([
            'success' => true,
            'message' => 'Social links retrieved successfully.',
            'data' => $socialLinks,
        ])->setStatusCode(200);
    }
       
    
}
