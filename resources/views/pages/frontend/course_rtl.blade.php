@extends('layouts.frontend.master_rtl')
@section('title')
<title>SCA</title>
@endsection
@section('content')
<div class="page-inner">
  <div class="container">

    <h1>{{ __('footer.contents') }}</h1>
    <!-- <p>جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا  </p> -->
    

    <!--------- Videos Contents Started --------->
    
    @php
    $data = ($lang == 'da') ? $coursesDari : $coursesPashto;
    $pic = '1';
    @endphp
    @foreach($data as $g)
    <div class="vid-item"><!-- Video Item Started -->
    <a href="/{{$lang}}/courseContent/{{$g->course_id}}">
        <div class="row">
            <div class="col-md-4 video-wrap">
                    <div class="video_no_youtube vid_album">
                        <img src="{{ asset('assets/frontend/images/pic'.$pic.'.jpg') }}">
                    </div>
            </div>
            <div class="col-md-7 details-wrap">
                <div class="vid-details">
                    <table>
                        <tr>
                            <td>{{ __('contents.grade') }}</td>
                            <td>{{$g->course_name}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('contents.language') }}</td>
                            <td>{{$g->course_language}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('contents.number_of_videos') }}</td>
                            <td>{{$g->video_count}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
</a>
    </div><!-- Video Item Ended -->
    @php
    $pic = ($pic % 12) + 1;
    @endphp
@endforeach
    <!--------- Videos Contents Ended --------->

  </div>
</div>


@endsection
@section('styles')

@stop
@section('scripts')

@stop
