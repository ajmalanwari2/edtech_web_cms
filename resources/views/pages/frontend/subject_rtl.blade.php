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
                
                <div id="youtube-video" class="video_youtube">
                    
                    <iframe id="main-video" width="560" height="500" src="https://www.youtube.com/embed/qQxDvw6r_t8?autoplay=1"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                   
                </div>
                <div class="title main-vid-title">
                    {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->grade_name : '' }} ,
                    {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->subject_name : '' }} ,
                    {{ $subjectContents && $subjectContents[0] ? $subjectContents[0]->chapter_name : '' }}
                </div>
                <br><br>
                <div id="video-not-available" style="display:none"><p>ویدیوی آموزشی درس متذکره موجود نمیباشد</p></div>
            </div><!-- Video Play Section End -->

            <div class="col-md-4">
                <!-- Scroll Videos List Start -->
                <!-- Scrollbar Plugin -->
                <!-- new sidebar start -->
                <div class="vid-box">
                    @foreach($subjectContents as $item)
                  
                    <div class="d-flex justify-content-between inner-box">
                        <div class="p-2"><span class="p-2 vid-number">{{ $loop->iteration }}</span>
                       
                            <a
                                onclick="video('{{$item->chapter_id}}', '{{$item->grade_name}}', '{{$item->subject_name}}')">
                                {{$item->chapter_name}}
                            </a>
                    </div>
                   
                    <div class="p-2">
                        <a id="book" onclick="book('{{$item->chapter_id}}', '{{$item->grade_name}}', '{{$item->subject_name}}')">
                            <img src="{{ asset('storage/uploads/icon/107-icon-1711815526.png') }}">
                        </a>
                       
                    </div>
                   
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

function video(id, grade_name, subject_name) {
    $.ajax({
        type: "POST",
        url: site_url + 'api/video/show',
        data: {
            id: id,
            '_token': '{{ csrf_token() }}'
        },
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'There was an error loading the record.'
            });
        }),
        success: (function(data) {
            var videoNotAvailabe = document.getElementById('video-not-available');
            var videoYoutube = document.getElementById('youtube-video');
            if(data != 'video-not-available'){
                videoNotAvailabe.style.display = 'none';
                videoYoutube.style.display = 'block';
           // Example usage
           var videoUrl = data.body;
var videoId = getYouTubeVideoId(videoUrl);
            // Set chapter details
            const mainVideo = document.getElementById('main-video');
    const mainVideoTitle = document.querySelector('.main-vid-title');
    mainVideo.src = 'https://www.youtube.com/embed/' + videoId;
    mainVideoTitle.innerText = grade_name + ' ،' + subject_name + ' ،' + data.title;
}else{
    
    videoNotAvailabe.style.display = 'block';
    videoYoutube.style.display = 'none';
}       
        }),
        dataType: 'json'
    });
}

function book(id, grade_name, subject_name) {
    $.ajax({
        type: "POST",
        url: site_url + 'api/book/show',
        data: {
            id: id,
            '_token': '{{ csrf_token() }}'
        },
        fail: function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'There was an error loading the record.'
            });
        },
        success: function(data) {
            if (data !== 'book-not-available') {
                var bookLink = document.getElementById('book');
                bookLink.href = data.body;
            } else {
                // Show popup message for unavailable book
                alert('Sorry, the book is currently not available.');
            }
        },
        dataType: 'json'
    });
}

function getYouTubeVideoId(url) {
  // Regular expression pattern to match YouTube video IDs
  var regExp = /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=|attribution_link\?.+watch\?v=)|youtu\.be\/)([^\s&?\/]+)/;
  
  // Extract the video ID from the URL using the regular expression
  var match = url.match(regExp);
  
  if (match && match[1]) {
    return match[1]; // Return the extracted video ID
  }
  
  return null; // Return null if the URL is not a valid YouTube URL
}
</script>
@stop