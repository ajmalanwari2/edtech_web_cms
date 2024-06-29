@extends('layouts.frontend.master')
@section('title')
<title>SCA</title>
@endsection
@section('content')
<div class="page-inner">
    <div class="container">

        <!--------- Videos Subject Started --------->

        <div class="row">
            @if(empty($courseContentEnglish))
            <p style="background-color: #f5d7d7">Content is not available</p>
            @else
            <div class="col-md-9 vid_subject">
                <!-- Video Play Section Start -->
                <!-- if you are using youtube iframe -->
                <div class="video_youtube">
                    @php
                    $watchUrl = $courseContentEnglish && $courseContentEnglish[0] ? $courseContentEnglish[0]->body : '';
                    $videoId = substr($watchUrl, strrpos($watchUrl, '/') + 1);
                    $embedUrl = "https://www.youtube.com/embed/" . $videoId;

                    @endphp
                    <iframe id="main-video" width="560" height="500" src="{{ $embedUrl }}?autoplay=1"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
                <div class="title main-vid-title">
                    {{ $courseContentEnglish && $courseContentEnglish[0] ? $courseContentEnglish[0]->title : '' }}</div>
            </div><!-- Video Play Section End -->

            <div class="col-md-3">
                <!-- Scroll Videos List Start -->

                <!-- Scrollbar Plugin -->

                <div id="video_list_scroll" class="rounded vid_list">
                    @foreach($courseContentEnglish as $subjectContent)
                    <div class="vid-item">
                        <!-- Video Item Started -->
                        <div class="row">
                            <div class="video-wrap">
                                <a href="#">
                                    <div class="video_no_youtube">
                                        @php
                                        $watchUrl = $subjectContent->body;
                                        $videoId = substr($watchUrl, strrpos($watchUrl, '/') + 1);
                                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                        $thumbnail = 'https://img.youtube.com/vi/' . $videoId . '/0.jpg';
                                        @endphp
                                        <img onclick="playVideo('{{$videoId}}', '{{$subjectContent->title}}')"
                                            src="{{ $thumbnail }}" width="100%" height="auto">
                                    </div>
                                </a>
                            </div>
                            <div class="details-wrap">
                                <div class="vid-details">
                                    <div class="lesson"><i class="icon-folder-open-empty"></i>
                                        {{$subjectContent->title}}
                                    </div>
                                   
                                    <div class="title">{{$subjectContent->title}}</div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Video Item Ended -->
                    @endforeach
                </div>
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

function playVideo(id, title) {
    const mainVideo = document.getElementById('main-video');
    const mainVideoTitle = document.querySelector('.main-vid-title');
    mainVideo.src = 'https://www.youtube.com/embed/' + id;
    mainVideoTitle.innerText = title;

}
</script>
@stop