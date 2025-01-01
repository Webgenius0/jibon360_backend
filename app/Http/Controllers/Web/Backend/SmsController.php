<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SmsController extends Controller
{
    public function index()
    {
        return view('backend.layout.settings.sms');
    }
    public function update(Request $request)
    {

        $request->validate([
            'sms_api_key' => 'required|string',
        ]);

        try {
            $envContent = File::get(base_path('.env'));
            $lineBreak = "\n";
            $envContent = preg_replace([
                '/SMS_API_KEY=(.*)\s/',
            ], [
                'SMS_API_KEY=' . $request->sms_api_key . $lineBreak,
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
