@extends('layouts.master')
@section('title')
<title>Pending Requests</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Pending Requests</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Pending User Creation Requests for Approval</div>
                    </div>
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New User</button> -->
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="request" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Province</th>
                                <th>District</th>
                                <th>School</th>
                                <th>Grade</th>
                                <th>Role</th>
                                <th>Requested Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@section('modals')

<!-- ADD/EDIT FORM START-->
<div id="modal-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-title">User Request Update Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data" id="entry_edit_form">
                    @csrf
                    <div class="was-validated">
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="name">Full Name:</label>
                                <div class="input-group input-group-merge">
                                    <input id="name" name="name" type="text" required=""
                                        class="form-control form-control-prepended" placeholder="Full Name"
                                        value="{{ old('name') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="far fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="email">Email:</label>
                                <div class="input-group input-group-merge">
                                    <input id="email" name="email" type="text" required=""
                                        class="form-control form-control-prepended" placeholder="Email"
                                        value="{{ old('email') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="far fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="email">Phone:</label>
                                <div class="input-group input-group-merge">
                                    <input id="phone_no" name="phone_no" type="text" required=""
                                        class="form-control form-control-prepended" placeholder="Phone"
                                        value="{{ old('phone_no') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-mobile-alt"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="province_id">Province Name:</label>
                                <div class="input-group input-group-merge">
                                    <select id="province_id" data-toggle="select" name="province_id"
                                        class="form-control" required="">
                                        <option value="">select</option>
                                        @foreach($provinces as $province)
                                        <option {{old('province_id') == $province->id ? 'selected' : ''}}
                                            value="{{$province->id}}">
                                            {{$province->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col-12 col-md-6 mb-3">
                        <label class="text-label" for="father_name">DOB:</label>
                        <div class="input-group input-group-merge">
                            <input id="dob"  name="dob" type="text" required="" class="form-control form-control-prepended" placeholder="DOB">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <span class="far fa-user-circle"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                    <label class="text-label" for="email">Gender:</label>
                        <div class="input-group input-group-merge">
                            <select id="gender" data-toggle="select" name="gender" class="form-control" required="">
                                            <option value="" >Select</option>
                                            <option value="male" >male</option>
                                            <option value="female" >female</option>
                                        </select>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="far fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="district_id">District:</label>
                                <div class="input-group input-group-merge">
                                    <select id="district_id" data-toggle="select" name="district_id"
                                        class="form-control" required="">
                                        <option value="">select</option>
                                        @foreach($districts as $districts)
                                        <option {{old('districts_id') == $districts->id ? 'selected' : ''}}
                                            value="{{$districts->id}}">
                                            {{$districts->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-warehouse"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="school_id">School Name:</label>
                                <div class="input-group input-group-merge">
                                    <select id="school_id" data-toggle="select" name="school_id" class="form-control"
                                        required="">
                                        <option value="">select</option>
                                        @foreach($schools as $school)
                                        <option {{old('school_id') == $school->id ? 'selected' : ''}}
                                            value="{{$school->id}}">
                                            {{$school->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="far fa-id-card"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="grade_id">Grade Name:</label>
                                <div class="input-group input-group-merge">
                                    <select id="grade_id" data-toggle="select" name="grade_id" class="form-control"
                                        required="">
                                        <option value="">select</option>
                                        @foreach($grades as $grade)
                                        <option {{old('grade_id') == $grade->id ? 'selected' : ''}}
                                            value="{{$grade->id}}">
                                            {{$grade->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="far fa-id-card"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="password">Password:</label>
                                <div class="input-group input-group-merge">
                                    <input id="password" type="password" name="password" required=""
                                        class="form-control form-control-prepended" value="{{ old('password') }}"
                                        placeholder="Password">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fa fa-key"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBTN" onclick="saveForm()">Save</button>
            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div>
<!-- ADD/EDIT FORM END-->
<!-- VIEW FORM START-->
<div id="modal-view" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-title">Pending Requests View Form </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="me-1">Number:</div>
                        <div id="request_id" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Full Name:</div>
                        <div id="request_username" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">UserName:</div>
                        <div id="request_email" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Phone:</div>
                        <div id="request_phone" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Province:</div>
                        <div id="request_province" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">District:</div>
                        <div id="request_district" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">School:</div>
                        <div id="request_school" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Grade:</div>
                        <div id="request_grade" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Role:</div>
                        <div id="request_role" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Requested Date:</div>
                        <div id="request_date" class="text-muted"></div>
                    </div>
                </div>
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary" onclick="approvedRequestView()">Approve</button> -->
            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div>
<!-- VIEW FORM END-->

<!-- DELETE COFIRM modal-->
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <h6>Do you want to approved the request!</h6>
                <button type="button" class="btn btn-light" data-dsmiss="modal" i>No</button>
                <button type="button" class="btn btn-warning my-2" onclick="approvedRequest()">Yes</button>
            </div> <!-- // END .modal-body -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->

<div id="modal-reject" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <h6>Do you want to reject the request!</h6>
                <button type="button" class="btn btn-light" onclick="closeModal()">No</button>
                <button type="button" class="btn btn-warning my-2" onclick="rejectRequest()">Yes</button>
            </div> <!-- // END .modal-body -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->

@endsection

@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}" />

@stop
@section('scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>


<script type="text/javascript">
var table = $('#request').DataTable({
    serverSide: true,
    ajax: {
        url: site_url + 'api/request/list',
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}'
        }
    },
    columns: [{
            data: 'id'
        },
        {
            data: 'first_name'
        },
        {
            data: 'email'
        },
        {
            data: 'phone_no'
        },
        {
            data: 'province'
        },
        {
            data: 'district'
        },
        {
            data: 'school'
        },
        {
            data: 'grade'
        },
        {
            data: 'role'
        },
        {
            data: 'requested_date'
        },
        {
            data: 'actions'
        }
    ],
    processing: true,
    serverSide: true
});


function saveForm(id) {
    var url = site_url + 'api/request/save';
    var data = {
        '_token': '{{ csrf_token() }}',
        first_name: $('#name').val(),
        email: $('#email').val(),
        phone_no: $('#phone_no').val(),
        gender: $('#gender').val(),
        dob: $('#dob').val(),
        role: $('#role').val(),
        province_id: $('#province_id').val(),
        district_id: $('#district_id').val(),
        school_id: $('#school_id').val(),
        grade_id: $('#grade_id').val(),
        password: $('#password').val(),
    };
    if (!(id === undefined)) {
        url = site_url + 'api/request/update';
        data.id = id;
    }
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'There was error saving record.'
            });
        }),
        success: (function(data) {

            if ((id === undefined)) {
                $.toaster({
                    priority: 'success',
                    title: 'Info',
                    message: 'Record has been added successfull.'
                });
                $('#entry_edit_form').trigger("reset");
            } else {
                $.toaster({
                    priority: 'success',
                    title: 'Info',
                    message: 'Record has been updated successfully.'
                });
            }
            table.ajax.reload();
            $('#modal-form').removeClass('show');
            $('.modal-backdrop').remove();
        }),
        dataType: 'json'
    });
}

