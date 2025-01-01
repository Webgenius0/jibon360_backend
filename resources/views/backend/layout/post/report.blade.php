@extends('backend.app', ['title' => 'index'])

@push('style')
<style>
    .dt-buttons {
        margin-bottom: 20px;
        padding-bottom: 0px;
    }

    .dt-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 16px;
        margin: 5px;
        border-radius: 4px;
        cursor: pointer;
    }

    .dt-button:hover {
        background-color: #0056b3;
    }

    .dt-button:disabled {
        background-color: #cccccc;
        cursor: not-allowed;
    }
</style>
</style>
@endpush


@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <a class="breadcrumb-item" href="{{ route('post.report') }}">Report</a>
    </nav>

    <div class="sl-pagebody">

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card pd-20 pd-sm-40">
                    <h4 class="card-header-title">Search Report</h4>
                    <hr />
                    <form class="row row-sm g-3" action="{{ route('post.report') }}" method="get">
                        <div class="col-12 col-md-1 mb-3 mb-md-0">
                            <select class="form-control" name="year" id="year">
                                <option value="">Year</option>
                                @for ($i = 2000; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $i == request('year', date('Y')) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-12 col-md-1 mb-3 mb-md-0">
                            <select class="form-control" name="month" id="month">
                                <option value="">Month</option>
                                @php $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']; @endphp
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == request('month', date('m')) ? 'selected' : '' }}>{{ $months[$i - 1] }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-12 col-md-1 mb-3 mb-md-0">
                            <select class="form-control" name="day" id="day">
                                <option value="">Day</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}" {{ $i == request('day') ? 'selected' : '' }}> {{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <select class="form-control" name="post_category_id" id="post_category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <select class="form-control" name="location" id="location">
                                <option value="">Select Location</option>
                                @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card pd-20 pd-sm-40">
                    <h4 class="card-header-title">Post Report</h4>
                    <p class="tx-13 mg-b-40 mg-sm-b-60">Report of all post</p>
                    <div class="table-wrapper">
                        <table id="data-table" class="table display responsive nowrap">
                            <thead class="thead-dark">
                                <tr>
                                    <th  class="wd-15p">SN:</th>
                                    <th  class="wd-15p">Name</th>
                                    <th  class="wd-15p">Category</th>
                                    <th  class="wd-15p">location</th>
                                    <th  class="wd-15p">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($posts->count() > 0)
                                @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td> {{ $post->postCategtory->name ?? 'N/A' }} </td>
                                    <td>{{ $post->location }}</td>
                                    <td>{{ date('d-m-Y', strtotime($post->created_at)) }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div><!-- table-wrapper -->
                </div>
            </div>
        </div>

        <div class="row mt-4">

            <div class="col-lg-6">
                <div class="card pd-20 pd-sm-40" style="height: 100%">
                    <h6 class="card-body-title">Monthly Report</h6>
                    <p class="mg-b-20 mg-sm-b-30">{{ request('year', date('Y')) }} / {{ $months[request('month', date('m'))-1] }}</p>
                    <div id="monthlyDayChart"></div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card pd-20 pd-sm-40" style="height: 100%">
                    <h6 class="card-body-title">Map</h6>
                    <p class="mg-b-20 mg-sm-b-30">Google Map</p>
                    <div id="map" style="width: 100%; height: 474px; background-color: #eee">If you see this text, the map isn't loading correctly.</div>
                </div>
            </div>

        </div>


    </div><!-- sl-pagebody -->
    @include('backend.partials.footer')
</div>
@endsection

@push('datatable')
<!-- DataTables and Button Scripts -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rickshaw/1.6.1/rickshaw.min.js"></script>

<!-- DataTables and Button Scripts -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Define the data for each day in a 30-day period
    const dailyData = @json($dailyPosts);

    // Configure the options for the monthly day chart
    const options = {
        chart: {
            type: 'line', // You can also use 'bar' for a bar chart
            height: 350
        },
        series: [{
            name: 'Daily Data',
            data: dailyData // Replace with your actual data array for each day
        }],
        xaxis: {
            categories: Array.from({
                length: 30
            }, (_, i) => `Day ${i + 1}`), // Generates labels from "Day 1" to "Day 30"
            title: {
                text: 'Days of the Month'
            }
        },
        yaxis: {
            title: {
                text: 'Data Value'
            }
        },
        title: {
            text: 'Daily Data for the Month',
            align: 'center'
        }
    };

    // Render the chart
    const chart = new ApexCharts(document.querySelector("#monthlyDayChart"), options);
    chart.render();
</script>

<script>
    $(document).ready(function() {
    $('#data-table').DataTable({
        dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4'l><'col-md-2 col-sm-4'f>>Btipr",
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [10, 25, 50, 100]
    });
});
</script>

<script>
    function initMap() {
        // The location of Jibon360 office
        var locations = @json($postMaps);
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