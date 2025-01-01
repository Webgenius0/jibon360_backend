<div class="sl-logo"><a href=""><i class="icon ion-android-star-outline"></i> {{ config('app.name') }}</a></div>
<div class="sl-header">
    <div class="sl-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
        
    </div><!-- sl-header-left -->
    <div>
        <h3 style="opacity: 0.2">{{ Auth::user()->role == 'admin' ? 'Super Admin' : "Moderator" }}</h3> 
    </div>
    <div class="sl-header-right">
        <nav class="nav">
            <div class="dropdown">
                <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name">{{ Auth::user()->name }}</span>
                    <img src="{{ auth()->user()->avatar != null && file_exists(public_path(auth()->user()->avatar)) ? asset(auth()->user()->avatar) : asset('default/logo.png') }}" class="wd-32 rounded-circle" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-200">
                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="{{ route('profile.update') }}"><i class="icon ion-ios-person-outline"></i> Edit Profile</a></li>
                        @if(Auth::user()->role == 'admin')
                        <li><a href="{{ route('settings.general') }}"><i class="icon ion-ios-gear-outline"></i> Settings</a></li>
                        @endif
                        <li><a><i class="icon ion-power"></i>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" style="border: none; background: none; color: #fff">Sign Out</button>
                                </form>
                            </a>
                        </li>
                    </ul>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
        </nav>
        <div class="navicon-right">
            <a id="btnRightMenu" href="" class="pos-relative">
                <i class="icon ion-ios-bell-outline"></i>
                <!-- start: if statement -->
                @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="square-8 bg-danger"></span>
                @endif
                <!-- end: if statement -->
            </a>
        </div><!-- navicon-right -->
    </div><!-- sl-header-right -->
</div>