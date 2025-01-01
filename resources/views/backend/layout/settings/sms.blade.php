@extends('backend.app', ['title' => 'index'])

@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <span class="breadcrumb-item @if (Route::is('settings.sms')) active @endif">SMS</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <!-- <h5>Post Category</h5>
            <p>Create</p></p> -->
        </div>

        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">SMS Settings</h6>
            <div class="alert alert-warning mg-b-20 mg-sm-b-30 mt-4" role="alert">
                <strong>**Note:**</strong> Changing SMS settings without careful consideration can cause problems with sending SMS from your application. Make sure you have a backup of your original SMS settings before making any changes.
            </div>

            <form action="{{ route('settings.sms.update') }}" method="POST">
                @csrf
                @method('put')
                <div class="form-layout">
                    <div class="row mg-b-25">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="sms_api_key">SMS API KEY: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="sms_api_key" value="{{ env('SMS_API_KEY') }}" id="sms_api_key">
                                @error('sms_api_key')
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