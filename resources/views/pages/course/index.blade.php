@extends('layouts.master')
@section('title')
<title>Course</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Courses</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Courses</div>
                    </div>
                    <a class="btn btn-danger" href="{{ route('dashboard.index') }}" style="margin-right: 5px;">Back</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                        Record</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="course" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="display:none">Updated at</th>
                                <th>Number</th>
                                <th>Course Name</th>
                                <th>Content Types</th>
                                <th>Language</th>
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

<div id="modal-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <div id="form-fields-container">
                    <form action="#" method="post" enctype="multipart/form-data" id="entry_edit_form">
                        @csrf
                        <div class="was-validated">
                            <div class="form-row form-row-add">
                                <!-- Your existing form fields here -->
                                <div class="col-12 col-md-4 mb-3">
                                    <label class="text-label" for="number_add">Number:</label>
                                    <div class="input-group input-group-merge">
                                        <input id="number_add" type="text" required=""
                                            class="form-control form-control-prepended number-field"
                                            placeholder="Number" value="">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-list-ol"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label class="text-label" for="name_add">Course Name:</label>
                                    <div class="input-group input-group-merge">
                                        <input id="name_add" type="text" required=""
                                            class="form-control form-control-prepended name-field"
                                            placeholder="Course Name" value="{{ old('name_add') }}">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-home"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label class="text-label" for="status_add">Status:</label>
                                    <div class="input-group input-group-merge">
                                        <select id="status_add" data-toggle="select" name="status_add"
                                            class="form-control status-field" required="">
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
                                <div class="col-12 col-md-4 mb-3">
                                    <label class="text-label" for="total_quiz_time_add">Total Quiz Time (min):</label>
                                    <div class="input-group input-group-merge">
                                        <input id="total_quiz_time_add" type="number" required=""
                                            class="form-control form-control-prepended total_quize_time-field"
                                            placeholder="Total Quiz Time" value="{{ old('total_quiz_time_add') }}">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-user-clock"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="email">Language:</label>
                                <div class="input-group input-group-merge">
                                    <select id="language_add" data-toggle="select" name="language_add" class="form-control language-field"
                                        required="">
                                        <option value="">Select</option>
                                        <option value="en">English</option>
                                        <option value="da">Dari</option>
                                        <option value="pa">Pashto</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-eye-slash"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                    <label class="text-label" for="description_add">Course Description:</label>
                                    <div class="input-group input-group-merge">
                                        <input id="description_add" type="text" required=""
                                            class="form-control form-control-prepended description-field"
                                            placeholder="Course Description" value="{{ old('description_add') }}">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-home"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 mb-3" id="file_field">
                                    <label class="text-label" for="file">Icon:</label>
                                    <div class="input-group input-group-merge">
                                        <label for="icon1" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload Icon
                                        </label>
                                        <input id="icon1" name="icon" class="file_input visually-hidden icon-field" type="file">
                                            <div class="file_status"></div>
                                    </div>
                            </div>
                                <div class="col-12 col-md-1" style="margin-top: 26px !important">
                                    <a href="javascript:void(0)" class="addRowBtn"><i class="material-icons"
                                            style="color:darkblue">add</i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBTN" onclick="saveForm()">Save</button>
            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div>
</div>


<!-- EDIT FORM START-->
<div id="edit-modal-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-modal-form-title">Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data" id="entry_edit_form">
                    @csrf
                    <div class="was-validated">
                        <div class="form-row">
                            <div class="col-12 col-md-4 mb-3">
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
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="name">Course Name:</label>
                                <div class="input-group input-group-merge">
                                    <input id="name" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="Course Name" value="{{ old('name') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="status">Status:</label>
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
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="number">Total Quiz Time (min):</label>
                                <div class="input-group input-group-merge">
                                    <input id="total_quiz_time" type="number" required=""
                                        class="form-control form-control-prepended" placeholder="Total Quiz Time"
                                        value="{{ old('total_quiz_time') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-user-clock"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="email">Language:</label>
                                <div class="input-group input-group-merge">
                                    <select id="language" data-toggle="select" name="language" class="form-control language-field"
                                        required="">
                                        <option value="">Select</option>
                                        <option value="en">English</option>
                                        <option value="da">Dari</option>
                                        <option value="pa">Pashto</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-eye-slash"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="description">Course Description:</label>
                                <div class="input-group input-group-merge">
                                    <input id="description" type="text" required=""
                                        class="form-control form-control-prepended" placeholder="Course Description"
                                        value="{{ old('description') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3" id="file_field">
                                    <label class="text-label" for="file">Icon:</label>
                                    <div class="input-group input-group-merge">
                                        <label for="icon" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload Icon
                                        </label>
                                        <input id="icon" name="icon" class="file_input visually-hidden icon-field" type="file">
                                            <div class="file_status"></div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editBTN" onclick="editSaveForm()">Edit</button>
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
                    <div class="col-md-6">
                        <div class="me-1">Course Language:</div>
                        <div id="course_language" class="text-muted"></div>
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
.modal-lg {
    max-width: 950px !important;
}

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
            columns: [1, 2, 3, 4]
        }
    }, ],
    serverSide: true,
    ajax: {
        url: site_url + 'api/course/list',
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}'
        }
    },
    columns: [{
            data: null,
            visible: false,
            orderable: true,
            render: function(data, type, row) {
                return data.updated_at;
            }
        },
        {
            data: 'number'
        },
        {
            data: 'name'
        },
        {
            data: 'content_types'
        },
        {
            data: 'language'
        },
        {
            data: 'course_status'
        },
        {
            data: 'actions'
        }
    ],
    processing: true,
    serverSide: true
});


