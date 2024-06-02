@extends('layouts.frontend.master_rtl')
@section('title')
<title>SCA</title>
@endsection
@section('content')

<div class="page-inner">
    <div class="container">

    <h1>مضمون: {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->subject_name : '' }} </h1>
        <!--------- Videos Subject Started --------->



        <div class="row">
            @if(empty($subjectContents))
            <p style="background-color: #f5d7d7">محتویات مضمون متذکره موجود نمیاشد</p>
            @else
            <div class="col-md-8 vid_subject">
                <!-- Video Play Section Start -->
                <!-- if you are using youtube iframe -->
                <div class="video_youtube">
                    @php
                    $watchUrl = $subjectContents && $subjectContents[0] ? $subjectContents[0]->bodies : '';
                    $urls = explode(',', $watchUrl);
                    $videoId = '';

                    foreach ($urls as $url) {
                    if (strpos($url, 'youtu.be') !== false) {
                    $videoId = substr($url, strrpos($url, '/') + 1);
                    break;
                    }
                    }

                    if (!empty($videoId)) {
                    $embedUrl = "https://www.youtube.com/embed/" . $videoId;
                    @endphp
                    <iframe id="main-video" width="560" height="500" src="{{ $embedUrl }}?autoplay=1"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                    @php
                    } else {
                    echo 'No YouTube URL found.';
                    }
                    @endphp
                </div>
                <div class="title main-vid-title">
                    {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->grade_name : '' }} ,
                    {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->subject_name : '' }} ,
                    {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->chapter_name : '' }}
                </div>
            </div><!-- Video Play Section End -->

            <div class="col-md-4">
                <!-- Scroll Videos List Start -->
                <!-- Scrollbar Plugin -->
                <!-- new sidebar start -->
                <div class="vid-box">
                    @foreach($subjectContents as $item)
                    @php
                    $bodies = explode(',', $item->bodies);
                    $titles = explode(',', $item->titles);
                    $types = explode(',', $item->types);
                    @endphp
                    <div class="d-flex inner-box">
                        <div class="p-2 vid-number">{{ $loop->iteration }}</div>
                        @for($i = 0; $i < count($bodies); $i++) @if($types[$i]=='video' ) @php $watchUrl=$bodies[$i];
                            $videoId=substr($watchUrl, strrpos($watchUrl, '/' ) + 1);
                            $embedUrl='https://www.youtube.com/embed/' . $videoId;
                            $thumbnail='https://img.youtube.com/vi/' . $videoId . '/0.jpg' ; @endphp <div class="p-2">
                            <a
                                onclick="playVideo('{{$videoId}}', '{{$titles[$i]}}', '{{$item->grade_name}}', '{{$item->subject_name}}')">
                                {{$item->chapter_name}}
                            </a>
                    </div>
                    @elseif($types[$i] == 'file')
                    <div class="ms-auto p-2">
                        <a href="{{ asset($bodies[$i]) }}" target="_blank">
                            <img src="{{ asset('storage/uploads/icon/107-icon-1711815526.png') }}">View Book
                        </a>
                    </div>
                    @endif
                    @endfor
                </div>
                @endforeach
            </div><!-- new sidebar end -->
            <!-- Scroll Videos List End -->
        </div>
        @endif
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
$('#redraw').addEventListener('click', function() {
    var oldHtml = $('#video_list_scroll').innerHTML;
    $('#video_list_scroll').innerHTML = '';
    setTimeout(function() {
        $('#video_list_scroll').innerHTML = oldHtml;
        ps.update();
    }, 500);
});

function playVideo(id, title, grade_name, subject_name) {
    const mainVideo = document.getElementById('main-video');
    const mainVideoTitle = document.querySelector('.main-vid-title');
    mainVideo.src = 'https://www.youtube.com/embed/' + id;
    mainVideoTitle.innerText = grade_name + ' ،' + subject_name + ' ،' + title;

}
</script>
@stop