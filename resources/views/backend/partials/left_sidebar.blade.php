<div class="sl-sideleft">
    <!-- <div class="input-group input-group-search">
        <input type="search" name="search" class="form-control" placeholder="Search">
        <span class="input-group-btn">
            <button class="btn"><i class="fa fa-search"></i></button>
        </span>
    </div> -->

    <label class="sidebar-label">Navigation</label>
    <div class="sl-sideleft-menu">
        <a href="{{ route('dashboard') }}" class="sl-menu-link active">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                <span class="menu-item-label">Dashboard</span>
            </div><!-- menu-item -->
        </a>

        <a href="{{ route('profile.edit') }}" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon bi bi-person-circle tx-22"></i>
                <span class="menu-item-label">Profiles</span>
            </div><!-- menu-item -->
        </a>

        <a href="#" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon bi bi-file-post tx-22"></i>
                <span class="menu-item-label">Post <span class="badge badge-danger" id="pending-post-count"></span></span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="sl-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('post.all', ['status' => '0']) }}" class="nav-link @if (Route::is('post.all', ['status' => '0'])) active @endif"><i class="bi bi-smartwatch tx-16"></i> Pending.. <span class="badge badge-danger" id="pending-count"></span></a></li>
            <li class="nav-item"><a href="{{ route('post.all', ['status' => '1']) }}" class="nav-link @if (Route::is('post.all', ['status' => '1'])) active @endif"><i class="bi bi-people tx-16"></i> Publish <span class="badge badge-success" id="publish-count"></span></a></li>
            <li class="nav-item"><a href="{{ route('post.all') }}" class="nav-link @if (Route::is('post.all')) active @endif"><i class="bi bi-list-columns-reverse tx-16"></i> All List <span class="badge badge-success" id="all-count"></span></a></li>
            <li class="nav-item"><a href="{{ route('post.history') }}" class="nav-link @if (Route::is('post.all')) active @endif"><i class="bi bi-clock-history"></i> History <span class="badge badge-success" id="all-count"></span></a></li>
        </ul>

        <a href="{{ route('post.report') }}" class="sl-menu-link @if (Route::is('post.report')) active @endif">
            <div class="sl-menu-item">
                <i class="bi bi-bar-chart-line-fill tx-22"></i>
                <span class="menu-item-label">Report</span>
            </div><!-- menu-item -->
        </a>

        @if(Auth::user()->role == 'admin')

        <a href="{{ route('moderator.index') }}" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon bi bi-shield-shaded tx-22"></i>
                <span class="menu-item-label">Moderators</span>
            </div><!-- menu-item -->
        </a>

        <a href="{{ route('users') }}" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon bi bi-people-fill tx-22"></i>
                <span class="menu-item-label">Users Logs</span>
            </div><!-- menu-item -->
        </a>

        <a href="#" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-paper-outline tx-22"></i>
                <span class="menu-item-label">Post Category</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="sl-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('post-category.index') }}" class="nav-link @if (Route::is('post-category.index')) active @endif"><i class="bi bi-list-ol tx-16"></i> List</a></li>
            <li class="nav-item"><a href="{{ route('post-category.create') }}" class="nav-link @if (Route::is('post-category.create')) active @endif"><i class="bi bi-brush tx-16"></i> Create</a></li>
        </ul>

        <a href="#" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon bi bi-person-lines-fill tx-22"></i>
                <span class="menu-item-label">Emergency Contacts</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="sl-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('emergency-contacts.index') }}" class="nav-link @if (Route::is('emergency-contacts.index')) active @endif"><i class="bi bi-list-ol tx-16"></i> List</a></li>
            <li class="nav-item"><a href="{{ route('emergency-contacts.create') }}" class="nav-link @if (Route::is('emergency-contacts.create')) active @endif"><i class="bi bi-brush tx-16"></i> Create</a></li>
        </ul>



        <a href="{{ route('social-link.index') }}" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon bi bi-person-lines-fill tx-22"></i>
                <span class="menu-item-label">Social link</span>
                <i class="menu-item-arrow "></i>
            </div>
        </a>



        <a href="#" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon bi bi-gear-fill tx-22"></i>
                <span class="menu-item-label">Settings</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="sl-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('settings.general') }}" class="nav-link @if (Route::is('settings.general')) active @endif"><i class="bi bi-gear-fill tx-16"></i> General</a></li>
            <li class="nav-item"><a href="{{ route('settings.social') }}" class="nav-link @if (Route::is('settings.social')) active @endif"><i class="bi bi-slack tx-16"></i> Social</a></li>
            <li class="nav-item"><a href="{{ route('settings.mail') }}" class="nav-link @if (Route::is('settings.mail')) active @endif"><i class="bi bi-envelope tx-16"></i> Mail</a></li>
            <li class="nav-item"><a href="{{ route('settings.sms') }}" class="nav-link"><i class="bi bi-chat-right-dots-fill tx-16"></i> SMS</a></li>
        </ul>

        @endif
    </div>

    <br>
</div>