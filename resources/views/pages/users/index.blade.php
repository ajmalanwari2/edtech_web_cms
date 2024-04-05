@extends('layouts.master')
@section('title')
    <title>users</title>
@endsection
@section('content')
    <div class="page__heading">
        <div class="container-fluid page__container">
            <h1 class="mb-0">Registerd Users</h1>
        </div>
    </div>
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-large bg-light d-flex align-items-center">
                        <div class="flex">
                            <div class="card-subtitle text-muted">List of Registered Users</div>
                        </div>
                        <a class="btn btn-danger" href="{{ route('dashboard.index') }}" style="margin-right: 5px;">Back</a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New User</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>
                    </div>
                    <div class="card-body">
                        <table id="user" class="display" style="width:100%">
                            <thead> 
                                <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Province</th>
                                <th>District</th>
                                <th>School</th>
                                <th>Grade</th>
                                <th>Role</th>
                                <th>Status</th>
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
                <h5 class="modal-title" id="modal-form-title">Add New User Form</h5>
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
                            <input id="name"  name="name" type="text" required="" class="form-control form-control-prepended"
                             placeholder="Full Name" value="{{ old('name') }}">
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
                            <input id="email"  name="email" type="text" required="" 
                            class="form-control form-control-prepended"
                             placeholder="Email" value="{{ old('email') }}">
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
                    <label class="text-label" for="identity_number">Identity Number:</label>
                        <div class="input-group input-group-merge">
                            <input id="identity_number" name="identity_number" type="text" required="" class="form-control form-control-prepended" placeholder="Identity Number">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <span class="far fa-user-circle"></span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="col-12 col-md-6 mb-3">
                    <label class="text-label" for="email">Language:</label>
                        <div class="input-group input-group-merge">
                            <select id="language" data-toggle="select" name="language" class="form-control" required="">
                                            <option value="" >Select</option>
                                            <option value="en" >English</option>
                                            <option value="da" >Dari</option>
                                            <option value="pa" >Pashto</option>
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
                        <label class="text-label" for="email">Phone:</label>
                        <div class="input-group input-group-merge">
                            <input id="phone_no"  name="phone_no" type="text" required="" class="form-control form-control-prepended"
                             placeholder="Phone" value="{{ old('phone_no') }}">
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
                                <label class="text-label" for="email">Status:</label>
                                <div class="input-group input-group-merge">
                                    <select id="status" data-toggle="select" name="status" class="form-control"
                                        required="">
                                        <option value="">Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">In active</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <span class="fas fa-eye-slash"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="role">Role:</label>
                                <div class="input-group input-group-merge">
                                    <select id="role" data-toggle="select" name="role" class="form-control"
                                        required="">
                                        <option value="" >Select</option>
                                            <option value="student" >student</option>
                                            <option value="parent" >parent</option>
                                            <option value="teacher" >teacher</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <span class="fas fa-eye-slash"></span>
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
                <h5 class="modal-title" id="modal-form-title">Users View Form </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="me-1">Number:</div>
                        <div id="user_id" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">FullName:</div>
                        <div id="user_username" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">UserName:</div>
                        <div id="user_email" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Phone:</div>
                        <div id="user_phone" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Gender:</div>
                        <div id="user_gender" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">DOB:</div>
                        <div id="user_dob" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Province:</div>
                        <div id="user_province" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">District:</div>
                        <div id="user_district" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">School:</div>
                        <div id="user_school" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Grade:</div>
                        <div id="user_grade" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Role:</div>
                        <div id="user_role" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Status:</div>
                        <div id="user_status" class="text-muted"></div>
                    </div>
                </div>
        </div> <!-- // END .modal-body -->
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary" onclick="approveduserView()">Approve</button> -->
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
                <i class="material-icons icon-40pt text-warning mb-2">warning</i>
                <h6>Do you want to delete the record!</h6>
                <button type="button" class="btn btn-light" onclick="closeModal()">No</button>
                <button type="button" class="btn btn-warning my-2" onclick="deleteRecord()">Yes</button>
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
    var table = $('#user').DataTable({
        serverSide: true,
        ajax: {
            url: site_url + 'api/user/list',
            type: 'POST',
            data: {

                '_token': '{{ csrf_token() }}'
            }
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'name'
            },
            {
                data: 'identity_number'
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
                data: 'status'
            },
            {
                data: 'actions'
            }
        ],
        processing: true,
        serverSide: true
    });

    function saveForm(id) {
        if (!$('#entry_edit_form')[0].checkValidity())
        $.toaster({
            priority: 'danger',
            title: 'Info',
            message: 'Some required fields missing data.'
        });
    var url =site_url+'api/user/save';
    var data = {
        '_token': '{{ csrf_token() }}',
        name: $('#name').val(),
        email: $('#email').val(),
        phone_no: $('#phone_no').val(),
        identity_number: $('#identity_number').val(),
        gender: $('#gender').val(),
        language: $('#language').val(),
        dob: $('#dob').val(),
        province_id: $('#province_id').val(),
        district_id: $('#district_id').val(),
        school_id: $('#school_id').val(),
        grade_id: $('#grade_id').val(),
        status: $('#status').val(),
        role: $('#role').val(),
        password: $('#password').val(),
    };
    if (!(id === undefined)) {
        url =site_url+'api/user/update';
        data.id = id;
    }
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        error: function(xhr, textStatus, errorThrown){
            console.log(xhr, textStatus, errorThrown);
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: xhr.responseJSON.message
            });
    },
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
 

    function closeModal(){
    $('#modal-confirm').removeClass('show');
    $('.modal-backdrop').remove();
}

    function loadRecord(id) {
        $.ajax({
            type: "POST",
            url: site_url + 'api/user/show',
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
            $('#user_id').text(data.id);
            $('#user_username').text(data.name);
            $('#user_email').text(data.email);
            $('#user_phone').text(data.user_phone);
            $('#user_province').text(data.user_province);
            $('#user_district').text(data.user_district);
            $('#user_school').text(data.user_school);
            $('#user_grade').text(data.user_grade);
            $('#user_role').text(data.role);
            $('#user_status').text(data.user_status);
            $('#user_gender').text(data.user_gender);
            $('#user_dob').text(data.user_dob);
            $('#status').val(data.status);
            $('#role').val(data.role);
            $('#password').val(data.password);
            $('#name').val(data.name);
            $('#identity_number').val(data.identity_number);
            $('#email').val(data.email);
            $('#phone_no').val(data.user_phone);
            $('#gender').val(data.user_gender);
            $('#language').val(data.language);
            $('#dob').val(data.user_dob);
            $('#province_id').val(data.province_id);
            $('#district_id').val(data.district_id);
            $('#school_id').val(data.school_id);
            $('#grade_id').val(data.grade_id);
            $('#password').val(data.password);
            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").attr("change", "backendValidation(" + data.id + ")");
            $("#saveBTN").html("Update");
            $("#modal-form-title").html("User Update Form");

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
            url: site_url + 'api/user/delete',
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
    $(document).on('hide.bs.modal', '#modal-form', function() {
        $('#entry_edit_form').trigger("reset");
        $("#saveBTN").attr("onclick", "saveForm()");
        $("#saveBTN").html("Save");
        $("#modal-form-title").html("Add New User Form");
    });

    $(document).ready(function(){
    $('#province_id').change(function(){
       let pro_id = $(this).val();
       let data = {
        'pro_id': $(this).val(),
        '_token': '{{ csrf_token() }}',
       };
       $.ajax({
            url: '/get_districts',
            type: 'post',
            data : data,
            success: function(res){
                $('#district_id').html(res);
            }
       });
    });
});

</script>

@stop
