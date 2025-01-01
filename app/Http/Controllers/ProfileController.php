<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('backend.layout.settings.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    /* public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    } */
   public function avatar(Request $request)
    {
        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $user = User::find(Auth::user()->id);

        if (!empty($request['avatar'])) {
            $avatar = Str::random(10);
            if (empty($user->avatar)) {
                // Upload New Avatar
                $avatar = Helper::fileUpload($request->avatar, 'profile', $avatar);
            } else {
                // Remove Old File
                if (file_exists(public_path('/') . $user->avatar)){
                    unlink(public_path('/') . $user->avatar);
                }

                // Upload New Avatar
                $avatar = Helper::fileUpload($request->avatar, 'profile', $avatar);
            }
            $user->avatar = $avatar;

            $user->update();
            flash()->success('Avatar Updated');
            return back();
        }
        flash()->error('Something went wrong. Please try again.');
        return back();
    }
}
