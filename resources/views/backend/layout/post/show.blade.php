@extends('backend.app', ['title' => 'index'])

@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <span class="breadcrumb-item active">Post</a>
        <span class="breadcrumb-item active">Show</span>
    </nav>

    <div class="sl-pagebody">
        <!-- <div class="sl-page-title">
            <h5>Data Table</h5>
            <p>DataTables is a plug-in for the jQuery Javascript library.</p>
        </div> -->

        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">Category :- {{ $post->postCategtory->name ?? '' }}</h6>
            <span class="mg-b-20 mg-sm-b-30">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
            <span class="mg-b-20 mg-sm-b-30">{{ $post->description }}</span>
            
            <div class="row">
                @foreach ($post->postImages as $img)
                    <div class="col-md-3">
                        <img src="{{ asset($img->image) }}" alt="" class="img-fluid">
                    </div>
                @endforeach
            </div>
             
        </div>

        <div class="card pd-20 pd-sm-40 mg-t-25">
            <div id="map" style="height: 500px; width: 100%;"></div>   
        </div>

    </div><!-- sl-pagebody -->
    @include('backend.partials.footer')
</div>
@endsection
@push('script')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap"></script>
<script>
  function initMap() {
    // The location you want to center the map on (latitude, longitude)
    const location = { lat: {{ $post->latitude }}, lng: {{ $post->longitude }} };
    
    // Creating a map centered at the specified location
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 14,
      center: location,
    });
    
    // Optional: Adding a marker at the specified location
    const marker = new google.maps.Marker({
      position: location,
      map: map,
    });
  }
</script> 
@endpush