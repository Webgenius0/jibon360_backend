@extends('backend.app', ['title' => 'index'])

@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <span class="breadcrumb-item active">Social</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <!-- <h5>Post Category</h5>
            <p>Create</p></p> -->
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card pd-20 pd-sm-40">
                    <h6 class="card-body-title"><i class="bi bi-facebook tx-30"></i>acebook Settings</h6>
                    <div class="alert alert-warning mg-b-20 mg-sm-b-30 mt-4" role="alert">
                        <strong>**Note:**</strong> Changing Facebook settings without careful consideration can cause problems with sending emails from your application. Make sure you have a backup of your original Facebook settings before making any changes.
                    </div>

                    <form action="{{ route('settings.facebook.update') }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-layout">
                            <div class="row mg-b-25">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="facebook_client_id">FACEBOOK CLIENT ID: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="facebook_client_id" value="{{ env('FACEBOOK_CLIENT_ID') }}" id="facebook_client_id">
                                        @error('facebook_client_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="facebook_client_secret">FACEBOOK CLIENT SECRET: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="facebook_client_secret" value="{{ env('FACEBOOK_CLIENT_SECRET') }}" id="facebook_client_secret">
                                        @error('facebook_client_secret')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="facebook_redirect_uri">MAIL PORT: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="facebook_redirect_uri" value="{{ env('FACEBOOK_REDIRECT_URI') }}" id="facebook_redirect_uri">
                                        @error('facebook_redirect_uri')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div><!-- row -->

                            <div class="form-layout-footer">
                                <button class="btn btn-info mg-r-5" type="submit">Facebook Settings Update</button>
                                <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Cancel</button>
                            </div><!-- form-layout-footer -->
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card pd-20 pd-sm-40">
                    <h6 class="card-body-title"><i class="bi bi-google tx-30"></i>oogle Settings</h6>
                    <div class="alert alert-warning mg-b-20 mg-sm-b-30 mt-4" role="alert">
                        <strong>**Note:**</strong> Changing Google settings without careful consideration can cause problems with sending emails from your application. Make sure you have a backup of your original Google settings before making any changes.
                    </div>

                    <form action="{{ route('settings.google.update') }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-layout">
                            <div class="row mg-b-25">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="google_client_id">GOOGLE CLIENT ID: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="google_client_id" value="{{ env('GOOGLE_CLIENT_ID') }}" id="google_client_id">
                                        @error('google_client_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="google_client_secret">GOOGLE CLIENT SECRET: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="google_client_secret" value="{{ env('GOOGLE_CLIENT_SECRET') }}" id="google_client_secret">
                                        @error('google_client_secret')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="google_redirect_uri">MAIL PORT: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="google_redirect_uri" value="{{ env('GOOGLE_REDIRECT_URI') }}" id="google_redirect_uri">
                                        @error('google_redirect_uri')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div><!-- row -->

                            <div class="form-layout-footer">
                                <button class="btn btn-info mg-r-5" type="submit">Google Settings Update</button>
                                <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Cancel</button>
                            </div><!-- form-layout-footer -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.footer')
</div>
@endsection