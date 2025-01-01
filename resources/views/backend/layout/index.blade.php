@extends('backend.app', ['title' => 'Dashboard'])
@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <span class="breadcrumb-item active">Dashboard</span>
    </nav>
    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Reoport</h5>
            <p>This page is a dashboard for Jibon360 backend. It displays the latest updates, reports and some statistical data.</p>
        </div>

        <div class="row row-sm">

            <div class="col-sm-6 col-xl-3">
                <div class="card pd-20 bg-info">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Total Users</h6>
                        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">
                        <i class="bi bi-people-fill tx-60 tx-white mg-b-0 d-inline"></i>
                        <h3 class="mg-b-0 tx-white tx-lato tx-bold">{{ App\Models\User::count() }}</h3>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card pd-20 bg-info">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Total Category</h6>
                        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">
                        <i class="bi bi-bookmark-fill tx-60 tx-white mg-b-0 d-inline"></i>
                        <h3 class="mg-b-0 tx-white tx-lato tx-bold">{{ App\Models\PostCategory::count() }}</h3>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card pd-20 bg-info">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Emergency Contacts</h6>
                        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">
                        <i class="bi bi-person-lines-fill tx-60 tx-white mg-b-0 d-inline"></i>
                        <h3 class="mg-b-0 tx-white tx-lato tx-bold">{{ App\Models\EmergencyContact::count() }}</h3>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card pd-20 bg-info">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">SMS Balance</h6>
                        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">
                        <i class="bi bi-chat-left-dots-fill tx-60 tx-white mg-b-0 d-inline"></i>
                        <h3 class="mg-b-0 tx-white tx-lato tx-bold" id="sms"></h3>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

        </div>
    </div>

    <div class="sl-pagebody">

        <div class="row">
            <div class="col-sm-4 col-xl-4">
                <div class="card pd-20 bg-info" style="height: auto;">
                <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white" id="pending" data-pending="{{ $pending }}" data-published="{{ $published }}"><b>Pending</b> {{ $pending }} / <b>Published</b> {{ $published }}</h6>
                        <a href="#" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div>
                    <div class="card-body">
                        <div id="chart" style="width: 100%; height: 400px;"></div>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col-6 -->
            <div class="col-sm-8 col-lg-8" style="min-height: 300px; height: auto;">
                <div id="map" style="width: 100%; height: 100%; background-color: #eee">If you see this text, the map isn't loading correctly.</div>
            </div>
        </div><!-- row -->
    </div><!-- sl-pagebody -->

    @include('backend.partials.footer')
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    fetch("https://api.sms.net.bd/user/balance/?api_key={{env('SMS_API_KEY')}}")
        .then(response => response.json())
        .then(data => {
            if (data.data) {
                document.getElementById('sms').innerHTML = data.data.balance + " tk";
            } else {
                console.log('Balance not found');
            }
        })
        .catch(error => console.log('Error: ' + error));
</script>
<script>
    var options = {
        series: [$('#pending').data('pending'), $('#pending').data('published')],
        chart: {
            width: '100%',
            height: '100%',
            type: 'pie',
            animations: {
                enabled: true,
                easing: "easeinout",
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            },
            center: {
                offsetY: 20,
            },
        },
        labels: ['Pending', 'Published'],
        colors: ['#ff9800', '#28a745'],
        legend: {
            show: false,
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
<script>
    function initMap() {
        // The location of Jibon360 office
        var locations = @json($posts);
        console.log(locations)
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: locations[0]
        });
        locations.forEach(function(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        });
        console.log("Map initialized");
    }
</script>
<script>
    function loadGoogleMapsScript() {
        var script = document.createElement('script');
        script.src = "https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap";
        script.async = true;
        script.defer = true;
        script.onerror = function() {
            console.error("Error loading Google Maps API");
            document.getElementById('map').innerHTML = "Failed to load Google Maps. Please check your internet connection and API key.";
        };
        document.body.appendChild(script);
    }
    loadGoogleMapsScript();
</script>
@endpush
