@extends('layouts.master')
@section('title')
    <title>Students</title>
@endsection
@section('content')
    <div class="page__heading">
        <div class="container-fluid page__container">
            <h1 class="mb-0">Students</h1>
        </div>
    </div>
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-large bg-light d-flex align-items-center">
                        <div class="flex">
                            <div class="card-subtitle text-muted">List of Registered Students</div>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Register New Student</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>
                    </div>
                    <div class="card-body">
                        <table id="student" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>phone</th>
                                    <th>Province</th>
                                    <th>School</th>
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
                                <label for="first_name">name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                                    value="{{ old('name') }}" required="">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                                    value="{{ old('email') }}" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Phone"
                                    value="{{ old('phone_no') }}" required="">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="province_id">Province</label>
                                    <select id="province_id" data-toggle="select" name="province_id" class="form-control" required>
                                        <option value="">select</option>
                                        @foreach($provinces as $province)
                                        <option {{old('province_id') == $province->id ? 'selected' : ''}}
                                                value="{{$province->id}}">
                                                {{$province->name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="district_id">District</label>
                                    <select id="district_id" data-toggle="select" name="district_id" class="form-control" required="">
                                        <option value="">select</option>
                                    </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="school_id">School</label>
                                    <select id="school_id" data-toggle="select" name="school_id" class="form-control" required>
                                        <option value="">select</option>
                                        @foreach($schools as $school)
                                        <option {{old('school_id') == $school->id ? 'selected' : ''}}
                                                value="{{$school->id}}">
                                                {{$school->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="grade">Grade</label>
                                    <select id="grade_id" data-toggle="select" name="grade_id" class="form-control" required>
                                        <option value="">select</option>
                                        @foreach($grades as $grade)
                                        <option {{old('grade_id') == $grade->id ? 'selected' : ''}}
                                                value="{{$grade->id}}">
                                                {{$grade->name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                                    value="{{ old('password') }}" required="">
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
    var table = $('#student').DataTable({
        serverSide: true,
        ajax: {
            url: site_url + 'api/student/list',
            type: 'POST',
            data: {

                '_token': '{{ csrf_token() }}'
            }
        },
        columns: [{
                data: 'name'
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
                data: 'school'
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
    var url =site_url+'api/student/save';
    var data = {
        '_token': '{{ csrf_token() }}',
        name: $('#name').val(),
        email: $('#email').val(),
        phone_no: $('#phone_no').val(),
        province_id: $('#province_id').val(),
        district_id: $('#district_id').val(),
        school_id: $('#school_id').val(),
        grade_id: $('#grade_id').val(),
        password: $('#password').val(),
    };
    if (!(id === undefined)) {
        url =site_url+'api/student/update';
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
        }),
        dataType: 'json'
    });
}
    // function saveForm(id) {
    //     if (!$('#entry_edit_form')[0].checkValidity())
    //         $.toaster({
    //             priority: 'danger',
    //             title: 'Info',
    //             message: 'Some required fields missing data.'
    //         });

    //     var url = site_url + 'api/student/save';
    //     var data = {
    //         '_token': '{{ csrf_token() }}',
    //         name: $('#name').val(),
    //         last_name: $('#last_name').val(),
    //         email: $('#email').val(),
    //     };
    //     if (!(id === undefined)) {
    //         url = site_url + 'api/student/update';
    //         data.id = id;
    //     }
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         data: data,
    //         fail: (function() {
    //             $.toaster({
    //                 priority: 'danger',
    //                 title: 'Info',
    //                 message: 'There was error saving record.'
    //             });
    //         }),
    //         success: (function(data) {

    //             if ((id === undefined)) {
    //                 $.toaster({
    //                     priority: 'success',
    //                     title: 'Info',
    //                     message: 'Record has been added.'
    //                 });
    //                 $('#entry_edit_form').trigger("reset");
    //             } else {
    //                 $.toaster({
    //                     priority: 'success',
    //                     title: 'Info',
    //                     message: 'Record has been updated.'
    //                 });
    //             }
    //             table.ajax.reload();
    //         }),
    //         dataType: 'json'
    //     });
    // }

    function closeModal(){
    $('#modal-confirm').removeClass('show');
    $('.modal-backdrop').remove();
}

    function loadRecord(id) {
        $.ajax({
            type: "POST",
            url: site_url + 'api/student/show',
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
                $('#name').val(data.name);
                $('#last_name').val(data.last_name);
                $('#email').val(data.email);
                $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
                $("#saveBTN").html("Update");
                $("#modal-form-title").html("Student Update Form");

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
            url: site_url + 'api/student/delete',
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
        $("#modal-form-title").html("Student Save Form");
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
