@extends('layouts.frontend.master_rtl')
@section('title')
<title>SCA</title>
@endsection
@section('content')

@include('layouts.frontend.partials.slider_rtl')

<div class="totals-box">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 box">
                <div class="item">
                    <div class="icon">
                        <img src="{{ asset('assets/frontend/images/icon1.png') }}">
                    </div>
                    <div class="text">
                        <h4>{{$total_registered_students}}</h4>
                        <p>{{ __('home.student_registration') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 box">
                <div class="item">
                    <div class="icon">
                        <img src="{{ asset('assets/frontend/images/icon2.png') }}">
                    </div>
                    <div class="text">
                        <h4>{{$videoCount}}</h4>
                        <p>{{ __('home.video_lossons') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 box">
                <div class="item">
                    <div class="icon">
                        <img src="{{ asset('assets/frontend/images/icon1.png') }}">
                    </div>
                    <div class="text">
                        <h4>{{$audioCount}}</h4>
                        <p>{{ __('home.audio_lossons') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 box">
                <div class="item">
                    <div class="icon">
                        <img src="{{ asset('assets/frontend/images/icon2.png') }}">
                    </div>
                    <div class="text">
                        <h4>{{$documentCount}}</h4>
                        <p>{{ __('home.document_lessons') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="spacer"></div>



<!-- About Start -->
<div class="about-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5">
                <div class="img" data-aos="fade-left">

                    <!-- if you are using youtube iframe -->
                    <!--div class="video_youtube">
              <iframe width="560" height="315" src="https://www.youtube.com/embed/4To9AQ0J9bk?si=45EJvOv7kC2TBXtS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div-->

                    <!-- if you are not using iframe -->
                    <a href="#">
                        <div class="video_no_youtube">
                            <img src="{{ asset('assets/frontend/images/pic1.jpg') }}">
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 col-md-7" style="z-index:2">
                <div class="text aos-item" data-aos="fade-right" data-aos-delay="400">

                    <h3>
                        <txp:title />
                    </h3>
                    <h2>{{ __('home.title') }}</h2>
                    <p>{{ __('home.description') }}</p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- About End -->




<div class="spacer"></div>


<!-- Box Section Start  -->
<div class="one-large-four-small">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 d-flex">
                <div class="one-large">
                    <div class="inner">
                        <img style="width:100%;height:auto" src="{{ asset('assets/frontend/images/about.png') }}">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="four-small">
                    <div class="about-top">
                        <h2>{{ __('home.title1') }}</h2>
                        <div class="slide">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon1.png') }}">
                                            <h4>{{ __('home.sub_title1') }}</br></br></h4>
                                            <p>{{ __('home.description1') }}</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon2.png') }}">
                                            <h4>{{ __('home.sub_title2') }} </br></br></h4>
                                            <p>{{ __('home.description2') }}</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon3.png') }}">
                                            <h4>{{ __('home.sub_title3') }}</br></br></h4>
                                            <p>{{ __('home.description3') }}</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <h2>{{ __('home.title2') }}</h2>
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon4.png') }}">
                                            <h4>{{ __('home.sub_title4') }}</br></br></h4>
                                            <p>{{ __('home.description4') }}</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon1.png') }}">
                                            <h4>{{ __('home.sub_title5') }}</h4>
                                            <p>{{ __('home.description5') }}</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon2.png') }}">
                                            <h4>{{ __('home.sub_title6') }}</h4>
                                            <p>{{ __('home.description6') }}</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Box Section End  -->








<!-- News Vertical Start -->
<div class="news-vertical">

    <div class="container">
        <div class="row list">
            @foreach($newsDari as $n)
            <div class="col-md-3 item" data-aos="fade-right">
                <div class="image"><a href="#"><img src="{{ asset('assets/frontend/images/pic1.jpg') }}" /></a></div>
                <div class="content">
                    <h4><a href="#">{{$n->title}}</a></h4>
                    <div class="posted">
                        <i class="icon-clock"></i> {{$n->created_at}}<span class="user"><i class="icon-smile"></i>
                            توسطه: ادی تیک</span>
                    </div>
                    <p>{{$n->description}}</p>
                    <a href="#" class="btn btn-primary">{{ __('home.read_more') }}&raquo;</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- News End -->





@endsection
@section('styles')

@stop
@section('scripts')

@stop