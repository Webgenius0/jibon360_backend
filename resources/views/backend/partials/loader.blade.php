<img id="page-loader" src="{{ asset('default/loader.gif') }}" alt="Loading..." style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 999; max-width: 60px; max-height: 60px; display: none;">
<script>
    // Function to show loader
    function showLoader() {
        document.getElementById('page-loader').style.display = 'block';
    }

    // Function to hide loader
    function hideLoader() {
        document.getElementById('page-loader').style.display = 'none';
    }

    // Hide loader on page load
    window.onload = function() {
        hideLoader();
    };

    // Show loader on page unload
    window.onbeforeunload = function() {
        showLoader();
    };
</script>