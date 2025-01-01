@extends('backend.app', ['title' => 'index'])

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <span class="breadcrumb-item @if (Route::is('settings.general')) active @endif">General</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <!-- <h5>Post Category</h5>
            <p>Create</p></p> -->
        </div>
        <div class="row">

            <div class="col-lg-6">
                <div class="card pd-20 pd-sm-40">
                    <h6 class="card-body-title">General</h6>
                    <p class="mg-b-20 mg-sm-b-30">General settings</p>

                    <form method="POST" action="{{ route('settings.general.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="form-layout">
                            <div class="row mg-b-25">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="site">Site: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="site" value="{{ $settings->site }}" id="site">
                                        @error('site')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="title">Title: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="title" value="{{ $settings->title }}" id="title">
                                        @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="author">Author: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="author" value="{{ $settings->author }}" id="author">
                                        @error('author')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="keywords">Keywords: <span class="tx-danger">*</span></label>
                                        <p class="mg-b-5 tx-12 tx-gray-600">Example: "blog,article,journal,news"</p>
                                        <input class="form-control" type="text" name="keywords" value="{{ $settings->keywords }}" id="keywords">
                                        @error('keywords')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="description">Description: <span class="tx-danger">*</span></label>
                                        <textarea class="form-control" name="description" id="description">{{ $settings->description }}</textarea>
                                        @error('description')
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
                <div class="card pd-20 pd-sm-40" style="height: 100%">
                    <h6 class="card-body-title">Graphical</h6>
                    <p class="mg-b-20 mg-sm-b-30">Change your logo</p>

                    <form method="POST" action="{{ route('settings.general.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-layout">
                            <div class="row mg-b-25">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="favicon">Favicon: <span class="tx-danger">*</span></label>
                                        <input class="form-control dropify" type="file" name="favicon" id="favicon" data-default-file="{{ $settings->favicon != null && file_exists(public_path($settings->favicon)) ? asset($settings->favicon) : asset('default/logo.png') }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="logo">Logo: <span class="tx-danger">*</span></label>
                                        <input class="form-control dropify" type="file" name="logo" id="logo" data-default-file="{{ $settings->logo != null && file_exists(public_path($settings->logo)) ? asset($settings->logo) : asset('default/logo.png') }}">
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
                <div class="card pd-20 pd-sm-40" style="height: 100%">
                    <h6 class="card-body-title">Personal Information</h6>
                    <p class="mg-b-20 mg-sm-b-30">Change your personal information</p>

                    <form method="POST" action="{{ route('settings.general.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="form-layout">
                            <div class="row mg-b-25">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="email" value="{{ $settings->email }}" id="email">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="phone">Phone: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="phone" value="{{ $settings->phone }}" id="phone">
                                        @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="address">Address: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="address" value="{{ $settings->address }}" id="address">
                                        @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div><!-- row -->

                            <div class="form-layout-footer">
                                <button class="btn btn-info mg-r-5" type="submit">Personal Information Update</button>
                                <button class="btn btn-secondary">Cancel</button>
                            </div><!-- form-layout-footer -->
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card pd-20 pd-sm-40" style="height: 100%">
                    <h6 class="card-body-title">Other Settings</h6>
                    <p class="mg-b-20 mg-sm-b-30">Change your logo</p>

                    <form method="POST" action="{{ route('settings.general.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-layout">
                            <div class="row mg-b-25">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="copyright">Copyright: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="copyright" value="{{ $settings->copyright }}" id="copyright">
                                        @error('copyright')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div><!-- row -->

                            <div class="form-layout-footer">
                                <button class="btn btn-info mg-r-5" type="submit">Other Settings Update</button>
                                <button class="btn btn-secondary">Cancel</button>
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

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.dropify').dropify();
</script>
@endpush