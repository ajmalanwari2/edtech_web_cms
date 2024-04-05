 <!-- Header -->

 <div id="header" class="mdk-header js-mdk-header m-0" data-fixed data-effects="waterfall" data-retarget-mouse-scroll="false">
                    <div class="mdk-header__content">

                        <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-primary pl-md-0 pr-0" id="navbar" data-primary>
                            <div class="container-fluid page__container pr-0">

                                <!-- Navbar toggler -->
                                <!-- <button class="navbar-toggler navbar-toggler-custom  d-lg-none d-flex mr-navbar" type="button" data-toggle="sidebar">
                                    <span class="material-icons icon-14pt">menu</span>
                                </button>
                                <form class="ml-auto search-form search-form--light d-none d-sm-flex flex" action="index.html">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <button class="btn" type="submit"><i class="material-icons">search</i></button>
                                </form> -->


                                <ul class="nav navbar-nav d-none d-md-flex" style="margin-left: 1000px; padding-left: 69px;">
                                <li class="nav-item dropdown">
    <a href="{{ route('user.index') }}" class="nav-link " >
        <i class="material-icons nav-icon navbar-notifications-indicator">notifications</i>
        <span class="notification-count">{{getUserCreationRequestCount()}}</span> <!-- Replace '5' with your actual count of pending requests -->
    </a>
