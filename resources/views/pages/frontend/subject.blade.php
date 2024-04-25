@extends('layouts.frontend.master')
@section('title')
<title>SCA</title>
@endsection
@section('content')

<div class="page-inner">
    <div class="container">

        <h1>SUBJECT: {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->subject_name : '' }} </h1>
        <!--------- Videos Subject Started --------->

        <div class="row">
            @if(empty($subjectContents))
            <p style="background-color: #f5d7d7">No Content is available for this subject.</p>
            @else
            <div class="col-md-8 vid_subject">
                <!-- Video Play Section Start -->
                <!-- if you are using youtube iframe -->
                <div class="video_youtube">
                    @php
                    $watchUrl = $subjectContents && $subjectContents[0] ? $subjectContents[0]->body : '';
                    $embedUrl = str_replace('watch?v=', 'embed/', $watchUrl);

                    @endphp
                    <iframe id="main-video" width="560" height="500" src="{{ $embedUrl }}?autoplay=1"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
                <div class="title main-vid-title">
                    {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->grade_name : '' }} ,
                    {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->subject_name : '' }} ,
                    {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->title : '' }}</div>
            </div><!-- Video Play Section End -->

            <div class="col-md-4">
                <!-- Scroll Videos List Start -->

                <!-- Scrollbar Plugin -->
                <!-- new sidebar start -->
                <div class="vid-box">
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">1</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">2</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">3</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">4</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">5</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">6</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">7</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">8</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">9</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">10</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">11</div>
                        <div class="p-2"><a href="">Lesson Title </a></div>
                        <div class="ms-auto p-2"><a href=""><img src="http://learning.local/storage/uploads/icon/107-icon-1711815526.png">View Book</a></div>
                    </div>
                </div>
                

                <!-- end new sidebar -->
                <!-- <div id="video_list_scroll" class="rounded vid_list">
                    @foreach($subjectContents as $subjectContent)
                    <div class="vid-item">
                        <div class="row">
                            <div class="video-wrap">
                                <a href="#">
                                    <div class="video_no_youtube">
                                        @php
                                        $watchUrl = $subjectContent->body;
                                        $queryString = parse_url($watchUrl, PHP_URL_QUERY);
                                        parse_str($queryString, $parameters);

                                        $embedUrl = str_replace('watch?v=', 'embed/', $watchUrl);
                                        $thumnail = 'https://img.youtube.com/vi/'.$parameters['v'].'/0.jpg';
                                        @endphp
                                        <img onclick="playVideo('{{$parameters['v']}}', '{{$subjectContent->title}}', '{{$subjectContent->grade_name}}', '{{$subjectContent->subject_name}}')"
                                            src="{{ $thumnail}}" width="100%" height="auto">
                                    </div>
                                </a>
                            </div>
                            <div class="details-wrap">
                                <div class="vid-details">
                                    <div class="lesson"><i class="icon-folder-open-empty"></i>
                                        {{$subjectContent->chapter_number}} </div>
                                    <div class="subject"><i class="icon-doc-text"></i>{{$subjectContent->subject_name}}
                                    </div>
                                    <div class="title">{{$subjectContent->title}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div> -->
                <!-- Scroll Videos List End -->

                <!--ADD PERFECT SCROLLBAR TO CONTAINER-->

            </div>
            @endif
        </div>

        <!--------- Videos Subject Ended --------->

    </div>
</div>
@endsection
@section('styles')
<link href="{{ asset('assets/frontend/css/perfect-scrollbar.css') }}" rel="stylesheet">
@stop
@section('scripts')
<script src="{{ asset('assets/frontend/js/perfect-scrollbar.js') }}"></script>
<!--ADD PERFECT SCROLLBAR TO CONTAINER-->
<script>
const ps = new PerfectScrollbar('#video_list_scroll', {
    suppressScrollX: true,
});
$(document).ready(function() {
    $('#vid-details').addEventListener('click', function() {
        alert("clicked");
        var oldHtml = $('#video_list_scroll').innerHTML;
        $('#video_list_scroll').innerHTML = '';
        setTimeout(function() {
            $('#video_list_scroll').innerHTML = oldHtml;
            ps.update();
        }, 500);
    });
});

function playVideo(id, title, grade_name, subject_name) {
    const mainVideo = document.getElementById('main-video');
    const mainVideoTitle = document.querySelector('.main-vid-title');
    mainVideo.src = 'https://www.youtube.com/embed/' + id;
    mainVideoTitle.innerText = grade_name + ' ,' + subject_name + ' ,' + title;

}
</script>
@stop