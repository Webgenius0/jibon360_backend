<div class="sl-sideright">
    <ul class="nav nav-tabs nav-fill sidebar-tabs" role="tablist">
        <!-- <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" role="tab" href="#messages">Messages (2)</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" role="tab" href="#notifications">Notifications ( {{ auth()->user()->unreadNotifications->count() }} )</a>
        </li>
        <li class="nav-item">
            <a class="" href="#" onclick="return confirm('Are you sure you want to delete all notifications?') ? window.location.href='{{ route('notification.read.all') }}' : false;"><i class="fa fa-trash-o text-danger"></i></a>
        </li>
    </ul><!-- sidebar-tabs -->

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane pos-absolute a-0 mg-t-60" id="messages" role="tabpanel">
            <div class="media-list">
                <!-- loop starts here -->
                <a href="" class="media-list-link">
                    <div class="media">
                        <img src="{{ asset('backend') }}/img/img3.jpg" class="wd-40 rounded-circle" alt="">
                        <div class="media-body">
                            <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Donna Seay</p>
                            <span class="d-block tx-11 tx-gray-500">2 minutes ago</span>
                            <p class="tx-13 mg-t-10 mg-b-0">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring.</p>
                        </div>
                    </div><!-- media -->
                </a>
                <!-- loop ends here -->
                <a href="" class="media-list-link">
                    <div class="media">
                        <img src="{{ asset('backend') }}/img/img4.jpg" class="wd-40 rounded-circle" alt="">
                        <div class="media-body">
                            <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Samantha Francis</p>
                            <span class="d-block tx-11 tx-gray-500">3 hours ago</span>
                            <p class="tx-13 mg-t-10 mg-b-0">My entire soul, like these sweet mornings of spring.</p>
                        </div>
                    </div><!-- media -->
                </a>
                <a href="" class="media-list-link">
                    <div class="media">
                        <img src="{{ asset('backend') }}/img/img7.jpg" class="wd-40 rounded-circle" alt="">
                        <div class="media-body">
                            <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Robert Walker</p>
                            <span class="d-block tx-11 tx-gray-500">5 hours ago</span>
                            <p class="tx-13 mg-t-10 mg-b-0">I should be incapable of drawing a single stroke at the present moment...</p>
                        </div>
                    </div><!-- media -->
                </a>
                <a href="" class="media-list-link">
                    <div class="media">
                        <img src="{{ asset('backend') }}/img/img5.jpg" class="wd-40 rounded-circle" alt="">
                        <div class="media-body">
                            <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Larry Smith</p>
                            <span class="d-block tx-11 tx-gray-500">Yesterday, 8:34pm</span>

                            <p class="tx-13 mg-t-10 mg-b-0">When, while the lovely valley teems with vapour around me, and the meridian sun strikes...</p>
                        </div>
                    </div><!-- media -->
                </a>
                <a href="" class="media-list-link">
                    <div class="media">
                        <img src="{{ asset('backend') }}/img/img3.jpg" class="wd-40 rounded-circle" alt="">
                        <div class="media-body">
                            <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Donna Seay</p>
                            <span class="d-block tx-11 tx-gray-500">Jan 23, 2:32am</span>
                            <p class="tx-13 mg-t-10 mg-b-0">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring.</p>
                        </div>
                    </div><!-- media -->
                </a>
            </div><!-- media-list -->
            <div class="pd-15">
                <a href="" class="btn btn-secondary btn-block bd-0 rounded-0 tx-10 tx-uppercase tx-mont tx-medium tx-spacing-2">View More Messages</a>
            </div>
        </div><!-- #messages -->

        <div class="tab-pane pos-absolute a-0 mg-t-60 overflow-y-auto active" id="notifications" role="tabpanel">
            <div class="media-list">

                @if(auth()->user()->unreadNotifications->count() > 0)
                @foreach(auth()->user()->unreadNotifications as $notification)
                <a href="{{ isset($notification->data['url']) ? $notification->data['url'].'/'.$notification->id : '#' }}" class="media-list-link read">
                    <div class="media pd-x-20 pd-y-15" style="position: relative">
                        <img src="{{ !empty($notification->data['avatar']) && File::exists(public_path($notification->data['avatar'])) ? asset($notification->data['avatar']) : asset('default/profile.jpg') }}" class="wd-40 rounded-circle" alt="">
                        <div class="media-body">
                            <p class="tx-13 mg-b-0 tx-gray-700">{{ $notification->data['message'] ?? 'No message available' }}</p>
                            <span class="tx-12">{{ $notification->created_at->diffForHumans() }}</span>
                            <a style="position: absolute; right: 20px; top: 15px" href="{{ route('notification.read.single', $notification->id) }}" class="tx-13"><i class="icon ion-android-close tx-18 tx-danger"></i></a>
                        </div>
                    </div><!-- media -->
                </a>
                @endforeach
                @else
                <p class="text-center tx-16 tx-bold tx-gray-600">No new notifications</p>
                @endif

            </div><!-- media-list -->
        </div><!-- #notifications -->

    </div><!-- tab-content -->
</div>

