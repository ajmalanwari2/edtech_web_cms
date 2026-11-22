@extends('layouts.frontend.master')
@section('title')
<title>SCA</title>
@endsection
@section('content')

@include('layouts.frontend.partials.slider')

@include('layouts.frontend.partials.impact_stats')

<div class="spacer"></div>



<!-- About Start -->
<section class="about-top academy-intro">
    <div class="container">
        <div class="academy-intro__layout">
            <div class="academy-intro__visual">
                <div class="academy-intro__frame" data-aos="fade-left">
                    <img src="{{ asset('assets/frontend/images/edtech_eqra.png') }}"
                        alt="EdTech Eqra learning platform for students, parents and teachers">
                </div>
            </div>
            <div class="academy-intro__copy">
                <div class="text aos-item" data-aos="fade-right" data-aos-delay="120">
                    <h2>{{ __('home.title') }}</h2>
                    @foreach (array_chunk(preg_split('/(?<=[.!?؟۔])\s+/u', trim(__('home.description'))), 2) as $paragraph)
                        <p>{{ implode(' ', $paragraph) }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
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
                                            <h4>{{ __('home.sub_title2') }}</br></br></h4>
                                            <p>{{ __('home.description2') }}</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon3.png') }}">
                                            <h4>{{ __('home.sub_title3') }} </br></br></h4>
                                            <p>{{ __('home.description3') }}</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <!--<h2>{{ __('home.title2') }}</h2>-->
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
                                            <h4>{{ __('home.sub_title5') }}</br></br></h4>
                                            <p>{{ __('home.description5') }}</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon2.png') }}">
                                            <h4>{{ __('home.sub_title6') }}</br></br></h4>
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
<section class="news-vertical news-showcase">
    <div class="container">
        <div class="news-showcase__heading">
            <span class="news-showcase__eyebrow">EdTech</span>
            <h2>News &amp; Stories</h2>
            <p>Stories, announcements and updates from our learning community.</p>
        </div>
        <div class="row list">
            @foreach($newsEnglish as $n)
            <article class="col-md-3 item" data-aos="fade-up">
                <div class="image"><img src="{{ asset('storage/uploads/photo/' . $n->photo) }}" alt="{{ $n->title }}" loading="lazy"></div>
                <div class="content">
                    <h4>{{$n->title}}</h4>
                    <div class="posted">
                        <i class="icon-clock"></i> {{ $n->created_at ? \Carbon\Carbon::parse($n->created_at)->format('M d, Y') : '' }}
                    </div>
                    <p>{{$n->description}}</p>
                    <div class="news-showcase__spacer" aria-hidden="true"></div>
                   <button type="button" class="btn btn-primary read-more-btn" data-title="{{ $n->title }}"
                        data-description="{{ $n->description }}"
                        data-image="{{ asset('storage/uploads/photo/' . $n->photo) }}">
                        <span>{{ __('home.read_more') }}</span>
                        <span class="news-showcase__arrow" aria-hidden="true">→</span>
                    </button>
                </div>
            </article>
            @endforeach

        </div>
    </div>
</section>
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
    background: rgba(0,0,0,0.6);
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
    left: 10px; /* RTL */
    background: none;
    border: none;
    font-size: 28px;
    cursor: pointer;
}

/* Animation */
@keyframes dialogFadeIn {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

    </style>
@stop
@section('scripts')
<script>
document.querySelectorAll('.read-more-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('dialogTitle').innerText = this.dataset.title;
        document.getElementById('dialogDescription').innerText = this.dataset.description;
        document.getElementById('dialogImage').src = this.dataset.image;

        document.getElementById('newsDialog').style.display = 'flex';
    });
});

// Close button
document.getElementById('closeDialog').addEventListener('click', function () {
    document.getElementById('newsDialog').style.display = 'none';
});

// Close when clicking outside
document.getElementById('newsDialog').addEventListener('click', function (e) {
    if (e.target === this) {
        this.style.display = 'none';
    }
});
</script>

@stop
