<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps Example</title>
    <style>
        #map {
            width: 100%;
            height: 720px;
            background-color: #eee;
        }
    </style>
</head>
<body>
    <div id="map">If you see this text, the map isn't loading correctly.</div>
    <script>
        function initMap() {
            // New York City coordinates
            var location = {lat: <?php echo $sos->lat; ?>, lng: <?php echo $sos->long; ?>};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map
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
</body>
</html>