function loadRecord(id) {
    $.ajax({
        type: "POST",
        url: site_url + 'api/request/show',
        data: {
            id: id,
            '_token': '{{ csrf_token() }}'
        },
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'There was error loading record.'
            });
        }),
        success: (function(data) {
            $('#request_id').text(data.id);
            $('#request_username').text(data.first_name);
            $('#request_email').text(data.email);
            $('#request_phone').text(data.phone_no);
            $('#request_province').text(data.request_province);
            $('#request_district').text(data.request_district);
            $('#request_school').text(data.request_school);
            $('#request_grade').text(data.request_grade);
            $('#request_role').text(data.role);
            $('#request_date').text(data.request_date);
            $('#name').val(data.first_name);
            $('#email').val(data.email);
            $('#phone_no').val(data.phone_no);
            $('#gender').val(data.gender);
            $('#dob').val(data.dob);
            $('#province_id').val(data.province_id);
            $('#district_id').val(data.district_id);
            $('#school_id').val(data.school_id);
            $('#grade_id').val(data.grade_id);
            $('#password').val(data.password);
            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").html("Update");
            $("#modal-form-title").html("User Request Update Form");

        }),
        dataType: 'json'
    });
}
var deleteRecordID = 0;

function deleteRecord() {

    if (deleteRecordID == 0)
        return;

    $.ajax({
        type: "POST",
        url: site_url + 'api/request/delete',
        data: {
            id: deleteRecordID,
            '_token': '{{ csrf_token() }}'
        },
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'Failed when deleting record.'
            });
        }),
        success: (function(data) {

            $.toaster({
                priority: 'success',
                title: 'Info',
                message: 'Record has been removed.'
            });
            $('#modal-confirm').modal('toggle');
            table.ajax.reload();
        }),
        dataType: 'json'
    });
}

function closeModal() {
    $('#modal-confirm').removeClass('show');
    $('.modal-backdrop').remove();
}
var approveRecordID = 0;


function approvedRequestView() {

    var jan_id = $('#request_id').val();
    alert('hid');
    alert(jan_id);
    $.ajax({
        type: "POST",
        url: site_url + 'api/request/approve',
        data: {
            id: request_id,
            '_token': '{{ csrf_token() }}'
        },
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'Failed when approving record.'
            });
        }),
        success: (function(data) {

            $.toaster({
                priority: 'success',
                title: 'Info',
                message: 'Request has been approved.'
            });
            $('#modal-confirm').modal('toggle');
            table.ajax.reload();
        }),
        dataType: 'json'
    });
}

function approvedRequest() {

    if (approveRecordID == 0)
        return;

    $.ajax({
        type: "POST",
        url: site_url + 'api/request/approve',
        data: {
            id: approveRecordID,
            '_token': '{{ csrf_token() }}'
        },
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'Failed when approving record.'
            });
        }),
        success: (function(data) {

            $.toaster({
                priority: 'success',
                title: 'Info',
                message: 'Request has been approved.'
            });
            // $('#modal-confirm').modal('toggle');
            table.ajax.reload();
            $('#modal-form').removeClass('show');
            $('.modal-backdrop').remove();
        }),
        dataType: 'json'
    });
}



var rejectRecordID = 0;

function rejectRequest() {

    if (rejectRecordID == 0)
        return;

    $.ajax({
        type: "POST",
        url: site_url + 'api/request/reject',
        data: {
            id: rejectRecordID,
            '_token': '{{ csrf_token() }}'
        },
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'Failed when rejecting record.'
            });
        }),
        success: (function(data) {

            $.toaster({
                priority: 'success',
                title: 'Info',
                message: 'Request has been rejected.'
            });
            // $('#modal-reject').modal('toggle');
            table.ajax.reload();
            $('#modal-reject').removeClass('show');
            $('.modal-backdrop').remove();
        }),
        dataType: 'json'
    });
}


$(document).on('hide.bs.modal', '#modal-form', function() {
    $('#entry_edit_form').trigger("reset");
    $("#saveBTN").attr("onclick", "saveForm()");
    $("#saveBTN").html("Save");
    $("#modal-form-title").html("User Add Form");
});
</script>

@stop