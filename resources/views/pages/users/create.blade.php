@extends('layouts.master')
@section('content')

<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Dashboard</h1>
    </div>
</div>
<div class="container-fluid page__container">
@if (Session::has('success') || Session::has('error'))
        @include('components.toaster')
@endif
    <div class="card card-form">
        <div class="row no-gutters">
            <div class="col-lg-12 card-form__body card-body">
            <form action="{{route('settings.store')}}" method="post" enctype="multipart/form-data"
                            id="entry_form">
                            @csrf
                    <div class="was-validated">
                        <div class="form-row">
                            <div class="col-12 col-md-4 mb-3">
                                <label for="first_name">First name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="{{ old('first_name') }}" required="">
                                <!-- <div class="invalid-feedback">Please provide a first name.</div> -->
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="last_name">Last name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last name"  value="{{ old('last_name') }}" required="">
                                <!-- <div class="invalid-feedback">Please provide a last name.</div> -->
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="phone_no">Phone</label>
                                <input type="number" class="form-control" name="phone_no" id="phone_no" placeholder="Phone"  value="{{ old('phone_no') }}" required="">
                                <!-- <div class="invalid-feedback">Please provide a last name.</div> -->
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col-12 col-md-4 mb-3">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Phone"  value="{{ old('phone_no') }}" required="">
                                <!-- <div class="invalid-feedback">Please provide a last name.</div> -->
                            </div>
                            <div class="form-group col-12 col-md-4 mb-3">
                                        <label for="district_id">Basic</label>
                                        <select id="district_id" data-toggle="select" name="district_id" class="form-control" required="">
                                            <option value="1" >Select</option>
                                            <option value="2" >Another option</option>
                                            <option value="3" >Third option is here</option>
                                        </select>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="validationSample03">villege</label>
                                <input type="text" class="form-control" id="validationSample03" placeholder="villege" name="villege" required="">
                                <div class="invalid-feedback">Please provide a valid villege.</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection