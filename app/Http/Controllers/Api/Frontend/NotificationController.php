<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $notifications = auth('api')->user()->unreadNotifications;
            return response()->json([
                'status'     => true,
                'message'    => 'All Notifications',
                'code'       => 200,
                'data'       => $notifications,
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back();
        }
    }
    public function readSingle($id)
    {
        try {
            $notification = auth('api')->user()->notifications()->find($id);
            if($notification) {
                $notification->markAsRead();
            }
            return response()->json([
                'status'     => true,
                'message'    => 'Single Notification',
                'code'       => 200,
                'data'       => $notification
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back();
        }
    }
    public function readAll()
    {
        try {
            auth('api')->user()->notifications->markAsRead();
            return response()->json([
                'status'     => true,
                'message'    => 'All Notifications Marked As Read',
                'code'       => 200,
                'data'       => null
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back();
        }
    }
}
