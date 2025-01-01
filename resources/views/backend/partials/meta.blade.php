@php
    use App\Models\Setting;
    $setting = Setting::latest( 'id' )->first();
@endphp

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Twitter -->
<meta name="twitter:site" content="{{ $setting->site ? $setting->site : '@Jibon360' }}">
<meta name="twitter:creator" content="{{ $setting->author ? $setting->author : '@bdCalling' }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $setting->title ? $setting->title : 'Jibon360' }}">
<meta name="twitter:description" content="{{ $setting->description ? $setting->description : 'Premium Quality and Responsive UI for Dashboard.' }}">
<meta name="twitter:image" content="{{ $setting->logo ? asset($setting->logo) : asset('default/logo.png') }}">

<!-- Facebook -->
<meta property="og:url" content="{{ $setting->site ? $setting->site : '@Jibon360' }}">
<meta property="og:title" content="{{ $setting->title ? $setting->title : 'Jibon360' }}">
<meta property="og:description" content="{{ $setting->description ? $setting->description : 'Premium Quality and Responsive UI for Dashboard.' }}">

<meta property="og:image" content="{{ $setting->logo ? asset($setting->logo) : asset('default/logo.png') }}">
<meta property="og:image:secure_url" content="{{ $setting->logo ? asset($setting->logo) : asset('default/logo.png') }}">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="600">

<!-- Meta -->
<meta name="description" content="{{ $setting->description ? $setting->description : 'Premium Quality and Responsive UI for Dashboard.' }}">
<meta name="author" content="{{ $setting->author ? $setting->author : 'ThemePixels' }}">
<link rel="icon" type="image/png" href="{{ $setting->favicon ? asset($setting->favicon) : asset('default/logo.png') }}">
<meta name="keywords" content="{{ $setting->keywords ? $setting->keywords : 'Jibon360, responsive, ui, admin, dashboard, template, theme, html, css, bootstrap, sass, scss, javascript, jquery, laravel, php, mysql, responsive, bootstrap 4, admin template, dashboard template' }}">
<title>{{ $setting->title ? $setting->title : 'Jibon360' }}</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

@stack('meta')