@extends('layouts.frontend.master_rtl')
@section('title')
<title>SCA</title>
@endsection
@section('content')
<div class="page-inner">
    <div class="container">

        <h1>{{$grade->name}}</h1>
        <!-- <p>جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی
                میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی وبسایت موقتی میباشد اینجا جمله امتحانی
                وبسایت موقتی میباشد اینجا </p> -->


        <!--------- Videos Grade Started --------->
        <div class="row">
            @if(empty($subjects))
            <p style="background-color: #f5d7d7">به ({{$grade->name}}) معلومات موجود نمیباشد.</p>
            @else
            @foreach($subjects as $s)
            <div class="col-md-2">
                <!-- Video Item Started -->
                <div class="vid-item vid-grade">
                    <div class="video-wrap">
                        <a href="/{{$lang}}/grade/{{$s->grade_id}}/subject/{{$s->subject_id}}">
                            <div class="video_no_youtube vid_album">
                                <img src="{{ asset('storage/uploads/icon/' . $s->subject_icon) }}">
                            </div>
                        </a>
                    </div>
                    <div class="details-wrap">
                        <div class="vid-details">
                            <h2>{{$s->subject_name}}</h2>
                            <!-- <div class="totals">
                                    <div class="icon">
                                        <i class="icon-video"></i> {{$s->video_count}}
                                    </div>
                                    <div class="icon">
                                        <i class="icon-volume-up"></i> {{$s->audio_count}}
                                    </div>
                                    <div class="icon">
                                        <i class="icon-doc-text"></i> {{$s->doc_count}}
                                    </div>
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- Video Item Ended -->
            @endif

            <!-- Video Item Started -->
            <!-- <div class="col-md-3">
                    <div class="vid-item vid-grade">
                        <div class="video-wrap">
                            <a href="subject_rtl.html">
                                <div class="video_no_youtube vid_album">
                                    <img src="{{ asset('assets/frontend/images/pic1.jpg') }}images/pic2.jpg">
                                </div>
                            </a>
                        </div>
                        <div class="details-wrap">
                            <div class="vid-details">
                                <h2>تعلیمات اسلامی</h2>
                                <div class="totals">
                                    <div class="icon">
                                        <i class="icon-video"></i> 645
                                    </div>
                                    <div class="icon">
                                        <i class="icon-volume-up"></i> 836
                                    </div>
                                    <div class="icon">
                                        <i class="icon-doc-text"></i> 427
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <!-- Video Item Ended -->

        </div>
        <!--------- Videos Grade Ended --------->
    </div>
</div>

@endsection
@section('styles')

@stop
@section('scripts')

@stop