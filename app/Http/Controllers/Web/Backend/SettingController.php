<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::latest('id')->first();
        return view('backend.layout.settings.general', compact('settings'));
    }
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $setting = Setting::latest('id')->first();

        // Check Exit Of Setting
        if ($setting == null) {
            $setting = new Setting();
        }
        //site settings
        if(!empty($request->title)){
            $setting->title = $request->title;
        }

        if(!empty($request->site)){
            $setting->site = $request->site;
        }

        if(!empty($request->description)){
            $setting->description = $request->description;
        }

        if(!empty($request->keywords)){
            $setting->keywords = $request->keywords;
        }

        if(!empty($request->author)){
            $setting->author = $request->author;
        }
        //personel settings
        if(!empty($request->email)){
            $setting->email = $request->email;
        }
        if(!empty($request->phone)){
            $setting->phone = $request->phone;
        }
        if(!empty($request->address)){
            $setting->address = $request->address;
        }

        //other settings
        if(!empty($request->copyright)){
            $setting->copyright = $request->copyright;
        }

        // Upload Logo
        if (!empty($request['logo'])) {
            if (empty($setting->logo)) {
                // Upload New Logo
                $logo = Helper::fileUpload($request->logo, 'settings', 'logo');
            } else {
                // Remove Old File
                @unlink(public_path('/') . $setting->logo);

                // Upload New Logo
                $logo = Helper::fileUpload($request->logo, 'settings', 'logo');
            }
            $setting->logo = $logo;
        }

        // Upload Favicon
        if (!empty($request['favicon'])) {
            if (empty($setting->favicon)) {
                // Upload New Favicon
                $favicon = Helper::fileUpload($request->favicon, 'settings', 'favicon');
            } else {
                // Remove Old File
                @unlink(public_path('/') . $setting->favicon);

                // Upload New Favicon
                $favicon = Helper::fileUpload($request->favicon, 'settings', 'favicon');
            }
            $setting->favicon = $favicon;
        }

        $setting->save();

        flash()->success('Updated successfully');
        return redirect()->route('settings.general')->with('t-success', 'Update successfully.');
    }
}
