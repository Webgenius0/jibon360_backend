@extends('backend.app', ['title' => 'index'])

@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <a class="breadcrumb-item" href="{{ route('post-category.index') }}">Post Category</a>
        <span class="breadcrumb-item @if (Route::is('post-category.create')) active @endif">Create</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <!-- <h5>Post Category</h5>
            <p>Create</p></p> -->
        </div>

        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">Social Link</h6>
            <p class="mg-b-20 mg-sm-b-30">Create</p>

            <form method="POST" action="{{ route('social-link.store') }}"  enctype="multipart/form-data">
                @csrf
                <div class="form-layout">
                    <div class="row mg-b-25">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Name: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="name" value="{{ old('name') }}" id="name">
                                <span class="text-warning">"facebook", "twitter", "youtube", "pinterest", "google", "linkedin","discord"</span>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="url">Url: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="url" value="{{ old('url') }}" id="url">
                                @error('url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <!-- <label class="form-control-label" for="icon">Icon:</label> -->
                                <input class="form-control dropify" type="file" name="icon" id="icon">
                                <span class="text-warning">* Image upload only and max size is 2MB</span>
                                @error('icon')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                    </div><!-- row -->

                    <div class="form-layout-footer">
                        <button class="btn btn-info mg-r-5" type="submit">Submit Form</button>
                        <button class="btn btn-secondary">Cancel</button>
                    </div><!-- form-layout-footer -->
                </div>
            </form>
        </div>

    </div>
    @include('backend.partials.footer')
</div>
@endsection
@push('script')
<script>
    $('.dropify').dropify();
</script>
@endpush