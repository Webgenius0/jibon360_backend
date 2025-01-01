<!DOCTYPE html>
<html lang="en">

<head>
  @include('backend.partials.meta')

  <title>Jibon360 Responsive Bootstrap 4 Admin Template</title>

  @include('backend.partials.style')
</head>

<body style="position: relative;">
  @include('backend.partials.models')

  @include('backend.partials.alert')
  <!-- ########## END: LEFT PANEL ########## -->
  @include('backend.partials.left_sidebar')
  <!-- ########## START: HEAD PANEL ########## -->
  @include('backend.partials.header')
  <!-- ########## END: HEAD PANEL ########## -->

  <!-- ########## START: RIGHT PANEL ########## -->
  @include('backend.partials.right_sidebar')
  <!-- ########## END: RIGHT PANEL ########## --->

  <!-- ########## START: MAIN PANEL ########## -->
  @yield('content')
  <!-- ########## END: MAIN PANEL ########## -->

  <!-- @include('backend.partials.loader') -->

  @include('backend.partials.script')
</body>

</html>