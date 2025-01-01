<?php

namespace App\Http\Controllers;

use App\Models\Setting;

abstract class Controller
{
    public function __construct()
    {
        Setting::firstOrCreate([], [
            'favicon' => null,
            'logo' => null,
            'title' => 'My Laravel Site',
            'site' => 'https://mylarsite.com',
            'keywords' => 'Laravel, AdminLTE, PHP',
            'description' => 'This is a description for my Laravel site.',
            'author' => 'John Doe',
            'email' => 'example@example.com',
            'phone' => '123-456-7890',
            'copyright' => ' 2024 Your Company Name',
            'address' => '123 Main Street, Hometown, USA',
        ]);
    }
}
