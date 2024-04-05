<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:#006983 !important">
        <div class="container-fluid">
            <div class="search-bar flex-grow-1 ms-2">
                <!-- <div class="position-relative search-bar-box">
							<input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class="bx bx-search"></i></span>
							<span class="position-absolute top-50 search-close translate-middle-y"><i class="bx bx-x"></i></span>
						</div> -->
            </div>
            <div class="d-flex justify-content-end me-2">
                
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="nav navbar-nav d-none d-md-flex">
                        <li class="nav-item dropdown">
                            <a href="{{ route('user.index') }}" class="nav-link ">
                                <i style="color:#ebf0f1"
                                    class="material-icons nav-icon navbar-notifications-indicator">notifications</i>
                                <span class="notification-count">{{getUserCreationRequestCount()}}</span>
                                <!-- Replace '5' with your actual count of pending requests -->
                            </a>
                        </li>
                    </ul>
                   
                </div>
            </div>
            <div class="dropdown">
                     <a href="#" data-toggle="dropdown" data-caret="false"
                         class="dropdown-toggle navbar-toggler navbar-toggler-dashboard border-left d-flex align-items-center ml-navbar">
                         <img src="{{ auth()->user()->avatar != null ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/avatar/1.png') }}"
                             width="30" height="30" alt="avatar" /> <span style="color:#F7F8F9; margin-left: 4px">My Profile<span>
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
                         <!-- <a class="dropdown-item d-flex align-items-center py-2" href="edit-account.html">
                             <span class="material-icons mr-2">account_circle</span> Edit Profile
                         </a> -->

                         <a class="dropdown-item d-flex align-items-center py-2" href="#"
                             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                             <span class="material-icons mr-2">exit_to_app</span> Logout
                         </a>

                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                             @csrf
                         </form>

                     </div>
                 </div>
        </div>
    </nav>
</header>

<style>
.login-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #006983;
    /* Change to your preferred color */
    color: #fff;
    border-radius: 5px;
    transition: #006983 0.3s ease;
}

.login-button:hover {
    background-color: #0056b3;
    color: #ffff;
    /* Change to a darker shade for hover effect */
}

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