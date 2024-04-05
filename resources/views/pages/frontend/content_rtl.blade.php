@extends('layouts.frontend.master_rtl')
@section('title')
<title>SCA</title>
@endsection
@section('content')
<div class="page-inner">
  <div class="container">

    <h1>فهرست</h1>
    <!-- <p>جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا  </p> -->
    

    <!--------- Videos Contents Started --------->
    
    @php
    $data = ($lang == 'da') ? $gradesDari : $gradesPashto;
    $pic = '1';
    @endphp
    @foreach($data as $g)
    <div class="vid-item"><!-- Video Item Started -->
        <div class="row">
            <div class="col-md-4 video-wrap">
                <a href="/{{$lang}}/grade/{{$g->grade_id}}">
                    <div class="video_no_youtube vid_album">
                        <img src="{{ asset('assets/frontend/images/pic'.$pic.'.jpg') }}">
                    </div>
                </a>
            </div>
            <div class="col-md-7 details-wrap">
                <div class="vid-details">
                    <table>
                        <tr>
                            <td>صنف</td>
                            <td>{{$g->grade_name}}</td>
                        </tr>
                        <tr>
                            <td>زبان درسی</td>
                            <td>{{$g->grade_language}}</td>
                        </tr>
                        <tr>
                            <td>مضامین</td>
                            <td>{{$g->subject_count}}</td>
                        </tr>
                        <tr>
                            <td>تعداد ویدویوهای درسی</td>
                            <td>{{$g->video_count}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
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
