<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function emergencyContact()
    {
        $emergencyContacts = EmergencyContact::where('status', '1')->get();
        return response()->json([
            'success' => true,
            'message' => 'Emergency Contacts',
            'code' => 200,
            'data' => $emergencyContacts
        ], 200);
    }

    public function info()
    {
        $user = Auth::user();
        $date = now()->subHours(48); // Using `now()` for better readability
        $query = Post::where('created_at', '>=', $date);

        // Apply district filter for moderators
        if ($user->role == 'moderator') {
            $permissions = $user->permissions->pluck('district')->toArray();
            $query->whereIn('district', $permissions);
        }

        // Aggregating counts in a single query
        $counts = $query->selectRaw("
        COUNT(*) as total,
        SUM(status = '0') as pending,
        SUM(status = '1') as published
    ")->first();

        return response()->json([
            'success' => true,
            'message' => 'Info',
            'code' => 200,
            'data' => [
                'pending'   => (int)$counts->pending,
                'published' => (int)$counts->published,
                'total'     => (int)$counts->total
            ]
        ], 200);
    }
}
