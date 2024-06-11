@extends('layouts.master')
@section('title')
<title>News</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">News</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of News</div>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                        Record</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="rmo" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="display:none">Updated at</th>
                                <th>Number</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Is Emailed</th>
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
                <h5 class="modal-title" id="modal-form-title">News</h5>
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
                                <label class="text-label" for="title">Title:</label>
                                <div class="input-group input-group-merge">
                                    <input id="title" type="text" required=""
                                        class="form-control form-control-prepended" placeholder="Title"
                                        value="{{ old('title') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-igloo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="description">Description:</label>
                                <div class="input-group input-group-merge">
                                    <input id="description" type="text" required=""
                                        class="form-control form-control-prepended" placeholder="Description"
                                        value="{{ old('description') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="email">Is Emailed:</label>
                                <div class="input-group input-group-merge">
                                    <select id="is_emailed" data-toggle="select" name="is_emailed" class="form-control"
                                        required="">
                                        <option value="">Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
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
                            <div class="col-12 col-md-6 mb-3" id="file_field">
                                    <label class="text-label" for="photo">Icon:</label>
                                    <div class="input-group input-group-merge">
                                        <label for="photo" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload Icon
                                        </label>
                                        <input id="photo" name="photo" class="file_input visually-hidden" type="file">
                                            <div class="file_status"></div>
                                    </div>
                            </div>
                        </div>
                        <div class="form-row">
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
                <h5 class="modal-title" id="modal-form-title">Notices</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row g-3 ">
                    <div class="col-md-6">
                        <div class="me-1">Number:</div>
                        <div id="news_number" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Title:</div>
                        <div id="news_title" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Description:</div>
                        <div id="news_description" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Status:</div>
                        <div id="news_status" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Is Emailed:</div>
                        <div id="news_is_emailed" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Language:</div>
                        <div id="news_language" class="text-muted"></div>
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
var table = $('#rmo').DataTable({
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
        url: site_url + 'api/news/list',
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
            data: 'title'
        },
        {
            data: 'description'
        },
        {
            data: 'is_emailed'
        },
        {
            data: 'language'
        },
        {
            data: 'status_name'
        },
        {
            data: 'actions'
        }
    ],
    processing: true,
    order: [
        [0, 'desc']
    ] // Apply descending order to the first column
});



function saveForm(id) {
    var url = site_url + 'api/news/save';
    var data = new FormData(); // Create a new FormData object
    // Append form data
    data.append('_token', '{{ csrf_token() }}');
    data.append('number', $('#number').val());
    data.append('title', $('#title').val());
    data.append('description', $('#description').val());
    data.append('status', $('#status').val());
    data.append('is_emailed', $('#is_emailed').val());
    data.append('language', $('#language').val());
    data.append('photo', $('#photo')[0].files[0]);
    if (!(id === undefined)) {
        url = site_url + 'api/news/update';
        data.append('id', id);
    }
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        processData: false, // Ensure that jQuery does not process the data
        contentType: false, // Set the contentType to false so that
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
        url: site_url + 'api/news/show',
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
            $('#news_number').text(data.number);
            $('#news_title').text(data.title);
            $('#news_status').text(data.news_status);
            $('#news_description').text(data.description);
            $('#news_is_emailed').text(data.is_emailed);
            $('#news_language').text(data.language);
            $('#number').val(data.number);
            $('#status').val(data.status);
            $('#is_emailed').val(data.is_emailed);
            $('#language').val(data.language);
            $('#title').val(data.title);
            $('#description').val(data.description);
            $('.file_status').text(data.photo);
                if (data.photo == '') {
                            $("#photo").hide();
                        } else {
                            $("#photo").show();
                            $("#photo").attr('href', site_url + data.photo);
                            $("#photo").find('img').attr('src', site_url + data.photo);
                        }
            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").html("Update");
            $("#modal-form-title").html("News");
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
        url: site_url + 'api/news/delete',
        data: {
            id: deleteRecordID,
            '_token': '{{ csrf_token() }}'
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
    $("#modal-form-title").html("Notice");
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