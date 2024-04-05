<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex">
    <!-- Perfect Scrollbar -->
    <link rel="stylesheet" href="{{asset('assets/vendor/perfect-scrollbar.css')}}" />

    <!-- App CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}" />
    {{-- <link rel="stylesheet" href="{{asset('assets/css/app.rtl.css')}}" /> --}}

    <!-- Material Design Icons -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor-material-icons.css')}}" />
    {{-- <link rel="stylesheet" href="{{asset('assets/css/vendor-material-icons.rtl.css')}}" /> --}}

    <!-- Font Awesome FREE Icons -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor-fontawesome-free.css')}}" />
    {{-- <link rel="stylesheet" href="{{asset('assets/css/vendor-fontawesome-free.rtl.css')}}" /> --}}

    <!-- ion Range Slider -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor-ion-rangeslider.css')}}" />



    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('assets/vendor/toastr.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
</head>

<body class="layout-default">
    <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px" data-fullbleed>
        <div class="mdk-drawer-layout__content">

            <!-- Header Layout -->
            <div class="mdk-header-layout js-mdk-header-layout" data-has-scrolling-region>


                <!-- Header Layout Content -->
                <div class="mdk-header-layout__content mdk-header-layout__content--fullbleed mdk-header-layout__content--scrollable page"
                    style="padding-top: 60px;">


                    <br><br><br><br><br><br>
                    <form action="{{route('quiz.submit_answare')}}" method="post" enctype="multipart/form-data"
                            id="answer_form">
                            @csrf
                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-4">
                                    <br><br>
                            <h4> #{{Session::get("nextq")}} : {{$question->question_text}} </h4><br>
                            <input value="a" name="answer" type="radio"><small> (A) {{$question->option_a_text}}</small><br>
                            <input value="b" name="answer" type="radio"><small> (B) {{$question->option_b_text}}</small><br>
                            <input value="c" name="answer" type="radio"><small> (C) {{$question->option_c_text}}</small><br>
                            <input value="d" name="answer" type="radio"><small> (D) {{$question->option_d_text}}</small><br>
                            <input value="{{$question->correct_answer}}" style="..." name="correct_answer" type="hidden">
                            <input value="{{$chapter_id}}" style="..." name="chapter_id" type="hidden">
                            <input value="{{$question->id}}" style="..." name="question_id" type="hidden">
                            <br><br>
                            <a href="{{ route('content.show', $chapter_id) }}" class="btn btn-danger float-left">Exit</a>
                            <button class="btn btn-primary float-right" type="submit">Next <i
                                    class="material-icons btn__icon--right">arrow_forward</i></button>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
</form>
                </div>
            </div>
            <!-- // END header-layout__content -->

        </div>
        <!-- // END header-layout -->

    </div>

    </div>

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
    <script src="{{ asset('assets/vendor/ion.rangeSlider.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/ion-rangeslider.js') }}"></script> --}}

    <!-- App -->
    <script src="{{ asset('assets/js/toggle-check-all.js') }}"></script>
    <script src="{{ asset('assets/js/check-selected-row.js') }}"></script>
    <script src="{{ asset('assets/js/dropdown.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-mini.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- App Settings (safe to remove) -->
    {{-- <script src="{{ asset('assets/js/app-settings.js') }}"></script> --}}


    <!-- Flatpickr -->
    <script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>

    <!-- Global Settings -->
    <script src="{{ asset('assets/js/settings.js') }}"></script>

    <!-- Moment.js -->
    <script src="{{ asset('assets/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/moment-range.js') }}"></script>


    <!-- Chart.js -->
    {{-- <script src="{{ asset('assets/vendor/Chart.min.js') }}"></script> --}}

    <!-- App Charts JS -->
    {{-- <script src="{{ asset('assets/js/chartjs-rounded-bar.js') }}"></script>
    <script src="{{ asset('assets/js/charts.js') }}"></script> --}}

    <!-- Chart Samples -->
    {{-- <script src="{{ asset('assets/js/page.analytics.js') }}"></script> --}}

    <!-- Toastr -->
    {{-- <script src="{{ asset('assets/vendor/toastr.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/toastr.js') }}"></script> --}}
    <script src="{{ asset('assets/js/jquery.toastr.js') }}"></script>
</body>

</html>