var csrfToken = '{{ csrf_token() }}'; // Assign CSRF token value to a JavaScript variable

function saveForm() {
    var url = site_url + 'api/course/save';
    //   var formDataArray = [];
    var data = new FormData();
    var count = 0;
    $('.form-row-add').each(function(index) {
        count++;
        var row = $(this);
        var numberField = row.find('.number-field');
        var number = numberField.val();
        var nameField = row.find('.name-field');
        var name = nameField.val();
        var statusField = row.find('.status-field');
        var status = statusField.val();
        var totalQuizTimeField = row.find('.total_quize_time-field');
        var total_quiz_time = totalQuizTimeField.val();
        var descriptionField = row.find('.description-field');
        var description = descriptionField.val();
        var languageField = row.find('.language-field');
        var language = languageField.val();
        var iconField = row.find('.icon-field');
        var icon = iconField[0] ? iconField[0].files[0] : null; // Check if the iconField exists before accessing its value


        data.append('number' + index, number);
        data.append('name' + index, name);
        data.append('status' + index, status);
        data.append('total_quiz_time' + index, total_quiz_time);
        data.append('language' + index, language);
        data.append('description' + index, description);
        if (icon) {
            data.append('icon' + index, icon);
        }
        data.append('_token', csrfToken); // Include the CSRF token in the form data
    });
    data.append('count', count);

    // Send formDataArray to the server using AJAX request
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        processData: false, // Prevent jQuery from transforming the data
        contentType: false, // Let the browser set the correct content type automatically
        headers: {
            'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
        },
        error: function(xhr, textStatus, errorThrown) {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: xhr.responseJSON.message
            });
        },
        success: function(data) {
            $.toaster({
                priority: 'success',
                title: 'Info',
                message: 'Record has been updated successfully.'
            });
            table.ajax.reload();
            $('#modal-form').removeClass('show');
            $('.modal-backdrop').remove();
        },
        dataType: 'json'
    });
}
var formCounter = 0; // Counter to track the number of forms
$(document).ready(function() {
    var formCounter = 1; // Counter for unique ID generation
    // Add new row on button click
    $(document).on('click', '.addRowBtn', function() {
        var formId = 'dynamic_form_' + formCounter; // Create a unique form ID

        var newRow = $('<div class="was-validated">' +
            '<div class="form-row form-row-add">' +
            '<div class="col-12 col-md-4 mb-3">' +
            '<label class="text-label" for="' + formId + '_number">Number:</label>' +
            '<div class="input-group input-group-merge">' +
            '<input id="' + formId +
            '_number" type="text" required="" class="form-control form-control-prepended number-field" placeholder="Number" value="">' +
            '<div class="input-group-prepend">' +
            '<div class="input-group-text">' +
            '<span class="fas fa-list-ol"></span>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-4 mb-3">' +
            '<label class="text-label" for="' + formId + '_name">Course Name:</label>' +
            '<div class="input-group input-group-merge">' +
            '<input id="' + formId +
            '_name" type="text" required="" class="form-control form-control-prepended name-field" placeholder="Course Name" value="">' +
            '<div class="input-group-prepend">' +
            '<div class="input-group-text">' +
            '<span class="fas fa-home"></span>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-4 mb-3">' +
            '<label class="text-label"for="' + formId + '_status">Status:</label>' +
            '<div class="input-group input-group-merge">' +
            '<select id="' + formId + '_status" data-toggle="select" name="' + formId +
            '_status" class="form-control status-field" required="">' +
            '<option value="">Select</option>' +
            '<option value="1">Active</option>' +
            '<option value="0">Inactive</option>' +
            '</select>' +
            '<div class="input-group-prepend">' +
            '<div class="input-group-text">' +
            '<span class="fas fa-eye-slash"></span>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-4 mb-3">' +
            '<label class="text-label" for="' + formId +
            '_description">Total Quiz Time (min):</label>' +
            '<div class="input-group input-group-merge">' +
            '<input id="' + formId +
            '_description" type="number" required="" class="form-control form-control-prepended total_quize_time-field" placeholder="Total Quiz Time" value="">' +
            '<div class="input-group-prepend">' +
            '<div class="input-group-text">' +
            ' <span class="fas fa-user-clock"></span>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-4 mb-3">' +
            '<label class="text-label" for="email">Language:</label>' +
            '<div class="input-group input-group-merge">' +
            '<select id="' + formId + '_language" data-toggle="select" name="' + formId + '_language" class="form-control language-field" required="">' +
            '<option value="">Select</option>' +
            '<option value="en">English</option>' +
            '<option value="da">Dari</option>' +
            '<option value="pa">Pashto</option>' +
            '</select>' +
            '<div class="input-group-prepend">' +
            '<div class="input-group-text">' +
            '<span class="fas fa-eye-slash"></span>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-4 mb-3">' +
            '<label class="text-label" for="' + formId +
            '_description">Course Description:</label>' +
            '<div class="input-group input-group-merge">' +
            '<input id="' + formId +
            '_description" type="text" required="" class="form-control form-control-prepended description-field" placeholder="Course Description" value="">' +
            '<div class="input-group-prepend">' +
            '<div class="input-group-text">' +
            '<span class="fas fa-home"></span>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-3 mb-3" id="file_field">' +
            '<label class="text-label" for="file">Icon:</label>'+
            '<div class="input-group input-group-merge">'+
            '<label for="icon1" class="file_uploads">'+
            '<i class="fa fa-paperclip"></i> Upload File</label>'+
            '<input id="icon1" name="icon" class="file_input visually-hidden icon-field" type="file">'+
            '<div class="file_status"></div>'+
            '</div>'+
            '</div>'+
            '<div class="col-12 col-md-1" style="margin-top: 26px !important">' +
            '<a href="#" class="deleteRowBtn" onclick="deleteRow(this)"><i class="material-icons" style="color:red">delete</i></a>' +
            '</div>' +
            '</div>' +
            '</div>');

        $('#form-fields-container').append(newRow);
        formCounter++;
    });

    // Delete row on button click
    $(document).on('click', '.deleteRowBtn', function() {
        $(this).closest('.form-row').remove();
    });
});

