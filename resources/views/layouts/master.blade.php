<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('title')
    <meta name="robots" content="noindex">
    <style>
       .mdk-drawer-layout{
            height: none !important;
        }

.mdk-header-layout__content--fullbleed {
    position: absolute;
    top: 24px !important;
    left: 0;
    right: 0;
    bottom: 0;
}
    </style>
  @include('layouts.partial.css')
  @yield('styles')
</head>
<body class="layout-default">
    <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px" data-fullbleed>
        @include('layouts.partial.sidebar')
        <div class="mdk-drawer-layout__content">

            <!-- Header Layout -->
            <div class="mdk-header-layout js-mdk-header-layout" data-has-scrolling-region>

               @include('layouts.partial.navbar')

                <!-- Header Layout Content -->
                <div class="mdk-header-layout__content mdk-header-layout__content--fullbleed mdk-header-layout__content--scrollable page" style="padding-top: 60px; z-index: -1!important">
                        @yield('content')
                </div>
                <!-- // END header-layout__content -->

            </div>
            <!-- // END header-layout -->

        </div>
        
    </div>  
    <script type="text/javascript">
    var site_url = "{{ config('app.app_admin_url') }}";
    </script>
 @include('layouts.partial.js')
 <script src="{{ asset('assets/landing/js/script.js') }}"></script>
 @yield('scripts')
 @yield('modals')
</body>
</html>




