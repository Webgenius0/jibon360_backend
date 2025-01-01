<script src="{{asset('backend')}}/lib/jquery/jquery.js"></script>
<script src="{{asset('backend')}}/lib/popper.js/popper.js"></script>
<script src="{{asset('backend')}}/lib/bootstrap/bootstrap.js"></script>
<script src="{{asset('backend')}}/lib/jquery-ui/jquery-ui.js"></script>
<script src="{{asset('backend')}}/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
<script src="{{asset('backend')}}/lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
<script src="{{asset('backend')}}/lib/d3/d3.js"></script>
<script src="{{asset('backend')}}/lib/rickshaw/rickshaw.min.js"></script>
<script src="{{asset('backend')}}/lib/chart.js/Chart.js"></script>
<script src="{{asset('backend')}}/lib/Flot/jquery.flot.js"></script>
<script src="{{asset('backend')}}/lib/Flot/jquery.flot.pie.js"></script>
<script src="{{asset('backend')}}/lib/Flot/jquery.flot.resize.js"></script>
<script src="{{asset('backend')}}/lib/flot-spline/jquery.flot.spline.js"></script>

<!-- Select2 JS -->
<script src="{{asset('backend')}}/lib/highlightjs/highlight.pack.js"></script>
<script src="{{asset('backend')}}/lib/datatables/jquery.dataTables.js"></script>
<script src="{{asset('backend')}}/lib/datatables-responsive/dataTables.responsive.js"></script>
<script src="{{asset('backend')}}/lib/select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{asset('backend')}}/js/jibon360.js"></script>

@stack('datatable')

<script src="{{asset('backend')}}/js/ResizeSensor.js"></script>
<script src="{{asset('backend')}}/js/dashboard.js"></script>

<!-- loader -->
<script src="{{ asset('default') }}/nprogress/nprogress.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('script')
<script>
    function info() {
        fetch("{{route('info')}}")
            .then(response => response.json())
            .then(data => {
                if (data.data) {
                    document.getElementById('pending-count').innerHTML = data.data.pending;
                    document.getElementById('pending-post-count').innerHTML = data.data.pending;
                    document.getElementById('publish-count').innerHTML = data.data.published;
                    document.getElementById('all-count').innerHTML = data.data.total;
                } else {
                    console.error('info not found');
                }
            })
            .catch(error => console.log('Error: ' + error));
    };

    function laravelAjax() {
        info();
    };

    laravelAjax();
</script>



