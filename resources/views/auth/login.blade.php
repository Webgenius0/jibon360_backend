@extends('auth.app', ['title' => 'Login'])

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Enter your username" name="email" value="{{ old('email') }}">
        @error('email')
        <span class="text-danger">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div><!-- form-group -->
    <div class="form-group">
        <input type="password" class="form-control" placeholder="Enter your password" name="password" value="{{ old('password') }}">
        @error('password')
        <span class="text-danger">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <a href="{{ route('password.request') }}" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a>
    </div><!-- form-group -->
    <button type="submit" class="btn btn-info btn-block">Sign In</button>
</form>
@endsection