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

@if (request()->is('setting*'))
.setting-rtl-scope input[type="text"],
.setting-rtl-scope input[type="search"],
.setting-rtl-scope textarea,
.setting-rtl-scope .form-control,
.setting-rtl-scope .text-muted,
.setting-rtl-scope table tbody td {
    unicode-bidi: plaintext;
    font-family: "Noto Naskh Arabic", "Noto Sans Arabic", "Segoe UI", Tahoma, Arial, sans-serif;
}

.setting-rtl-scope .setting-rtl-text {
    direction: rtl;
    text-align: right;
}

.setting-rtl-scope table tbody td.setting-ltr-cell {
    direction: ltr;
    text-align: center;
    unicode-bidi: isolate;
}
@endif

.datatable-scroll-shell {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}

.datatable-scroll-shell .dataTables_scrollBody {
    max-height: calc(100vh - 260px);
    overflow: auto !important;
    scrollbar-width: thin;
    scrollbar-color: #c1c9d2 #f1f3f5;
}

.datatable-scroll-shell .dataTables_scrollBody::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

.datatable-scroll-shell .dataTables_scrollBody::-webkit-scrollbar-track {
    background: #f1f3f5;
}

.datatable-scroll-shell .dataTables_scrollBody::-webkit-scrollbar-thumb {
    background: #c1c9d2;
    border-radius: 10px;
    border: 2px solid #f1f3f5;
}

.datatable-scroll-shell .dataTables_scrollBody::-webkit-scrollbar-thumb:hover {
    background: #9aa6b2;
}

.datatable-scroll-shell .dataTables_scrollHead table,
.datatable-scroll-shell .dataTables_scrollBody table,
.datatable-scroll-shell table.dataTable {
    margin-bottom: 0 !important;
}
    </style>
  @include('layouts.partial.css')
  @yield('styles')
</head>
<body class="layout-default{{ request()->is('setting*') ? ' setting-rtl-scope' : '' }}">
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
@if (request()->is('setting*'))
    <script type="text/javascript">
        function containsRtlScript(text) {
            return /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF]/.test(text || '');
        }

        function applySettingRtl(root) {
            var scope = root || document;

            $(scope).find('input[type="text"], input[type="search"], textarea, .text-muted, table tbody td').each(function() {
                var $el = $(this);
                var text = ($el.is('input, textarea') ? $el.val() : $el.text()).trim();

                if (containsRtlScript(text)) {
                    $el.attr('dir', 'auto').addClass('setting-rtl-text');
                } else if (!$el.closest('table').length || !$el.is('td:last-child')) {
                    $el.removeClass('setting-rtl-text');
                }
            });

            $(scope).find('table tbody tr').each(function() {
                $(this).find('td:last-child').addClass('setting-ltr-cell').attr('dir', 'ltr');
            });
        }

        $(document).ready(function() {
            applySettingRtl(document);
            $(document).on('keyup change input shown.bs.modal', 'input[type="text"], input[type="search"], textarea', function() {
                applySettingRtl($(this).closest('.modal, form, .page, body'));
            });
            $(document).on('draw.dt', function(e) {
                applySettingRtl(e.target);
            });
        });
    </script>
@endif
 @include('layouts.partial.js')
 <script src="{{ asset('assets/landing/js/script.js') }}"></script>
 @yield('scripts')
 @yield('modals')
</body>
</html>


