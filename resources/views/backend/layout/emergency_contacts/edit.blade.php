@extends('backend.app', ['title' => 'index'])

@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <a class="breadcrumb-item" href="{{ route('emergency-contacts.index') }}">Emergency Contacts</a>
        <span class="breadcrumb-item @if (Route::is('emergency-contacts.create')) active @endif">Create</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <!-- <h5>Emergency Contacts</h5>
            <p>Create</p></p> -->
        </div>

        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">Emergency Contacts</h6>
            <p class="mg-b-20 mg-sm-b-30">Edit</p>

            <form method="POST" action="{{ route('emergency-contacts.update') }}"  enctype="multipart/form-data">
                @csrf
                <div class="form-layout">
                    <div class="row mg-b-25">

                        <input type="hidden" name="id" value="{{ $emergencyContact->id }}">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Name: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="name" value="{{ $emergencyContact->name }}" id="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> 
                        
                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <!-- <label class="form-control-label" for="icon">Icon:</label> -->
                                <input class="form-control dropify" type="file" name="icon" id="icon" data-default-file="{{ asset($emergencyContact->icon) }}">
                                <span class="text-warning">* Image upload only and max size is 2MB</span>
                                @error('icon')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="phone">Phone: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="phone" value="{{ $emergencyContact->phone }}" id="phone" readonly>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="location">Location: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="location" value="{{ $emergencyContact->location }}" id="location">
                                @error('location')
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