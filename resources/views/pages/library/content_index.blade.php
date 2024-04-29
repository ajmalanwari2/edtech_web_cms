@extends('layouts.master')
@section('title')
<title>Kit Contents</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Kit Contents</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Kit Contents</div>
                    </div>
                    <a class="btn btn-danger" href="{{route('library_document.index')}}" style="margin-right: 5px;">Back</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                        Record</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>


                </div>
                <div class="card-body">
                    <table id="content_view" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kit Content Title</th>
                                <th>Kit Description</th>
                                <th>Kit Content</th>
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
                <h5 class="modal-title" id="modal-form-title">Kit Content Form </h5>
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
                                        <input type="hidden" id="kit_id" name="kit_id" value="{{$kit_id}}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <span class="fas fa-list-ol"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="type">text</label>
                                <textarea class="form-control" id="description" name="description" value="{{ old('description') }}"
                                    required="" width="400px"></textarea>
                                <!-- <input type="text" class="form-control" id="text" name="text" value="{{ old('text') }}" required=""> -->
                            </div>
                            </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                            <label for="type">Upload File</label>
                                <input type="file" class="form-control" id="file" name="file">
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
                <h5 class="modal-title" id="modal-form-title">IQRA Kit View Form </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="me-1">Content Title:</div>
                        <div id="kit_content_title" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Description:</div>
                        <div id="kit_description" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Kit Content:</div>
                        <a id="fileId" href="#"> <i class="material-icons"; style="color:primary"><img src="{{asset('assets/images/icons/file.png')}}" width="30" height="30" alt="avatar"></i></a>
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
<link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}" />

@stop
@section('scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>


<script type="text/javascript">
// tinymce.init({
//     selector: 'textarea'
// });

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



function saveForm(id) {
    var url = site_url + 'api/kit_content/save';
    var formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('title', $('#title').val());
    formData.append('description', $('#description').val());
    formData.append('kit_id', $('#kit_id').val());
    formData.append('file', $('#file')[0].files[0]);
    if (!(id === undefined)) {
        url = site_url + 'api/kit_content/update';
        formData.append('id', id);
    }
    $.ajax({
        type: "POST",
        url: url,
        processData: false,
        contentType: false,
        data: formData,
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
        url: site_url + 'api/kit_content/kit-content-show',
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
            $('#kit_description').text(data.description);
            $('#kit_content_title').text(data.title);
            $("#fileId").attr("href", site_url + data.kit_Content);
            $('#kit_content_type').text(data.type);
            $('#title').val(data.title);
            $('#description').val(data.description);
            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").html("Save");
            $("#modal-form-title").html("Kir Content Add Form");

        }),
        dataType: 'json'
    });
}

var kitId = {{$kit_id}};
var table = $('#content_view').DataTable({
    serverSide: true,
    ajax: {
        url: site_url + 'api/kit_content/list',
        type: 'POST',
        data: {
            kit_id: kitId,
            '_token': '{{ csrf_token() }}'
        }
    },
    columns: [{
            data: 'title'
        },
        {
            data: 'description'
        },
        {
            data: 'Contents'
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
        url: site_url + 'api/kit_content/delete',
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
    $("#modal-form-title").html("contents Add Form");
});
</script>

@stop