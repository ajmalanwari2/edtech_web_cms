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

            @php
            $data = ($lang == 'da') ? $newsDari : $newsPashto;
            $pic = '1';
            @endphp
            @foreach($data as $n)
            <div class="col-md-3 item" data-aos="fade-right">
                <div class="image"><a href="#"><img
                            src="{{ asset('storage/app/public/uploads/photo/' . $n->photo) }}"></a></div>
                <!-- <img src="{{ asset('assets/frontend/images/pic1.jpg') }}" /></a></div> -->
                <div class="content">
                    <h4><a href="#">{{$n->title}}</a></h4>
                    <div class="posted">
                        <i class="icon-clock"></i> {{$n->created_at}}<span class="user"><i class="icon-smile"></i>
                            توسطه: ادی تیک</span>
                    </div>
                    <p>{{$n->description}}</p>
                    <a href="javascript:void(0)" class="btn btn-primary read-more-btn" data-title="{{ $n->title }}"
                        data-description="{{ $n->description }}"
                        data-image="{{ asset('storage/uploads/photo/' . $n->photo) }}">
                        {{ __('home.read_more') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- News End -->






<!-- News Modal -->
<div id="newsDialog" class="custom-dialog-overlay">
    <div class="custom-dialog">
        <button class="custom-dialog-close" id="closeDialog">&times;</button>

        <h3 id="dialogTitle"></h3>
        <img id="dialogImage" src="" alt="" />
        <p id="dialogDescription"></p>
    </div>
</div>


@endsection
@section('styles')
<style>
/* Overlay */
.custom-dialog-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

/* Dialog box */
.custom-dialog {
    background: #fff;
    max-width: 700px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    padding: 20px;
    border-radius: 8px;
    position: relative;
    direction: rtl;
    animation: dialogFadeIn 0.3s ease;
}

/* Image */
.custom-dialog img {
    width: 100%;
    height: auto;
    margin: 15px 0;
    border-radius: 6px;
}

/* Close button */
.custom-dialog-close {
    position: absolute;
    top: 10px;
    left: 10px;
    /* RTL */
    background: none;
    border: none;
    font-size: 28px;
    cursor: pointer;
}

/* Animation */
@keyframes dialogFadeIn {
    from {
        transform: scale(0.9);
        opacity: 0;
    }

    to {
        transform: scale(1);
        opacity: 1;
    }
}
</style>

@stop
@section('scripts')
<script>
document.querySelectorAll('.read-more-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('dialogTitle').innerText = this.dataset.title;
        document.getElementById('dialogDescription').innerText = this.dataset.description;
        document.getElementById('dialogImage').src = this.dataset.image;

        document.getElementById('newsDialog').style.display = 'flex';
    });
});

// Close button
document.getElementById('closeDialog').addEventListener('click', function() {
    document.getElementById('newsDialog').style.display = 'none';
});

// Close when clicking outside
document.getElementById('newsDialog').addEventListener('click', function(e) {
    if (e.target === this) {
        this.style.display = 'none';
    }
});
</script>


@stop