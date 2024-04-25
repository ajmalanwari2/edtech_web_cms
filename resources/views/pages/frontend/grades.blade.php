@extends('layouts.frontend.master')
@section('title')
<title>SCA</title>
@endsection
@section('content')
<div class="page-inner">
  <div class="container">
    <h1>{{$grade->name}}</h1>
    <!-- <p>This is a demo text temporary for testing This is a demo text temporary for testing This is a demo text temporary for testing This is a demo text temporary for testing This is a demo text temporary for testing This is a demo text temporary for testing This is a demo text temporary for testing This is a demo text temporary for testing </p> -->
    

    <!--------- Videos Grade Started --------->
    <div class="row">
    @if(empty($subjects))
    <p style="background-color: #f5d7d7">No Content is available for Grade ({{$grade->name}}).</p>
@else
   <!-- Video Item Started -->
   @foreach($subjects as $s)
      <div class="col-md-3">
        <div class="vid-item vid-grade">
          <div class="video-wrap imgWrap">
            <a href="/front/{{$lang}}/grade/{{$s->grade_id}}/subject/{{$s->subject_id}}">
              <div class="video_no_youtube vid_album iconImg">
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
            <a href="subject.html">
              <div class="video_no_youtube vid_album">
                <img src="{{ asset('assets/frontend/images/pic2.jpg') }}">
              </div>
            </a>
          </div>
          <div class="details-wrap">
            <div class="vid-details">
              <h2>Islamic Studies</h2>
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
