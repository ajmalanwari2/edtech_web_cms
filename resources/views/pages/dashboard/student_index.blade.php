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
                        <div class="card-subtitle text-muted">List of Students</div>
                    </div>
                    <a class="btn btn-danger" href="{{ route('dashboard.index') }}" style="margin-right: 5px;">Back</a>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <div class="datatable-scroll-shell">
                        <table id="course" class="display table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="display:none">Updated ar</th>
                                    <th>Full Name</th>
                                    <th>Identification Number</th>
                                    <th>School Name</th>
                                    <th>Grade Number</th>
                                    <th>Phone Number</th>
                                    <th>Email Address</th>
                                    <th>Province</th>
                                    <th>Gender</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('modals')



<!-- VIEW FORM START-->
<div id="modal-view" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-title">Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="me-1">Number:</div>
                        <div id="course_number" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Course Name:</div>
                        <div id="course_name" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Course Status:</div>
                        <div id="course_status" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="contentTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="3" class="title">Course Contents</th>
                                </tr>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Content</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be dynamically populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div>
<!-- VIEW FORM END-->
@endsection


@endsection


@section('styles')
<style>
#contentTable th.title {
    text-align: center;
}

#contentTable {
    border-collapse: collapse;
}

#contentTable th,
#contentTable td {
    padding: 5px;
}

#contentTable tbody tr {
    height: 30px;
}
</style>

@stop
@section('scripts')


<script type="text/javascript">

var table = $('#course').DataTable({
     dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: ['pageLength', {
            extend: 'excelHtml5',

            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8]
            }
        }, ],
    serverSide: true,
    ajax: {
        url: site_url + 'api/dashboard/student-list',
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}'
        }
    },
    columns: [
        {
            data: null,
            visible: false, // Hide the column
            orderable: true, // Enable ordering on the column
            render: function (data, type, row) {
                return data.updated_at; // Return the value for ordering
            }
        },
        {
            data: 'full_name'
        },
        {
            data: 'indentification_number'
        },
        {
            data: 'school_name'
        },
        {
            data: 'grade_name'
        },
        {
            data: 'phone_number'
        },
        {
            data: 'email'
        },
        {
            data: 'province_name'
        },
        {
            data: 'gender'
        }
    ],
    processing: true,
    order: [[0, 'desc']] // Apply descending order to the first column
});


function saveForm(id) {
    var url = site_url + 'api/course/save';
    var data = {
        '_token': '{{ csrf_token() }}',
        number: $('#number').val(),
        name: $('#name').val(),
        description: $('#description').val(),
        status: $('#status').val(),
    };
    if (!(id === undefined)) {
        url = site_url + 'api/course/update';
        data.id = id;
    }
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        error: function(xhr, textStatus, errorThrown) {
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
        url: site_url + 'api/course/show',
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
            $('#course_number').text(data.number);
            $('#course_name').text(data.name);
            $('#course_status').text(data.course_status);
            $('#course_description').text(data.description);
            $('#number').val(data.number);
            $('#name').val(data.name);
            $('#status').val(data.status);
            $('#description').val(data.description);
            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").html("Update");
            $("#modal-form-title").html("Course");

            var contentsHtml = '';
            $.each(data.contents, function(key, value) {
                contentsHtml += '<tr>';
                contentsHtml += '<td>' + value.title + '</td>';
                contentsHtml += '<td>' + value.type + '</td>';
                if (value.type === 'video') {
                    contentsHtml += '<td><a href="' + value.body + '" target="_blank">Download Content</a></td>'; 
                } else {
                    contentsHtml += '<td>' + value.body + '</td>';
                }
                
                contentsHtml += '</tr>';
            });
            $('#contentTable tbody').html(contentsHtml);
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
        url: site_url + 'api/course/delete',
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
    $("#modal-form-title").html("Subject Add Form");
});
    </script>

@stop
