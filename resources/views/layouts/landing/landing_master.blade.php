
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    @include('layouts.landing.partial.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.landing.partial.js')
    @yield('styles')
   </head>
<body>
    <!-- start sidebar -->
    @include('layouts.landing.partial.sidebar', ['grades' => $grades])
    <!-- end of sidebar -->
    <!-- start main body -->
    <section class="home-section">
        <!-- header -->
        @include('layouts.landing.partial.header')
        <!-- end header -->
        <div class="text">
        @yield('content')
            <!-- start of chart design -->
           
            <!-- end of chart design -->
        </div>
        <!-- end text -->
        <footer class="page-footer">
			<p class="mb-0">Copyright © 2023. SCA All right reserved.</p>
		</footer>
    </section>
    <!-- end main body -->

    <script src="{{ asset('assets/landing/js/script.js') }}"></script>
  @yield('scripts')
</body>
</html>














