@extends('backend.app', ['title' => 'index'])

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <span class="breadcrumb-item @if (Route::is('profile.update')) active @endif">Profile</span>
        <span class="breadcrumb-item">{{$user->name}}</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <!-- <h5>Post Category</h5>
            <p>Create</p></p> -->
        </div>
        <div class="row">

            <div class="col-lg-6">
                <div class="card pd-20 pd-sm-40" style="height:100%">
                    <h6 class="card-body-title">Profile</h6>
                    <p class="mg-b-20 mg-sm-b-30">General settings</p>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-layout">
                            <div class="row mg-b-25">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">User Name: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" value="{{ $user->name }}" id="name">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">User Email: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="email" value="{{ $user->email }}" id="email">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div><!-- row -->

                            <div class="form-layout-footer">
                                <button class="btn btn-info mg-r-5" type="submit">General Settings Update</button>
                                <button class="btn btn-secondary">Cancel</button>
                            </div><!-- form-layout-footer -->
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card pd-20 pd-sm-40">
                    <h6 class="card-body-title">Graphical</h6>
                    <p class="mg-b-20 mg-sm-b-30">Change your logo</p>

                    <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-layout">
                            <div class="row mg-b-25">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="avatar">Avatar: <span class="tx-danger">*</span></label>
                                        <input class="form-control dropify" type="file" name="avatar" id="avatar" data-default-file="{{ $user->avatar != null && file_exists(public_path($user->avatar)) ? asset($user->avatar) : asset('default/logo.png') }}">
                                        @error('avatar')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div><!-- row -->

                            <div class="form-layout-footer">
                                <button class="btn btn-info mg-r-5" type="submit">Graphical Settings Update</button>
                                <button class="btn btn-secondary">Cancel</button>
                            </div><!-- form-layout-footer -->
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <div class="row mt-5">

            <div class="col-lg-6">
                <div class="card pd-20 pd-sm-40">
                    <h6 class="card-body-title">Password</h6>
                    <p class="mg-b-20 mg-sm-b-30">Change your password</p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="form-layout">
                            <div class="row mg-b-25">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="current_password">Current Password: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="current_password" value="" id="current_password">
                                        @error('current_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="password">New Password: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="password" value="" id="password">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="password_confirmation">Confirm Password: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="password_confirmation" value="" id="password_confirmation">
                                        @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div><!-- row -->

                            <div class="form-layout-footer">
                                <button class="btn btn-info mg-r-5" type="submit">Password Settings Update</button>
                                <button class="btn btn-secondary">Cancel</button>
                            </div><!-- form-layout-footer -->
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6"></div>
            
        </div>
    </div>
    @include('backend.partials.footer')
</div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.dropify').dropify();
</script>
@endpush