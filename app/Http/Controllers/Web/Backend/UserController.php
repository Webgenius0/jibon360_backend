<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserWarringNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['circles','posts', 'sos'])->where('id', '!=', auth()->id())->get();
        $usersCount = $users->count();
        return view('backend.layout.users', compact('users', 'usersCount'));
    }

    public function status($id){
        $user = User::find($id);
        if($user->status == 'active'){
            $user->update(['status' => 'inactive']);
        }else{
            $user->update(['status' => 'active']);
        }
        return back()->with('t-success', 'Update successfully.');
    }

    public function warraning(Request $request, $user_id){

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string|max:100',
        ]);

        $notiData = [
            'user_id' => $user_id,
            'title' => $request->title,
            'description' => $request->description,
        ];

        $user = User::find($user_id);
        //dd($user);
        $user->update([
            'warraning' => $user->warraning + 1
        ]);

        if ($user) {
            $user->notify(new UserWarringNotify($notiData));
            return back()->with('t-success', 'warraning successfully sent.');
        }

        return back()->with('t-error', 'User not found.');
    }
}
