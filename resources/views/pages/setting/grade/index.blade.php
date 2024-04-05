@extends('layouts.master')
@section('title')
<title>grades</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Grades</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Grades</div>
                    </div>
                    <a class="btn btn-danger" href="{{ route('dashboard.index') }}" style="margin-right: 5px;">Back</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                        Record</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="grade" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="display:none">Updated at</th>
                                <th>Number</th>
                                <th>Grade Name</th>
                                <th>Number of Subjects</th>
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
<!-- ADD/EDIT FORM START-->
<div id="modal-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-title">Grade </h5>
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
                                <label class="text-label" for="name">Grade Name:</label>
                                <div class="input-group input-group-merge">
                                    <input id="name" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="Grade Name" value="{{ old('name') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-12 col-md-6 mb-3">
                                    <label class="text-label" for="subjects">subjects:</label>
                                    <div class="input-group input-group-merge">
                                    <select id="subjects" name="subjects[]"  required="" data-toggle="select" multiple
                                            class="form-control">
                                            @foreach ($subjects as $subject)
                                                <option  {{ old('subjects') == $subject->id ? 'selected' : '' }}
                                                    value="{{ $subject->id }}">
                                                    {{ $subject->number }} -  {{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-eye-slash"></span>
                                            </div>
                                        </div>
                                    </div>
                            </div> -->
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="email">Language:</label>
                                <div class="input-group input-group-merge">
                                    <select id="language" data-toggle="select" name="language" class="form-control"
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
                <h5 class="modal-title" id="modal-form-title">Grade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="me-1">Number:</div>
                        <div id="grade_number" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Name:</div>
                        <div id="grade_name" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Language:</div>
                        <div id="grade_language" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Status:</div>
                        <div id="grade_status" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="subjects_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="3" class="title">List of Grade Subjects</th>
                                </tr>
                                <tr>
                                    <th>Number</th>
                                    <th>Subject Name</th>
                                    <th>Status</th>
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
.select2-results__options {
    height: 150px;
    overflow-y: auto;
}

[dir=ltr] .select2-container--bootstrap4 .select2-selection--multiple {
    border: 1px solid #D52222 !important;
}

#subjects_table th.title {
    text-align: center;
}

#subjects_table {
    border-collapse: collapse;
}

#subjects_table th,
#subjects_table td {
    padding: 5px;
}

#subjects_table tbody tr {
    height: 30px;
}
</style>
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/vendor-select2.css') }}" />

@stop
@section('scripts')
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>


<script type="text/javascript">
var table = $('#grade').DataTable({
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
        url: site_url + 'api/grade/list',
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
            data: 'subjects_count'
        }, // Column for subject count
        {
            data: 'language'
        },
        {
            data: 'grade_status'
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


function saveForm(id) {
    var url = site_url + 'api/grade/save';
    var data = {
        '_token': '{{ csrf_token() }}',
        number: $('#number').val(),
        name: $('#name').val(),
        language: $('#language').val(),
        status: $('#status').val(),
        // subjects: $("#subjects").val(),
    };
    if (!(id === undefined)) {
        url = site_url + 'api/grade/update';
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

function closeModal() {
    $('#modal-confirm').removeClass('show');
    $('.modal-backdrop').remove();
}

function loadRecord(id) {
    $.ajax({
        type: "POST",
        url: site_url + 'api/grade/show',
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
            $('#grade_number').text(data.number);
            $('#grade_name').text(data.name);
            $('#grade_status').text(data.grade_status);
            $('#grade_language').text(data.language);
            $('#number').val(data.number);
            $('#name').val(data.name);
            $('#language').val(data.language);
            $('#status').val(data.status);
            var subjects = new Array();
            $.each(data.subjects, function(key, value) {
                subjects.push(value.subject_id.id);
            });
            $('#subjects').val(subjects);
            $("#subjects").trigger('change');
            var subjectsHtml = '';
            $.each(data.subjects, function(key, value) {
                subjectsHtml += '<tr>';
                subjectsHtml += '<td>' + value.subject_id.number + '</td>';
                subjectsHtml += '<td>' + value.subject_id.name + '</td>';
                subjectsHtml += '<td>' + (value.subject_id.status ? 'Active' : 'Inactive') +
                    '</td>';
                subjectsHtml += '</tr>';
            });
            $('#subjects_table tbody').html(subjectsHtml);

            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").html("Update");
            $("#modal-form-title").html("Grade");
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
        url: site_url + 'api/grade/delete',
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
    $("#modal-form-title").html("Grade");
    $("#subjects").val('').trigger('change');
});

$(document).ready(function() {
    $('#subjects').select2();
});
</script>

@stop