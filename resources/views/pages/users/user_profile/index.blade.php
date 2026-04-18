@extends('layouts.master')
@section('title')
<title>User Profile</title>
@endsection

@section('content')
<div class="container">
    <div class="main-body">

        <!-- Breadcrumb -->
        <!-- <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/user/index">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav> -->
        <!-- /Breadcrumb -->

        @if(!empty($rec))
        <div class="row" style="background: white; padding: 20px; border-radius: 10px;">
            <!-- Profile Information & Update Form -->
            <div class="col-md-8">
                <div class="card card-body">
                    <h4>Profile Information</h4>
                    <hr>
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('user.update', $rec['id']) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="name" class="form-label"><b>Full Name</b></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $rec['name'] }}"
                                    required>
                            </div>
                            <div class="col-sm-6">
                                <label for="email" class="form-label"><b>Email</b></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $rec['email'] ?? '' }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="identity_number" class="form-label"><b>Identity Number</b></label>
                                <input type="text" class="form-control" id="identity_number" name="identity_number"
                                    value="{{ $rec['identity_number'] ?? '' }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="password" class="form-label"><b>New Password</b></label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="New Password">
                            </div>
                            <div class="col-sm-6">
                                <label for="password_confirmation" class="form-label"><b>Confirm Password</b></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm new password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>

        </div>
        @else
        <div class="alert alert-warning mt-3">There was an issue retrieving the user record.</div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #e2e8f0;
}

.main-body {
    padding: 20px;
}

.card {
    border-radius: 10px;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
}
</style>
@stop

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stop