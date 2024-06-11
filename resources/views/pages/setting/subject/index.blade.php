@extends('layouts.master')
@section('title')
<title>subjects</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Subjects</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Subjects</div>
                    </div>
                    <a class="btn btn-danger" href="{{ route('grade.index') }}" style="margin-right: 5px;">Back</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                        Record</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="subject" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                            <th style="display:none">Updated at</th>
                                <th>Number</th>
                                <th>Subject Name</th>
                                <th>Number of Lessons</th>
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
                <h5 class="modal-title" id="modal-form-title">Subject</h5>
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
                                <label class="text-label" for="number">Number:</label>
                                <div class="input-group input-group-merge">
                                    <input id="number" type="text" required=""
                                        class="form-control form-control-prepended" placeholder="Number"
                                        value="{{ old('number') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-list-ol"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="name">Subject Name:</label>
                                <div class="input-group input-group-merge">
                                    <input id="name" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="Subject Name" value="{{ old('name') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
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
                            <div class="col-12 col-md-12 mb-3" id="file_field">
                                    <label class="text-label" for="file">File:</label>
                                    <div class="input-group input-group-merge">
                                        <label for="file" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload File
                                        </label>
                                        <input id="icon" name="icon" class="file_input visually-hidden" type="file">
                                            <div class="file_status"></div>
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
                <h5 class="modal-title" id="modal-form-title">Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="me-1">Number:</div>
                    <div id = "subject_number" class="text-muted"></div>
                </div>
                <div class="col-md-6">
                    <div class="me-1">Subject Name:</div>
                    <div id = "subject_name" class="text-muted"></div>
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <div class="me-1">Status:</div>
                    <div id = "subject_status" class="text-muted"></div>
                </div>
            </div>
            <div class="row g-3 mt-2">
            <div class="col-md-12 table-responsive">
    <table id="subjects_table" class="table table-bordered">
        <thead>
        <tr>
            <th colspan="3" class="title">List of Subject Lessons</th>
        </tr>
            <tr>
                <th>Number</th>
                <th>Title</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="grades_table_body"></tbody>
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
<style>
    #subjects_table th.title {
        text-align: center;
    }
    </style>
@stop
@section('scripts')


<script type="text/javascript">
var table = $('#subject').DataTable({
    dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: ['pageLength', {
            extend: 'excelHtml5',

            exportOptions: {
                columns: [1, 2, 3, 4]
            }
        }, ],
    serverSide: true,
    ajax: {
        url: site_url + 'api/subject/list',
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
            data: 'number'
        },
        {
            data: 'name'
        },
        {
            data: 'chapter_count'
        },
        {
            data: 'subject_status'
        },
        {
            data: 'actions'
        }
    ],
    processing: true,
    order: [[0, 'desc']],
    serverSide: true
});


function saveForm(id) {
    var url = site_url + 'api/subject/save';
    var data = new FormData(); // Create a new FormData object
    
    // Append form data
    data.append('_token', '{{ csrf_token() }}');
    data.append('number', $('#number').val());
    data.append('name', $('#name').val());
    data.append('grade_id', gradeId);
    data.append('status', $('#status').val());
    data.append('icon', $('#icon')[0].files[0]); // Append the selected file

    if (!(id === undefined)) {
        url = site_url + 'api/subject/update';
        data.append('id', id);
    }
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        processData: false, // Ensure that jQuery does not process the data
        contentType: false, // Set the contentType to false so that jQuery does not set it automatically
        error: function(xhr, textStatus, errorThrown) {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: xhr.responseJSON.message
            });
        },
        success: function(data) {
            if (id === undefined) {
                $.toaster({
                    priority: 'success',
                    title: 'Info',
                    message: 'Record has been added successfully.'
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
        },
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
        url: site_url + 'api/subject/show',
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
            $('#subject_number').text(data.number);
            $('#subject_name').text(data.name);
            $('#subject_status').text(data.subject_status);
            $('#subject_created_at').text(data.subject_created_at);
            $('#subject_updated_at').text(data.subject_updated_at);
            $('#number').val(data.number);
            $('#name').val(data.name);
            $('#status').val(data.status);
            if (data.body == '') {
                            $("#icon").hide();
                        } else {
                            $("#icon").show();
                            $("#icon").attr('href', site_url + data.body);
                            $("#icon").find('img').attr('src', site_url + data.body);
                        }
            var lessonsHtml = '';
            if (data.lessons != null && data.lessons.length > 0) {
                $.each(data.lessons, function(key, value) {
                    lessonsHtml += '<tr>';
                    lessonsHtml += '<td>' + value.number + '</td>';
                    lessonsHtml += '<td>' + value.name + '</td>';
                    lessonsHtml += '<td>' + (value.status ? 'Active' : 'Inactive') + '</td>';
                    lessonsHtml += '</tr>';
        });
            } else {
                lessonsHtml = '<tr><td colspan="3">No grades available.</td></tr>';
            }
            $('#grades_table_body').html(lessonsHtml);

            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").html("Update");
            $("#modal-form-title").html("Subject");

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
        url: site_url + 'api/subject/delete',
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
            $('#modal-confirm').removeClass('show');
            $('.modal-backdrop').remove();
            table.ajax.reload();
        }),
        dataType: 'json'
    });
}
$(document).on('hide.bs.modal', '#modal-form', function() {
    $('#entry_edit_form').trigger("reset");
    $("#saveBTN").attr("onclick", "saveForm()");
    $("#saveBTN").html("Save");
    $("#modal-form-title").html("Subject");
});

$(document).ready(function() {
        $('.file_input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            var statusElement = $(this).next('.file_status');
            if (fileName) {
                statusElement.text('File uploaded: ' + fileName);
            } else {
                statusElement.text('No file uploaded');
            }
        });
});
</script>

@stop