function closeModal() {
    $('#modal-confirm').removeClass('show');
    $('.modal-backdrop').remove();
}



function editSaveForm(id) {
    var url = site_url + 'api/course/save';
    var data = new FormData(); // Create a new FormData object

    // Append form data
    data.append('_token', '{{ csrf_token() }}');
    data.append('number', $('#number').val());
    data.append('name', $('#name').val());
    data.append('description', $('#description').val());
    data.append('total_quiz_time', $('#total_quiz_time').val());
    data.append('status', $('#status').val());
    data.append('language', $('#language').val());
    data.append('icon', $('#icon')[0].files[0]); // Append the selected file
    if (!(id === undefined)) {
        url = site_url + 'api/course/update';
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
            $('#edit-modal-form').removeClass('show');
            $('.modal-backdrop').remove();
        },
        dataType: 'json'
    });
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
            $('#course_language').text(data.language);
            $('#course_description').text(data.description);
            $('#number').val(data.number);
            $('#name').val(data.name);
            $('#status').val(data.status);
            $('#language').val(data.language);
            $('#total_quiz_time').val(data.total_quiz_time);
            $('#description').val(data.description);
            $('.file_status').text(data.icon);
                if (data.icon == '') {
                            $("#icon").hide();
                        } else {
                            $("#icon").show();
                            $("#icon").attr('href', site_url + data.icon);
                            $("#icon").find('img').attr('src', site_url + data.icon);
                        }
            $("#editBTN").attr("onclick", "editSaveForm(" + data.id + ")");
            $("#editBTN").html("Update");
            $("#edit-modal-form-title").html("Course");

            var contentsHtml = '';
            $.each(data.contents, function(key, value) {
                contentsHtml += '<tr>';
                contentsHtml += '<td>' + value.title + '</td>';
                contentsHtml += '<td>' + value.type + '</td>';
               
                    contentsHtml += '<td><a href="' + value.body +
                        '" target="_blank">Download Content</a></td>';

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
    $("#modal-form-title").html("Course");
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