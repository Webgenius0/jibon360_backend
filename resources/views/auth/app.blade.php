<!DOCTYPE html>
<html lang="en">

<head>
  @include('backend.partials.meta')

  <title>Jibon360 Responsive Bootstrap 4 Admin Template</title>

  <!-- vendor css -->
  <link href="{{asset('backend')}}/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="{{asset('backend')}}/lib/Ionicons/css/ionicons.css" rel="stylesheet">


  <!-- Jibon360 CSS -->
  <link rel="stylesheet" href="{{asset('backend')}}/css/jibon360.css">
</head>

<body>
  <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">
    <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
      <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">{{ config('app.name') }} <span class="tx-info tx-normal">admin</span></div>
      <div class="tx-center mg-b-60">{{ isset($title) ? $title : 'Jibon360' }}</div>
      @yield('content')
      <!-- <div class="mg-t-60 tx-center">Not yet a member? <a href="page-signup.html" class="tx-info">Sign Up</a></div> -->
    </div>
  </div>
  <script src="{{asset('backend')}}/lib/jquery/jquery.js"></script>
  <script src="{{asset('backend')}}/lib/popper.js/popper.js"></script>
  <script src="{{asset('backend')}}/lib/bootstrap/bootstrap.js"></script>

</body>

</html>