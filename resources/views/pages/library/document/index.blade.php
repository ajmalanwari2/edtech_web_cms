@extends('layouts.master')
@section('title')
<title>Library Document</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Library Documents</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Library Documents</div>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                        Record</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="library_document" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                            <th style="display:none">Updated at</th>
                                <th>Number</th>
                                <th>Subject Name</th>
                                <th>Description</th>
                                <th>Number of Contents</th>
                                <th>Status</th>
                                <th>Language</th>
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
                <h5 class="modal-title" id="modal-form-title">Library Document</h5>
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
                                <label class="text-label" for="email">Subject Name:</label>
                                <div class="input-group input-group-merge">
                                    <select id="subject_id" data-toggle="select"
                                        name="subject_id" class="form-control" required="">
                                        <option value="">select</option>
                                        @foreach($subjects as $subject)
                                        <option
                                            {{old('subject_id') == $subject->id ? 'selected' : ''}}
                                            value="{{$subject->id}}">
                                            {{$subject->number }}-{{$subject->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-igloo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="description">Description:</label>
                                <div class="input-group input-group-merge">
                                    <input id="description" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="Description" value="{{ old('description') }}">
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
                <h5 class="modal-title" id="modal-form-title">Library Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="me-1">Number:</div>
                        <div id="library_document_number" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Subject Name:</div>
                        <div id="library_document__subject_name" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                <div class="col-md-6">
                        <div class="me-1">Description:</div>
                        <div id="library_document_description" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Library Document Status:</div>
                        <div id="library_document_status" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                <div class="col-md-6">
                        <div class="me-1">Language:</div>
                        <div id="library_document_language" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="contentTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="3" class="title">Library Document Contents</th>
                                </tr>
                                <tr>
                                    <th>Title</th>
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
var table = $('#library_document').DataTable({
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
        url: site_url + 'api/library_document/list',
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}'
        }
    },
    columns: [
        {
            data: null,
            visible: false,
            orderable: true,
            render: function (data, type, row) {
                return data.updated_at;
            }
        },
        {
            data: 'number'
        },
        {
            data: 'subject_name'
        },
        {
            data: 'description'
        },
        {
            data: 'libraryDocumentContent_count'
        },
        {
            data: 'library_document_status'
        },
        {
            data: 'language'
        },
        {
            data: 'actions'
        }
    ],
    processing: true,
    serverSide: true
});


function saveForm(id) {
    var url = site_url + 'api/library_document/save';
    var data = {
        '_token': '{{ csrf_token() }}',
        number: $('#number').val(),
        subject_id: $('#subject_id').val(),
        description: $('#description').val(),
        status: $('#status').val(),
        language: $('#language').val(),
    };
    if (!(id === undefined)) {
        url = site_url + 'api/library_document/update';
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
        url: site_url + 'api/library_document/show',
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
            $('#library_document_number').text(data.number);
            $('#library_document__subject_name').text(data.subject_name);
            $('#library_document_status').text(data.library_document_status);
            $('#library_document_description').text(data.description);
            $('#library_document_language').text(data.language);
            $('#number').val(data.number);
            $('#subject_id').val(data.subject_id);
            $('#status').val(data.status);
            $('#language').val(data.language);
            $('#description').val(data.description);
            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").html("Update");
            $("#modal-form-title").html("Library Document");

            var contentsHtml = '';
            $.each(data.contents, function(key, value) {
                contentsHtml += '<tr>';
                contentsHtml += '<td>' + value.title + '</td>';
                contentsHtml += '<td><a href="' + value.body + '" target="_blank">Download Content</a></td>'; 
              
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
        url: site_url + 'api/library_document/delete',
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
    $("#modal-form-title").html("Library Document");
});
</script>

@stop