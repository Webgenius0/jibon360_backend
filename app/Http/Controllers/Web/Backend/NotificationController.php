<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        $notifications = auth('web')->user()->unreadNotifications;
        return view('backend.notification.index', compact('notifications'));
    }
    public function readSingle($id)
    {
        try {
            $notification = auth('web')->user()->notifications()->find($id);
            if($notification) {
                $notification->markAsRead();
            }
            return back();
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return back();
        }
    }
    public function readAll()
    {
        try {
            auth('web')->user()->notifications->markAsRead();
            return back();
        } catch (Exception $e) {
            flash()->error($e->getMessage());
            return back();
        }
    }
}
