<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SocialController extends Controller
{
    public function index()
    {
        return view('backend.layout.settings.social');
    }
    public function facebook(Request $request)
    {

        $request->validate([
            'facebook_client_id' => 'required|string|max:255',
            'facebook_client_secret' => 'required|string|max:255',
            'facebook_redirect_uri' => 'required|string|max:255',
        ]);

        try {
            $envContent = File::get(base_path('.env'));
            $lineBreak = "\n";
            $envContent = preg_replace([
                '/FACEBOOK_CLIENT_ID=(.*)\s/',
                '/FACEBOOK_CLIENT_SECRET=(.*)\s/',
                '/FACEBOOK_REDIRECT_URI=(.*)\s/',
            ], [
                'FACEBOOK_CLIENT_ID=' . $request->facebook_client_id . $lineBreak,
                'FACEBOOK_CLIENT_SECRET=' . $request->facebook_client_secret . $lineBreak,
                'FACEBOOK_REDIRECT_URI=' . $request->facebook_redirect_uri . $lineBreak,
            ], $envContent);

            if ($envContent !== null) {
                File::put(base_path('.env'), $envContent);
            }
            flash()->success('Updated successfully');
            return back()->with('t-success', 'Updated successfully');
        } catch (Exception $e) {
            flash()->error('Failed to update');
            return back()->with('t-error', 'Failed to update');
        }
    }

    public function google(Request $request)
    {
        $request->validate([
            'google_client_id' => 'required|string|max:255',
            'google_client_secret' => 'required|string|max:255',
            'google_redirect_uri' => 'required|string|max:255',
        ]);

        try {
            $envContent = File::get(base_path('.env'));
            $lineBreak = "\n";
            $envContent = preg_replace([
                '/GOOGLE_CLIENT_ID=(.*)\s/',
                '/GOOGLE_CLIENT_SECRET=(.*)\s/',
                '/GOOGLE_REDIRECT_URI=(.*)\s/',
            ], [
                'GOOGLE_CLIENT_ID=' . $request->google_client_id . $lineBreak,
                'GOOGLE_CLIENT_SECRET=' . $request->google_client_secret . $lineBreak,
                'GOOGLE_REDIRECT_URI=' . $request->google_redirect_uri . $lineBreak,
            ], $envContent);

            if ($envContent !== null) {
                File::put(base_path('.env'), $envContent);
            }
            flash()->success('Updated successfully');
            return back()->with('t-success', 'Updated successfully');
        } catch (Exception $e) {
            flash()->error('Failed to update');
            return back()->with('t-error', 'Failed to update');
        }
    }
}