@extends('layouts.frontend.master')
@section('title')
<title>SCA</title>
@endsection
@section('content')

@include('layouts.frontend.partials.slider')

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
                        <p>Registered Students</p>
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
                        <p>Video Lessons</p>
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
                        <p>Audio Lessons</p>
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
                        <p>Document Lessons</p>
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
                            <img src="{{asset('assets/frontend/images/pic1.jpg')}}">
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 col-md-7" style="z-index:2">
                <div class="text aos-item" data-aos="fade-right" data-aos-delay="400">

                    <h3>
                        <txp:title />
                    </h3>
                    <h2>Edtech Eqra Application...</h2>
                    <p>Welcome to EdTech Application! Our platform is here to transform education through technology.
                        With our user-friendly interface and advanced features, we offer an immersive learning
                        experience for students, seamless lesson delivery for educators, and efficient management for
                        institutions. Join us as we revolutionize education and empower learners to reach their full
                        potential in a dynamic and engaging digital environment.
                        At EdTech Application, we believe in making education accessible to all. With our flexible and
                        inclusive platform, students can learn anytime, anywhere, breaking the barriers of traditional
                        classrooms. We combine the latest advancements in education technology with personalized
                        learning tools, virtual classrooms, and robust analytics to optimize the learning journey for
                        every individual. Be a part of the EdTech revolution and embark on a transformative educational
                        experience with us.</p>
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
                        <h2>Online Leaning Platform </h2>
                        <div class="slide">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon1.png') }}">
                                            <h4>School from grade 1 to 6</h4>
                                            <p>High quality HD recordings from Grade 1 to Grade 12 in Dari and Pashto
                                                Language for all subjects based on MoE curriculum.</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon2.png') }}">
                                            <h4>Courses </h4>
                                            <p>Includes assessments to evaluate learners' knowledge and provide instant
                                                feedback on their performance.</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon3.png') }}">
                                            <h4>Books</h4>
                                            <p>Rich library compose of extra curricula courses, documents, audio, and
                                                video lessons.</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <h2>Offline Leaning Platform(Mobile Application)</h2>
                                <div class="col-md-4">
                                    <!-- item Box start -->




                                 
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon4.png') }}">
                                            <h4>Collaboration and Interaction</h4>
                                            <p>To allow learners to interact and collaborate with peers, teachers, or
                                                experts to foster a sense of community.</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon1.png') }}">
                                            <h4>Tracking and Analytics</h4>
                                            <p>To track learners' progress, record their achievements, and provide
                                                analytics and insights on their learning journey.</p>
                                        </div>
                                    </div>
                                </div><!-- item Box End -->
                                <div class="col-md-4">
                                    <!-- item Box start -->
                                    <div class="box">
                                        <div class="inner">
                                            <img src="{{ asset('assets/frontend/images/icon2.png') }}">
                                            <h4>Data Security and Privacy</h4>
                                            <p>Prioritizing data security and privacy, ensuring that learner information
                                                and data are protected and handled in compliance with relevant
                                                regulations.</p>
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
            @foreach($newsEnglish as $n)
            <div class="col-md-3 item" data-aos="fade-right">
                <div class="image"><a href="#"><img src="{{ asset('storage/uploads/photo/' . $n->photo) }}"></a></div>
                <div class="content">
                    <h4><a href="#">{{$n->title}}</a></h4>
                    <div class="posted">
                        <i class="icon-clock"></i> {{$n->created_at}} <span class="user"><i class="icon-smile"></i> By
                            EdTech</span>
                    </div>
                    <p>{{$n->description}}</p>
                    <a href="#" class="btn btn-primary">Read More &raquo;</a>
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