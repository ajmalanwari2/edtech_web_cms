@extends('layouts.master')
@section('title')
<title>Contents</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Lessons</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Lessons</div>
                    </div>
                    <a class="btn btn-danger" href="{{ route('subject.index') }}" style="margin-right: 5px;">Back</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                        Record</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="chapter" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="display:none">Updated at</th>
                                <th>Number</th>
                                <th>Title</th>
                                <th>Subject Name</th>
                                <th>Grade Name</th>
                                <th>Content Types</th>
                                <th>Quiz Include</th>
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

<!-- ADD FORM START-->
<div id="modal-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <div id="form-fields-container">
                    <form action="#" method="post" enctype="multipart/form-data" id="entry_edit_form">
                        @csrf
                        <div class="was-validated">
                            <div class="form-row">
                                <!-- Your existing form fields here -->
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="number_add">Number:</label>
                                <div class="input-group input-group-merge">
                                    <input id="number_add" type="text" required=""
                                        class="form-control form-control-prepended number-field" placeholder="Number"
                                        value="{{ old('number_add') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-list-ol"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="title_add">Title:</label>
                                <div class="input-group input-group-merge">
                                    <input id="name_add" type="text" required="" class="form-control form-control-prepended name-field"
                                        placeholder="Title" value="{{ old('name_add') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="grade_id_add">Grade Name:</label>
                                <div class="input-group input-group-merge">
                                    <select id="grade_id_add" data-toggle="select" name="grade_id_add" class="form-control grade-field"
                                        required="">
                                        <option value="">select</option>
                                        @foreach ($grades as $grade)
                                        <option {{ old('grade_id_add') == $grade->id ? 'selected' : '' }}
                                            value="{{ $grade->id }}">
                                            {{ $grade->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-igloo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="subject_id_add">Subject Name:</label>
                                <div class="input-group input-group-merge">
                                    <select id="subject_id_add" data-toggle="select" name="subject_id_add" class="form-control subject-field"
                                        required="">
                                        <option value="">select</option>
                                        @foreach ($subjects as $subject)
                                        <option {{ old('subject_id_add') == $subject->id ? 'selected' : '' }}
                                            value="{{ $subject->id }}">
                                            {{ $subject->name }}</option>
                                        @endforeach
                                    </select>
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
                                    <select id="status_add" data-toggle="select" name="status_add" class="form-control status_field"
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
                            <div class="col-12 col-md-3 mb-3">
                                <label class="text-label" for="total_quiz_time_add">Total Quiz Time (min):</label>
                                <div class="input-group input-group-merge">
                                    <input id="total_quiz_time_add" type="number" required=""
                                        class="form-control form-control-prepended total_quize_time-field" placeholder="Total Quiz Time"
                                        value="{{ old('total_quiz_time_add') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-user-clock"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
            <div class="col-12 col-md-1" style="margin-top: 26px !important">
            <a href="javascript:void(0)" class="addRowBtn"><i class="material-icons" style="color:darkblue">add</i></a>
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
<!-- ADD FORM END-->

<!-- EDIT FORM START-->
<div id="edit-modal-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-title">Lesson</h5>
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
                                <label class="text-label" for="title">Title:</label>
                                <div class="input-group input-group-merge">
                                    <input id="name" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="Title" value="{{ old('name') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="email">Grade Name:</label>
                                <div class="input-group input-group-merge">
                                    <select id="grade_id" data-toggle="select" name="grade_id" class="form-control"
                                        required="">
                                        <option value="">select</option>
                                        @foreach ($grades as $grade)
                                        <option {{ old('grade_id') == $grade->id ? 'selected' : '' }}
                                            value="{{ $grade->id }}">
                                            {{ $grade->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-igloo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-label" for="subject_id">Subject Name:</label>
                                <div class="input-group input-group-merge">
                                    <select id="subject_id" data-toggle="select" name="subject_id" class="form-control"
                                        required="">
                                        <option value="">select</option>
                                        @foreach ($subjects as $subject)
                                        <option {{ old('subject_id') == $subject->id ? 'selected' : '' }}
                                            value="{{ $subject->id }}">
                                            {{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
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
                        </div>
                    </div>
                </form>
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editSaveBTN" onclick="editSaveForm()">Save</button>
            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div>
<!-- EDIT FORM END-->

<!-- VIEW FORM START-->
<div id="modal-view" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-title">Lesson</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="me-1">Number:</div>
                        <div id="chapter_number" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Title:</div>
                        <div id="chapter_name" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Grade Name:</div>
                        <div id="grade_name" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Subject Name:</div>
                        <div id="subject_name" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Lesson Status:</div>
                        <div id="chapter_status" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Total Quiz Time (min):</div>
                        <div id="chapter_total_quiz_time" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="contentTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="3" class="title">Lesson Contents</th>
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

<script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>


<script type="text/javascript">
tinymce.init({
    selector: 'textarea'
});

$(document).ready(function() {

    $('#type').on('change', function() {
        if (this.value == 'video') {
            $('#video_field').show();
            $('#text_field').hide();
            $('#file_field').hide();
        } else if (this.value == 'text') {
            $('#text_field').show();
            $('#file_field').hide();
            $('#video_field').hide();
        } else {
            $('#file_field').show();
            $('#text_field').hide();
            $('#video_field').hide();
        }
    });

});

var table = $('#chapter').DataTable({
    dom: 'Bfrtip',
    lengthMenu: [
        [10, 25, 50, -1],
        ['10 rows', '25 rows', '50 rows', 'Show all']
    ],
    buttons: ['pageLength', {
        extend: 'excelHtml5',

        exportOptions: {
            columns: [1, 2, 3, 4, 5, 6]
        }
    }, ],
    serverSide: true,
    ajax: {
        url: site_url + 'api/chapter/list',
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}'
        }
    },
    columns: [{
            data: null,
            visible: false, // Hide the column
            orderable: true, // Enable ordering on the column
            render: function(data, type, row) {
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
            data: 'subject_name'
        },
        {
            data: 'grade_name'
        },
        {
            data: 'lesson_types'
        },
        {
            data: 'quiz_included'
        },
        {
            data: 'actions'
        }
    ],
    processing: true,
    order: [
        [0, 'desc']
    ], // Apply descending order to the first column
    serverSide: true
});

var csrfToken = '{{ csrf_token() }}'; // Assign CSRF token value to a JavaScript variable
function saveForm() {
    var url = site_url + 'api/chapter/save';
    var formData = [];

    $('.form-row').each(function(index) {
        var row = $(this);
        var numberField = row.find('.number-field');
        var number = numberField.val();
        var nameField = row.find('.name-field');
        var name = nameField.val();
        var gradeField = row.find('.grade-field');
        var grade_id = gradeField.val();
        var subjectField = row.find('.subject-field');
        var subject_id = subjectField.val();
        var statusField = row.find('.status-field');
        var status = statusField.val();
        var totalQuizTimeField = row.find('.total_quize_time-field');
        var total_quize_time = totalQuizTimeField.val();

        var data = {
            number: number,
            name: name,
            grade_id: grade_id,
            subject_id: subject_id,
            status: status,
            total_quize_time: total_quize_time,
            _token: csrfToken // Include the CSRF token in the form data
        };

        formData.push(data);
    });

    // Send formData to the server using AJAX request
    $.ajax({
        url: url,
        type: 'POST',
        data: JSON.stringify(formData),
        dataType: 'json',
        contentType: 'application/json',
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
        success: (function(data) {
            $.toaster({
                priority: 'success',
                title: 'Info',
                message: 'Record has been updated successfully.'
            });
            table.ajax.reload();
            $('#modal-form').removeClass('show');
            $('.modal-backdrop').remove();
        }),
        dataType: 'json'
    });
}

function editSaveForm(id) {
    var url = site_url + 'api/chapter/save';
    var data = {
        '_token': '{{ csrf_token() }}',
        number: $('#number').val(),
        name: $('#name').val(),
        grade_id: $('#grade_id').val(),
        subject_id: $('#subject_id').val(),
        status: $('#status').val(),
        total_quiz_time: $('#total_quiz_time').val(),
    };
    if (!(id === undefined)) {
        url = site_url + 'api/chapter/update';
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
            $('#edit-modal-form').removeClass('show');
            $('.modal-backdrop').remove();
        }),
        dataType: 'json'
    });
}


var formCounter = 0; // Counter to track the number of forms
$(document).ready(function() {

    var gradeDrpOptions = `
    <option value="">select</option>
    @foreach ($grades as $grade)
    <option {{ old('grade_id_add') == $grade->id ? 'selected' : '' }}
        value="{{ $grade->id }}">
        {{ $grade->name }}</option>
    @endforeach
`;

var subjectDrpOptions = `
    <option value="">select</option>
    @foreach ($subjects as $subject)
    <option {{ old('subject_id_add') == $subject->id ? 'selected' : '' }}
        value="{{ $subject->id }}">
        {{ $subject->name }}</option>
    @endforeach
`;

    var formCounter = 1; // Counter for unique ID generation
    // Add new row on button click
    $(document).on('click', '.addRowBtn', function() {
        var formId = 'dynamic_form_' + formCounter; // Create a unique form ID

        var newRow = $('<div class="was-validated">' +
            '<div class="form-row">' +
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
            '<label class="text-label" for="' + formId + '_name">Title:</label>' +
            '<div class="input-group input-group-merge">' +
            '<input id="' + formId +
            '_name" type="text" required="" class="form-control form-control-prepended name-field" placeholder="Title" value="">' +
            '<div class="input-group-prepend">' +
            '<div class="input-group-text">' +
            '<span class="fas fa-home"></span>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-4 mb-3">' +
            '<label class="text-label"for="' + formId + '_grade_id">Grade Name:</label>' +
            '<div class="input-group input-group-merge">' +
            '<select id="' + formId + '_grade_id" data-toggle="select" name="' + formId +
            '_grade_id" class="form-control grade-field" required="">' +
            '</select>' +
            '<div class="input-group-prepend">' +
            '<div class="input-group-text">' +
            ' <span class="fas fa-igloo"></span>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-4 mb-3">' +
            '<label class="text-label"for="' + formId + '_subject_id">Subject Name:</label>' +
            '<div class="input-group input-group-merge">' +
            '<select id="' + formId + '_subject_id" data-toggle="select" name="' + formId +
            '_subject_id" class="form-control subject-field" required="">' +
            '</select>' +
            '<div class="input-group-prepend">' +
            '<div class="input-group-text">' +
            ' <span class="fas fa-home"></span>' +
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
            '<div class="col-12 col-md-3 mb-3">' +
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
            '<div class="col-12 col-md-1" style="margin-top: 26px !important">' +
            '<a href="#" class="deleteRowBtn" onclick="deleteRow(this)"><i class="material-icons" style="color:red">delete</i></a>'+
            '</div>' +
            '</div>' +
            '</div>');
        $('#form-fields-container').append(newRow);
        $('#' + formId + '_grade_id').html(gradeDrpOptions);
        $('#' + formId + '_subject_id').html(subjectDrpOptions);

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

function loadRecord(id) {
    $.ajax({
        type: "POST",
        url: site_url + 'api/chapter/show',
        data: {
            id: id,
            '_token': '{{ csrf_token() }}'
        },
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'There was an error loading the record.'
            });
        }),
        success: (function(data) {
            // Set chapter details
            $('#chapter_number').text(data.number);
            $('#chapter_name').text(data.name);
            $('#grade_name').text(data.grade_name);
            $('#subject_name').text(data.subject_name);
            $('#chapter_status').text(data.chapter_status);
            $('#chapter_total_quiz_time').text(data.total_quiz_time);
            $('#number').val(data.number);
            $('#name').val(data.name);
            $('#grade_id').val(data.grade_id);
            $('#subject_id').val(data.subject_id);
            $('#status').val(data.status);
            $('#total_quiz_time').val(data.total_quiz_time);
            $("#editSaveBTN").attr("onclick", "editSaveForm(" + data.id + ")");
            $("#editSaveBTN").html("Save");
            $("#modal-form-title").html("Lesson");
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




function download(filename) {
    $.ajax({
        url: site_url + '/download/' + encodeURIComponent(filename),
        method: 'GET',
        xhrFields: {
            responseType: 'blob' // Important! This ensures the response is treated as a binary blob
        },
        success: function(data) {
            var url = window.URL.createObjectURL(new Blob([data]));
            var link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

$(document).on('hide.bs.modal', '#modal-form', function() {
    $('#entry_edit_form').trigger("reset");
    $("#saveBTN").attr("onclick", "saveForm()");
    $("#saveBTN").html("Save");
    $("#modal-form-title").html("Lesson");

    $('#school_id').val('');
    $('#grade_id').val('');
    $('#subject_id').val('');
});


var deleteRecordID = 0;

function deleteRecord() {

    if (deleteRecordID == 0)
        return;

    $.ajax({
        type: "POST",
        url: site_url + 'api/chapter/delete',
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
           
            // $('#modal-confirm').modal('toggle');
            $('#modal-confirm').removeClass('show');
             $('.modal-backdrop').remove();
            table.ajax.reload();
           
         
              
        }),
        dataType: 'json'
    });
}

$(document).ready(function() {
    $('#grade_id').change(function() {
        let pro_id = $(this).val();
        let data = {
            'grade_id': $(this).val(),
            '_token': '{{ csrf_token() }}',
        };
        $.ajax({
            url: '/get_subjects',
            type: 'post',
            data: data,
            success: function(res) {
                $('#subject_id').html(res);
            }
        });
    });
});
</script>

@stop