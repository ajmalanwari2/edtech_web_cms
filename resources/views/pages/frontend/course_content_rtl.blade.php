@extends('layouts.frontend.master_rtl')
@section('title')
<title>SCA</title>
@endsection
@section('content')

<div class="page-inner">
    <div class="container">

    <h1> {{ $courseContents && $courseContents[0] ? $courseContents[0]->course_name : '' }} </h1>
        <!--------- Videos Subject Started --------->
        <div class="row">
            @if(empty($courseContents))
            <p style="background-color: #f5d7d7">محتویات مضمون متذکره موجود نمیاشد</p>
            @else
            <div class="col-md-8 vid_subject">
                <!-- Video Play Section Start -->
                <!-- if you are using youtube iframe -->
                
                <div id="youtube-video" class="video_youtube">
                    <iframe id="main-video" width="560" height="500" src="" title="YouTube video player" frameborder="0"
                                 allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                                    <div class="main-vid-title"></div> <!-- Placeholder for video title -->
                </div>
                <div class="title main-vid-title">
                    {{ $courseContents && $courseContents[0] ? $courseContents[0]->course_name : '' }} ,
                    {{ $courseContents && $courseContents[0] ? $courseContents[0]->title : '' }}
                </div>
                <br><br>
                <div id="video-not-available" style="display:none"><p>ویدیوی آموزشی درس متذکره موجود نمیباشد</p></div>
            </div><!-- Video Play Section End -->

            <div class="col-md-4">
                <!-- Scroll Videos List Start -->
                <!-- Scrollbar Plugin -->
                <!-- new sidebar start -->
                <div class="vid-box">
                    @foreach($courseContents as $item)
                  
                    <div class="d-flex justify-content-between inner-box">
                        <div class="p-2"><span class="p-2 vid-number">{{ $loop->iteration }}</span>
                       
                            <a
                                onclick="video('{{$item->id}}', '{{$item->course_name}}', '{{$item->title}}')">
                                {{$item->title}}
                            </a>
                    </div>
                   
                    <div class="p-2">
                       <a id="book" onclick="book(event, '{{$item->id}}', '{{$item->course_name}}', '{{$item->title}}')"  >
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

function playVideo(course_id, course_name, title) {
    const mainVideo = document.getElementById('main-video');
    const mainVideoTitle = document.querySelector('.main-vid-title');
    mainVideo.src = 'https://www.youtube.com/embed/' + course_id;
    mainVideoTitle.innerText = course_name + ' ،' + title;

}
function video(id, course_name, title) {
    $.ajax({
        type: "POST",
        url: site_url + 'api/course_video/show',
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
            var videoNotAvailable = document.getElementById('video-not-available');
            var videoYoutube = document.getElementById('youtube-video');
            
            if (data !== 'video-not-available') {
                videoNotAvailable.style.display = 'none';
                videoYoutube.style.display = 'block';
                
                // Extract the video ID from the URL
                var videoUrl = data.body;
                var videoId = getYouTubeVideoId(videoUrl);
                
                // Set the video URL and title
                const mainVideo = document.getElementById('main-video');
                const mainVideoTitle = document.querySelector('.main-vid-title');
                mainVideo.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
                mainVideoTitle.innerText = course_name + ' ،' + title;
            } else {
                videoNotAvailable.style.display = 'block';
                videoYoutube.style.display = 'none';
            }
        }),
        dataType: 'json'
    });
}

function book(event, id, course_name, title) {
    var element = event.currentTarget; // Get the target element that triggered the event
    $.ajax({
        type: "POST",
        url: site_url + 'api/course_book/show',
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
                element.href = 'https://edtecheqra.com/' + data.body;
                element.target = "_blank"; // Open link in a new tab

                // Open the link in a new tab
                var newTab = window.open(element.href, '_blank');
                newTab.focus();
            } else {
                // Show popup message for unavailable book
                alert('Sorry, the book is currently not available.');
            }
        },
        dataType: 'json'
    });
}
// function video(course_id, course_name, title) {
//     $.ajax({
//         type: "POST",
//         url: site_url + 'api/course_video/show',
//         data: {
//             id: course_id,
//             '_token': '{{ csrf_token() }}'
//         },
//         fail: (function() {
//             $.toaster({
//                 priority: 'danger',
//                 title: 'Info',
//                 message: 'There was an error loading the record.'
//             });
//         }),
//         success: (function(data) {
//             var videoNotAvailabe = document.getElementById('video-not-available');
//             var videoYoutube = document.getElementById('youtube-video');
//             if(data != 'video-not-available'){
//                 videoNotAvailabe.style.display = 'none';
//                 videoYoutube.style.display = 'block';
//           // Example usage
//           var videoUrl = data.body;
// var videoId = getYouTubeVideoId(videoUrl);
//             // Set chapter details
//             const mainVideo = document.getElementById('main-video');
//     const mainVideoTitle = document.querySelector('.main-vid-title');
//     mainVideo.src = 'https://www.youtube.com/embed/' + videoId;
//     mainVideoTitle.innerText =  course_name + ' ،' + data.title;
// }else{
    
//     videoNotAvailabe.style.display = 'block';
//     videoYoutube.style.display = 'none';
// }       
//         }),
//         dataType: 'json'
//     });
// }

// function book(course_id, course_name, title) {
//     $.ajax({
//         type: "POST",
//         url: site_url + 'api/course_book/show',
//         data: {
//             id: course_id,
//             '_token': '{{ csrf_token() }}'
//         },
//         fail: function() {
//             $.toaster({
//                 priority: 'danger',
//                 title: 'Info',
//                 message: 'There was an error loading the record.'
//             });
//         },
//         success: function(data) {
//             if (data !== 'book-not-available') {
//                 var bookLink = document.getElementById('book');
//                 bookLink.href = data.body;
//             } else {
//                 // Show popup message for unavailable book
//                 alert('Sorry, the book is currently not available.');
//             }
//         },
//         dataType: 'json'
//     });
// }

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