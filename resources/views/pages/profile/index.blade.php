@extends('layouts.master')
@section('title')
<title>Student profile</title>
@endsection
@section('content')
<style>
  body {
    margin-top: 20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;
  }

  .main-body {
    padding: 15px;
  }

  .card {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
  }

  .card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0, 0, 0, .125);
    border-radius: .25rem;
  }

  .card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
  }

  .gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
  }

  .gutters-sm>.col,
  .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
  }

  .mb-3,
  .my-3 {
    margin-bottom: 1rem !important;
  }

  .bg-gray-300 {
    background-color: #e2e8f0;
  }

  .h-100 {
    height: 100% !important;
  }

  .shadow-none {
    box-shadow: none !important;
  }


  /****TABS STYLES****/
  .tab-wrap {
    transition: 0.3s box-shadow ease;
    border-radius: 6px;
    max-width: 100%;
    display: flex;
    flex-wrap: wrap;
    position: relative;
    list-style: none;
    background-color: #fff;
    margin: 5px 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  }

  .tab-wrap:hover {
    box-shadow: 0 12px 23px rgba(0, 0, 0, 0.23), 0 10px 10px rgba(0, 0, 0, 0.19);
  }

  .tab {
    display: none;
  }

  .tab:checked:nth-of-type(1)~.tab__content:nth-of-type(1) {
    opacity: 1;
    transition: 0.5s opacity ease-in, 0.8s transform ease;
    position: relative;
    top: 0;
    z-index: 100;
    transform: translateY(0px);
    text-shadow: 0 0 0;
  }

  .tab:checked:nth-of-type(2)~.tab__content:nth-of-type(2) {
    opacity: 1;
    transition: 0.5s opacity ease-in, 0.8s transform ease;
    position: relative;
    top: 0;
    z-index: 100;
    transform: translateY(0px);
    text-shadow: 0 0 0;
  }

  .tab:checked:nth-of-type(3)~.tab__content:nth-of-type(3) {
    opacity: 1;
    transition: 0.5s opacity ease-in, 0.8s transform ease;
    position: relative;
    top: 0;
    z-index: 100;
    transform: translateY(0px);
    text-shadow: 0 0 0;
  }

  .tab:checked:nth-of-type(4)~.tab__content:nth-of-type(4) {
    opacity: 1;
    transition: 0.5s opacity ease-in, 0.8s transform ease;
    position: relative;
    top: 0;
    z-index: 100;
    transform: translateY(0px);
    text-shadow: 0 0 0;
  }

  .tab:checked:nth-of-type(5)~.tab__content:nth-of-type(5) {
    opacity: 1;
    transition: 0.5s opacity ease-in, 0.8s transform ease;
    position: relative;
    top: 0;
    z-index: 100;
    transform: translateY(0px);
    text-shadow: 0 0 0;
  }

  .tab:first-of-type:not(:last-of-type)+label {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }

  .tab:not(:first-of-type):not(:last-of-type)+label {
    border-radius: 0;
  }

  .tab:last-of-type:not(:first-of-type)+label {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .tab:checked+label {
    background-color: #fff;
    box-shadow: 0 -1px 0 #fff inset;
    cursor: default;
  }

  .tab:checked+label:hover {
    box-shadow: 0 -1px 0 #fff inset;
    background-color: #fff;
  }

  .tab+label {
    box-shadow: 0 -1px 0 #eee inset;
    border-radius: 6px 6px 0 0;
    cursor: pointer;
    display: block;
    text-decoration: none;
    color: #333;
    flex-grow: 3;
    text-align: center;
    background-color: #f2f2f2;
    user-select: none;
    text-align: center;
    transition: 0.3s background-color ease, 0.3s box-shadow ease;
    height: 50px;
    box-sizing: border-box;
    padding: 15px;
  }

  .tab+label:hover {
    background-color: #f9f9f9;
    box-shadow: 0 1px 0 #f4f4f4 inset;
  }

  .tab__content {
    padding: 10px 25px;
    background-color: transparent;
    position: absolute;
    width: 100%;
    z-index: -1;
    opacity: 0;
    left: 0;
    transform: translateY(-3px);
    border-radius: 6px;
  }
  .row {
    height: auto !important;
  }
</style>


<div class="container">
  <div class="main-body">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="main-breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/report/index">User</a></li>
        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
      </ol>
    </nav>
    <!-- /Breadcrumb -->
    @if(!empty($rec))
    <div class="row" style="background: white">
      <div class="col-md-4">
          
        <img src="{{asset($rec['profile_image'])}}" alt="Admin" class="rounded-circle" width="150"
          style="margin-top:30px;margin-left:30px;">
         
      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="mb-0">Profile Information</h4>
          </div>
          <div style="height: 20px">

          </div>
          <div class="row">
            <div class="col-sm-3">
              <b>Full Name:</b> {{$rec['student_name']}}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <b>Gender :</b> {{$rec['student_gender']}}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <b>DOB :</b> {{$rec['dob']}}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <b>Current Grade :</b> {{$rec['grade_name']}}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <b>Last Sync :</b> {{$rec['last_sync']}}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <b>Child Of :</b> {{$rec['parent_name']}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div style="height: 20px;"></div>
    <div class="row" style="background: white">
      <div style="height: 20px;"></div>
      <div class="row">
            <div class="col-sm-12">
              <h4 class="mb-0">Progress History</h4>
            </div>
      </div>
      <div style="height: 20px;"></div>
      <div class="row" style="background-color: #e6e6e6;font-size: 15px; margin-left: 0px;">
            <div class="col-sm-3">
              <b>Subject Name</b>
            </div>
            <div class="col-sm-3">
              <b>Lesson Summary</b>
            </div>
            <div class="col-sm-3">
              <b>Quizzes Summary</b>
            </div>
            <div class="col-sm-3">
              <b>Status</b>
            </div>
      </div>
      <div class="row" style="margin-left: 0px;">
          @for ($b = 0; $b < count($rec['grades'][0]['subjects']) ; $b++)
            <div class="col-sm-3">
              {{$rec['grades'][0]['subjects'][$b]['subject_name']}}
            </div>
            <div class="col-sm-3">
              {{$rec['grades'][0]['subjects'][$b]['total_completed_chapters'].'/'.$rec['grades'][0]['subjects'][$b]['total_chapters']}}
            </div>
            <div class="col-sm-3">
              {!! $rec['grades'][0]['subjects'][$b]['quizzes'][0]['number_attempted_quizzes'] . '/'. $rec['grades'][0]['subjects'][$b]['quizzes'][0]['total_quizzes'] !!}
            </div>
            <div class="col-sm-3">
              {{ ($rec['grades'][0]['subjects'][$b]['total_completed_chapters']==$rec['grades'][0]['subjects'][$b]['total_chapters'])?'completed':'in-progress' }}
            </div>
            @endfor
      </div>
    </div>
    @endif
    @if(empty($rec))
    <div class="row" style="background: white">
      There was an issue with record.
    </div>
    @endif
  </div>

</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@stop
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop