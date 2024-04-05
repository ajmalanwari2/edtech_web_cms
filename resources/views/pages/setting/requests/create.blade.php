@extends('layouts.master')
@section('title')
<title>User Requests</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">User Requests</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-large bg-light d-flex align-items-center">
                        <div class="flex">
                            <!-- <h4 class="card-header__title text-center">User Requests</h4> -->
                            <div class="card-subtitle text-muted text-center">User Requests</div>
                        </div>
                    </div>
                    <ul class="list-group list-rankings">
                        <li class="list-group-item">
                            <div class="media align-items-center">
                                <span class="mr-2">1.</span>
                                <span class="fas fa-user-check" style="margin-right: 0.8rem !important"></span>
                                <div class="media-body">
                                    <a href="#">Number of Registered Students</a>
                                </div>
                                <div>{{$number_registered_students}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="media align-items-center">
                                <span class="mr-2">2.</span>
                                <span class="fas fa-user-lock" style="margin-right: 0.8rem !important"></span>
                                <div class="media-body">
                                    <a href="{{route('user.pending_students')}}">Number of Pending Students Requests for Approval</a>
                                </div>
                                <div>{{$number_pending_students}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="media align-items-center">
                                <span class="mr-2">3.</span>
                                <span class="fas fa-user-check" style="margin-right: 0.8rem !important"></span>
                                <div class="media-body">
                                    <a href="#">Number of Registered Parents</a>
                                </div>
                                <div>{{$number_registered_teachers}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="media align-items-center">
                                <span class="mr-2">4.</span>
                                <span class="fas fa-user-lock" style="margin-right: 0.8rem !important"></span>
                                <div class="media-body">
                                    <a href="#">Number of Pending Parents Requests for Approval</a>
                                </div>
                                <div>{{$number_pending_teachers}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="media align-items-center">
                                <span class="mr-2">5.</span>
                                <span class="fas fa-user-check" style="margin-right: 0.8rem !important"></span>
                                <div class="media-body">
                                    <a href="#">Number of Registered Teachers</a>
                                </div>
                                <div>{{$number_registered_parents}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="media align-items-center">
                                <span class="mr-2">6.</span>
                                <span class="fas fa-user-lock" style="margin-right: 0.8rem !important"></span>
                                <div class="media-body">
                                    <a href="#">Number of Pending Teachers Requests for Approval</a>
                                </div>
                                <div>{{$number_pending_parents}}</div>
                            </div>
                        </li>
                    </ul>
                </div>
        </div>
    </div>       
</div>
@endsection