</li>
                                    <!-- <li class="nav-item dropdown">
                                        
                                        <a href="#notifications_menu" class="nav-link dropdown-toggle" data-toggle="dropdown" data-caret="false">
                                            <i class="material-icons nav-icon navbar-notifications-indicator">notifications</i>
                                        </a>
                                        <div id="notifications_menu" class="dropdown-menu dropdown-menu-right navbar-notifications-menu">
                                            <div class="dropdown-item d-flex align-items-center py-2">
                                                <span class="flex navbar-notifications-menu__title m-0">Notifications</span>
                                                <a href="javascript:void(0)" class="text-muted"><small>Clear all</small></a>
                                            </div>
                                            <div class="navbar-notifications-menu__content" data-perfect-scrollbar>
                                                <div class="py-2">

                                                    <div class="dropdown-item d-flex">
                                                        <div class="mr-3">
                                                            <div class="avatar avatar-xs">
                                                                <img src="assets/images/256_daniel-gaffey-1060698-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                                            </div>
                                                        </div>
                                                        <div class="flex">
                                                            <a href="">A.Demian</a> left a comment on <a href="">Stack</a><br>
                                                            <small class="text-muted">1 minute ago</small>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-item d-flex">
                                                        <div class="mr-3">
                                                            <a href="#">
                                                                <div class="avatar avatar-xs">
                                                                    <span class="avatar-title bg-primary rounded-circle"><i class="material-icons icon-16pt">person_add</i></span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="flex">
                                                            New user <a href="#">Peter Parker</a> signed up.<br>
                                                            <small class="text-muted">1 hour ago</small>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-item d-flex">
                                                        <div class="mr-3">
                                                            <a href="#">
                                                                <div class="avatar avatar-xs">
                                                                    <span class="avatar-title rounded-circle">JD</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="flex">
                                                            <a href="#">Big Joe</a> <small class="text-muted">wrote:</small><br>
                                                            <div>Hey, how are you? What about our next meeting</div>
                                                            <small class="text-muted">2 minutes ago</small>
                                                        </div>
                                                    </div>

                                                    <div class="dropdown-item d-flex">
                                                        <div class="mr-3">
                                                            <div class="avatar avatar-xs">
                                                                <img src="assets/images/256_daniel-gaffey-1060698-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                                            </div>
                                                        </div>
                                                        <div class="flex">
                                                            <a href="">A.Demian</a> left a comment on <a href="">Stack</a><br>
                                                            <small class="text-muted">1 minute ago</small>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-item d-flex">
                                                        <div class="mr-3">
                                                            <a href="#">
                                                                <div class="avatar avatar-xs">
                                                                    <span class="avatar-title bg-primary rounded-circle"><i class="material-icons icon-16pt">person_add</i></span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="flex">
                                                            New user <a href="#">Peter Parker</a> signed up.<br>
                                                            <small class="text-muted">1 hour ago</small>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-item d-flex">
                                                        <div class="mr-3">
                                                            <a href="#">
                                                                <div class="avatar avatar-xs">
                                                                    <span class="avatar-title rounded-circle">JD</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="flex">
                                                            <a href="#">Big Joe</a> <small class="text-muted">wrote:</small><br>
                                                            <div>Hey, how are you? What about our next meeting</div>
                                                            <small class="text-muted">2 minutes ago</small>
                                                        </div>
                                                    </div>

                                                    <div class="dropdown-item d-flex">
                                                        <div class="mr-3">
                                                            <div class="avatar avatar-xs">
                                                                <img src="assets/images/256_daniel-gaffey-1060698-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                                            </div>
                                                        </div>
                                                        <div class="flex">
                                                            <a href="">A.Demian</a> left a comment on <a href="">Stack</a><br>
                                                            <small class="text-muted">1 minute ago</small>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-item d-flex">
                                                        <div class="mr-3">
                                                            <a href="#">
                                                                <div class="avatar avatar-xs">
                                                                    <span class="avatar-title bg-primary rounded-circle"><i class="material-icons icon-16pt">person_add</i></span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="flex">
                                                            New user <a href="#">Peter Parker</a> signed up.<br>
                                                            <small class="text-muted">1 hour ago</small>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-item d-flex">
                                                        <div class="mr-3">
                                                            <a href="#">
                                                                <div class="avatar avatar-xs">
                                                                    <span class="avatar-title rounded-circle">JD</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="flex">
                                                            <a href="#">Big Joe</a> <small class="text-muted">wrote:</small><br>
                                                            <div>Hey, how are you? What about our next meeting</div>
                                                            <small class="text-muted">2 minutes ago</small>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <a href="javascript:void(0);" class="dropdown-item text-center navbar-notifications-menu__footer">View All</a>
                                        </div>
                                    </li> -->
                                    <!-- <li class="nav-item">
                                        <a href="#events-drawer" data-toggle="sidebar" class="nav-link d-flex align-items-center">
                                            <i class="material-icons nav-icon">event_note</i>
                                        </a>
                                    </li>
                                    <li class="nav-item nav-item-circle">
                                        <a href="#" class="nav-link d-flex align-items-center navbar-circle-link">
                                            <span class="rounded-circle">
                                                <span class="material-icons text-primary">flag</span>
                                            </span>
                                        </a>
                                    </li> -->
                                </ul>

                                <div class="dropdown">
                                    <a href="#" data-toggle="dropdown" data-caret="false" class="dropdown-toggle navbar-toggler navbar-toggler-dashboard border-left d-flex align-items-center ml-navbar">
                                         <img src="{{ auth()->user()->avatar != null ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/avatar/1.png') }}"
                                         width="30" height="30" alt="avatar" /> My Profile
                                    </a>
                                    <div id="company_menu" class="dropdown-menu dropdown-menu-right navbar-company-menu">
                                        <div class="dropdown-item d-flex align-items-center py-2 navbar-company-info py-3">

                                            <span class="mr-3">
                                            <div class="avatar avatar-online">
                                                <img src="{{ auth()->user()->avatar != null ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/avatar/1.png') }}"
                                                width="43" height="43" alt="avatar" />
                                            </div>
                                            </span>
                                            <span class="flex d-flex flex-column">
                                            {{ Auth::user()->name }}
                                            </span>

                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item d-flex align-items-center py-2" href="edit-account.html">
                                            <span class="material-icons mr-2">account_circle</span> Edit Profile
                                        </a>
                                       
                                        <a class="dropdown-item d-flex align-items-center py-2" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <span class="material-icons mr-2">exit_to_app</span> Logout
                                        </a>
                            
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- // END Header -->
<style>
.notification-count {
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 0px 6px;
    font-size: 12px;
    position: absolute;
    top: 0;
    right: -6px;
}
</style>