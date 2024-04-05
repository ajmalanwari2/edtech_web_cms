@extends('layouts.master')
@section('title')
    <title>Library Document Content</title>
@endsection
@section('content')
    <div class="page__heading">
        <div class="container-fluid page__container">
            <h1 class="mb-0">Library Document Content</h1>
        </div>
    </div>
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-large bg-light d-flex align-items-center">
                        <div class="flex">
                            <div class="card-subtitle text-muted">List of Library Document Contents</div>
                        </div>
                        <a class="btn btn-danger" href="{{ route('library_document.index') }}" style="margin-right: 5px;">Back</a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                            Record</button>
                        <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                            style="margin-left: 5px;">Reload</button>


                    </div>
                    <div class="card-body">
                        <table id="content_view" class="display  table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                <th style="display:none">Updated at</th>
                                    <th>Library Document Content Title</th>
                                    <th>Library Document Content</th>
                                    <th>Library Document Is main</th>
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
                    <h5 class="modal-title" id="modal-form-title">Library Document Content</h5>
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
                                    <label class="text-label" for="title">Title:</label>
                                    <div class="input-group input-group-merge">
                                        <input id="title" type="text" required=""
                                            class="form-control form-control-prepended" placeholder="Title"
                                            value="{{ old('title') }}">
                                        <input type="hidden" id="library_document_id" name="library_document_id" value="{{ $library_document_id }}">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-home"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3" id="file_field">
                                    <label for="type">File</label>
                                    <input type="file" class="form-control" id="file" name="file">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="email">Is main:</label>
                                <div class="input-group input-group-merge">
                                    <select id="is_main" data-toggle="select" name="is_main" class="form-control"
                                        required="">
                                        <option value="">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
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
                    <button type="button" class="btn btn-primary saveButton" id="saveBTN" onclick="saveForm()">
                        <span class="button__text">Save</span></button>
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
                    <h5 class="modal-title" id="modal-form-title">Library Document Content</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="me-1">Library Document Content Title:</div>
                            <div id="library_document_content_title" class="text-muted"></div>
                        </div>
                        <div class="col-md-6" id="file_view" style="display: none;">
                            <div class="me-1">Library Document Content:</div>
                            <a id="fileId" href="#"> <i class="material-icons" ; style="color:primary"><img
                                        src="{{ asset('assets/images/icons/pdf.png') }}" width="30" height="30"
                                        alt="avatar">
                                </i></a>
                        </div>
                        <div class="col-md-6">
                        <div class="me-1">Library Document Content Is main:</div>
                        <div id="library_document_content_is_main" class="text-muted"></div>
                    </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <div class="me-1">Type:</div>
                            <div id="library_document_content_type" class="text-muted"></div>
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
                    <button type="button" class="btn btn-light" data-dsmiss="modal" i>No</button>
                    <button type="button" class="btn btn-warning my-2" onclick="deleteRecord()">Yes</button>
                </div> <!-- // END .modal-body -->
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div> <!-- // END .modal -->

@endsection

@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}" />
@stop
@section('scripts')
<script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>


<script type="text/javascript">
    tinymce.init({
        selector: 'textarea'
    });

    function saveForm(id) {
        var url = site_url + 'api/library_document_content/save';
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('title', $('#title').val());
        formData.append('is_main', $('#is_main').val());
        formData.append('library_document_id', $('#library_document_id').val());
        formData.append('file', $('#file')[0].files[0]);
      
        if (!(id === undefined)) {
            url = site_url + 'api/library_document_content/update';
            formData.append('id', id);
        }
        const btn = document.querySelector(".saveButton");
        $.ajax({
            type: "POST",
            url: url,
            processData: false,
            contentType: false,
            data: formData,
            error: function(xhr, textStatus, errorThrown) {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: xhr.responseJSON.message
            });
        },
        beforeSend: (function() {
                        $("#saveBTN").prop('disabled', true);
                        btn.classList.add("button--loading");
                    }),
                    complete: (function() {
                        btn.classList.remove("button--loading");
                        $("#saveBTN").prop('disabled', false);
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



    function closeModal() {
        $('#modal-confirm').removeClass('show');
        $('.modal-backdrop').remove();
    }

    function loadRecord(id) {
        $.ajax({
            type: "POST",
            url: site_url + 'api/library_document_content/library-document-content-show',
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
                $('#library_document_content').html(data.body);
                $('#library_document_content_title').text(data.title);
                $('#library_document_content_is_main').text(data.library_document_content_is_main);
                $('#title').val(data.title);
                $('#title').val(data.is_main);
                $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
                $("#saveBTN").html("Save");
                $("#modal-form-title").html("Library Document Content");

            }),
            dataType: 'json'
        });
    }

    var libraryDocumentId = {{ $library_document_id }};
    var table = $('#content_view').DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: ['pageLength', {
            extend: 'excelHtml5',

            exportOptions: {
                columns: [1, 2]
            }
        }, ],
    serverSide: true,
        ajax: {
            
            url: site_url + 'api/library_document_content/list',
            type: 'POST',
            data: {
                library_document_id: libraryDocumentId,
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
                data: 'title'
            },
            {
                data: 'Contents'
            },
            {
                data: 'library_content_is_main'
            },
            {
                data: 'actions'
            }
        ],
        processing: true,
        serverSide: true
    });

    var deleteRecordID = 0;

    function deleteRecord() {

        if (deleteRecordID == 0)
            return;

        $.ajax({
            type: "POST",
            url: site_url + 'api/library_document_content/delete',
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
        $("#modal-form-title").html("Library Document Content");
    });
</script>

@stop
