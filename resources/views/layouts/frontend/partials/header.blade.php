<header id="top">
    <div class="header clearfix container">
        <div class="logo float-start">
            <a href="#">
                <img src="{{ asset('assets/frontend/images/logo.png') }}" alt="Logo">
            </a>
        </div>
        <div class="language">
            <a href="/front/da/{{ str_replace('frontend.', '', request()->route()->getName()) }}">دری</a>
            <a href="/front/pa/{{ str_replace('frontend.', '', request()->route()->getName()) }}">پښتو</a>
            <a href="/front/en/{{ str_replace('frontend.', '', request()->route()->getName()) }}">EN</a>
            <a class="login" href="{{ route('admin_home') }}">Login</a>
        </div>

        <!-- Menu Section Start -->
        <div class="menusection">
            <div class="container">
                <nav id="main-nav" class="menu">
                    <!-- Mobile menu toggle button (hamburger/x icon) -->
                    <input id="main-menu-state" type="checkbox" />
                    <label class="main-menu-btn" for="main-menu-state">
                        <span class="main-menu-btn-icon"></span> Toggle main menu visibility
                    </label>

                    <!-- Menu List Names Start -->
                    <ul class="sm sm-clean" id="main-menu">
                        <li><a href="/front/{{ $lang }}">Home</a></li>
                        <li><a href="/front/{{ $lang }}/aboutus">About Us</a></li>
                        <li><a href="/front/{{ $lang }}/content">Contents</a>
                            {{-- <ul>
                            <li><a href="contents.html">Content First</a></li>
                            <li><a href="contents.html">Content Second</a></li>
                        </ul> --}}
                        </li>
                        <li><a href="#">Download</a>
                            <ul>
                                <li><a href="#">Android</a></li>
                                <li><a href="#">Apple</a></li>
                            </ul>
                        </li>
                        <li><a href="/front/{{ $lang }}/contact">Contact</a></li>
                        <li><a href="/front/{{ $lang }}/request_form">Request Access</a></li>
                    </ul>
                    <!-- Menu List Names Start -->

                </nav>
            </div>
        </div>
        <!-- Menu Section End -->
    </div>
    </div>
</header>
