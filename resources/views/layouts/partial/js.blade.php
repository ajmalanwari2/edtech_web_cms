<!-- jQuery -->
    <script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('assets/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap.min.js') }}"></script>

    <!-- Perfect Scrollbar -->
    <script src="{{ asset('assets/vendor/perfect-scrollbar.min.js') }}"></script>

    <!-- DOM Factory -->
    <script src="{{ asset('assets/vendor/dom-factory.js') }}"></script>

    <!-- MDK -->
    <script src="{{ asset('assets/vendor/material-design-kit.js') }}"></script>

    <!-- Range Slider -->
    <!-- <script src="{{ asset('assets/vendor/ion.rangeSlider.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/js/ion-rangeslider.js') }}"></script> -->

    <!-- App -->
    <!-- <script src="{{ asset('assets/js/toggle-check-all.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/js/check-selected-row.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/js/dropdown.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/js/sidebar-mini.js') }}"></script> -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- App Settings (safe to remove) -->
    <!-- <script src="{{ asset('assets/js/app-settings.js') }}"></script> -->


    <!-- Flatpickr -->
    <!-- <script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/js/flatpickr.js') }}"></script> -->

    <!-- Global Settings -->
    <script src="{{ asset('assets/js/settings.js') }}"></script>

    <!-- Moment.js -->
    <!-- <script src="{{ asset('assets/vendor/moment.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/vendor/moment-range.js') }}"></script> -->


    <!-- Chart.js -->
    <!-- <script src="{{ asset('assets/vendor/Chart.min.js') }}"></script> -->

    <!-- App Charts JS -->
    <!-- <script src="{{ asset('assets/js/chartjs-rounded-bar.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/js/charts.js') }}"></script> -->

    <!-- Chart Samples -->
     <!-- <script src="{{ asset('assets/js/page.analytics.js') }}"></script> -->

    <!-- Toastr -->
    <script src="{{ asset('assets/vendor/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.toastr.js') }}"></script>


<!-- Vector Maps -->
<!-- <script src="{{ asset('assets/vendor/jqvmap/jquery.vmap.min.js') }}"></script> -->
<!-- <script src="{{ asset('assets/vendor/jqvmap/maps/jquery.vmap.world.js') }}"></script> -->
<!-- <script src="{{ asset('assets/js/vector-maps.js') }}"></script> -->

<!-- Chart Samples -->
<!-- <script src="{{ asset('assets/js/page.dashboard.js') }}"></script> -->


    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/jszip.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/datatables/pdfmake.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/datatables/vfs_fonts.js') }}"></script> -->
    <script src="{{ asset('assets/datatables/buttons.html5.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/datatables/buttons.print.min.js') }}"></script> -->
    <script src="{{ asset('assets/landing/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{ asset('assets/landing/js/charts.js') }}"></script>
    <script type="text/javascript">
        if ($.fn.dataTable) {
            $.extend(true, $.fn.dataTable.defaults, {
                scrollX: true,
                scrollY: '55vh',
                scrollCollapse: true,
                autoWidth: false
            });

            $(document).on('init.dt', function(e, settings) {
                var api = new $.fn.dataTable.Api(settings);
                $(api.table().container()).addClass('datatable-scroll-shell');
            });
        }
    </script>
  







    @stack('custom-scripts')
