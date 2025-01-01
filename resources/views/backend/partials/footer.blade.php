@php
    use App\Models\Setting;
    $setting = Setting::latest( 'id' )->first();
@endphp

<footer class="sl-footer">
    <div class="footer-left">
        <div class="mg-b-2">Copyright &copy; {{ $setting->copyright ? $setting->copyright : date('Y') }}</div>
    </div>
    <!-- <div class="footer-right d-flex align-items-center">
        <span class="tx-uppercase mg-r-10">Share:</span>
        <a target="_blank" class="pd-x-5" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/jibon360"><i class="fa fa-facebook tx-20"></i></a>
        <a target="_blank" class="pd-x-5" href="https://twitter.com/home?status=Jibon360,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/jibon360"><i class="fa fa-twitter tx-20"></i></a>
    </div> -->
</footer>