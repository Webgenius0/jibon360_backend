@extends('backend.app', ['title' => 'index'])

@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <span class="breadcrumb-item @if (Route::is('settings.mail')) active @endif">Mail</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <!-- <h5>Post Category</h5>
            <p>Create</p></p> -->
        </div>

        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">Mail Settings</h6>
            <div class="alert alert-warning mg-b-20 mg-sm-b-30 mt-4" role="alert">
                <strong>**Note:**</strong> Changing email settings without careful consideration can cause problems with sending emails from your application. Make sure you have a backup of your original email settings before making any changes.
            </div>

            <form action="{{ route('settings.mail.update') }}" method="POST">
                @csrf
                @method('put')
                <div class="form-layout">
                    <div class="row mg-b-25">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="mail_mailer">MAIL MAILER: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="mail_mailer" value="{{ env('MAIL_MAILER') }}" id="mail_mailer">
                                @error('mail_mailer')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="mail_host">MAIL HOST: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="mail_host" value="{{ env('MAIL_HOST') }}" id="mail_host">
                                @error('mail_host')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="mail_port">MAIL PORT: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="mail_port" value="{{ env('MAIL_PORT') }}" id="mail_port">
                                @error('mail_port')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="mail_username">MAIL USERNAME: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="mail_username" value="{{ env('MAIL_USERNAME') }}" id="mail_username">
                                @error('mail_username')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="mail_password">MAIL PASSWORD: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="mail_password" value="{{ env('MAIL_PASSWORD') }}" id="mail_password">
                                @error('mail_password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="mail_encryption">MAIL ENCRYPTION: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="mail_encryption" value="{{ env('MAIL_ENCRYPTION') }}" id="mail_encryption">
                                @error('mail_encryption')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="mail_from_address">MAIL FORM ADDRESS: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="mail_from_address" value="{{ env('MAIL_FROM_ADDRESS') }}" id="mail_from_address">
                                @error('mail_from_address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div><!-- row -->

                    <div class="form-layout-footer">
                        <button class="btn btn-info mg-r-5" type="submit">Submit Form</button>
                        <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Cancel</button>
                    </div><!-- form-layout-footer -->
                </div>
            </form>
        </div>

    </div>
    @include('backend.partials.footer')
</div>
@endsection