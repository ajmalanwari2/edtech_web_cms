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
                        <li><a href="/front/{{ $lang }}">صفحه نخست</a></li>
                        <!-- <li><a href="/front/{{ $lang }}/aboutus">در باره ما</a></li> -->
                        <li><a href="/front/{{ $lang }}/content">فهرست</a>
                                      {{-- <ul>
                          <li><a href="contents_rtl.html">فهرست اول</a></li>
                          <li><a href="contents_rtl.html">فهرست دوم</a></li>
                        </ul> --}}
                        </li>
                        <li><a href="/front/{{ $lang }}/course">کورسهای آموزشی</a></i>
                        <li><a href="#">دونلود</a>
                            <ul>
                                <li><a href="#">اپل</a></li>
                                <li><a href="#">اندروید</a></li>
                            </ul>
                        </li>
                        <li><a href="/front/{{ $lang }}/contact">تماس</a></li>
                        <li><a href="/front/{{ $lang }}/request_form">درخواست</a></li>
                    </ul>
                    <!-- Menu List Names Start -->

                </nav>
            </div>
        </div>
        <!-- Menu Section End -->
    </div>
    </div>
</header>
