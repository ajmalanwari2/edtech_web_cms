@extends('layouts.master')
@section('title')
<title>Contents</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Contents</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Contents</div>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                        Record</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="content" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>School Name</th>
                                <th>Grade Name</th>
                                <th>Subject Name</th>
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
                <h5 class="modal-title" id="modal-form-title">content Form </h5>
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
                                    <input type="hidden" id="school_id" name="school_id">
                                    <input type="hidden" id="grade_id" name="grade_id">
                                    <input type="hidden" id="subject_id" name="subject_id">
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
                                    <select id="type" data-toggle="select" name="Type" class="form-control" required="">
                                        <option value="">select</option>
                                        <option value="video">Video</option>
                                        <option value="file">file</option>
                                        <option value="text">Text</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-eye-slash"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-3" id="file_field" style="display: none;">
                                <label for="type">File</label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                            <div class="col-12 col-md-12 mb-3" id="text_field" style="display: none;">
                                <label for="type">text</label>
                                <textarea class="form-control" id="text" name="text" value="{{ old('text') }}"
                                    required="" width="400px"></textarea>
                                <!-- <input type="text" class="form-control" id="text" name="text" value="{{ old('text') }}" required=""> -->
                            </div>
                            <div class="col-12 col-md-12 mb-3" id="video_field" style="display: none;">
                                <label for="type">Video</label>
                                <input type="text" class="form-control" id="video" name="video"
                                    value="{{ old('video') }}" required="">
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
                <h5 class="modal-title" id="modal-form-title">Contents View Form </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="content_view" class="display  table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Body</th>
                                            <th>Type</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
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
var table = $('#content').DataTable({
    serverSide: true,
    ajax: {
        url: site_url + 'api/content/list',
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}'
        }
    },
    columns: [{
            data: 'school_name'
        },
        {
            data: 'grade_name'
        },
        {
            data: 'subject_name'
        },
        {
            data: 'actions'
        }
    ],
    processing: true,
    serverSide: true
});

function setHiddenIDs(school_id, grade_id, subject_id) {
    $('#school_id').val(school_id);
    $('#grade_id').val(grade_id);
    $('#subject_id').val(subject_id);
}

function saveForm(id) {
    var url = site_url + 'api/content/save';
    var formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('title', $('#title').val());
    formData.append('type', $('#type').val());
    formData.append('school_id', $('#school_id').val());
    formData.append('grade_id', $('#grade_id').val());
    formData.append('subject_id', $('#subject_id').val());


    // var data = {
    //     '_token': '{{ csrf_token() }}',
    //     title: $('#title').val(),
    //     type: $('#type').val(),
    //     school_id: $('#school_id').val(),
    //     grade_id: $('#grade_id').val(),
    //     subject_id: $('#subject_id').val(),
    // };
    // data['ss'] = $("#type").val();
    if ($('#type').val() == 'video') {
        formData.append('body', $('#video').val());
        // data['body']= $("#video").val();
    } else if ($('#type').val() == 'text') {
        // data['body']= $("#text").val();
        formData.append('body', tinyMCE.activeEditor.getContent());
    } else {
        // data['body']= $("#file").val();
        formData.append('file', $('#file')[0].files[0]);
    }


    // if (!(id === undefined)) {
    //     url = site_url + 'api/content/update';
    //     data.id = id;
    // }
    console.log($.trim($("#message").val()));
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
        }),
        dataType: 'json'
    });
}
var table2 = $('#content_view').DataTable({});

function loadRecord(school_id, grade_id, subject_id) {


    var table2 = $('#content_view').DataTable({
        serverSide: true,
        ajax: {
            url: site_url + 'api/content/show',
            type: 'POST',
            data: {
                school_id: school_id,
                grade_id: grade_id,
                subject_id: subject_id,
                '_token': '{{ csrf_token() }}'
            }
        },
        columns: [{
                data: 'title'
            },
            {
                data: 'body'
            },
            {
                data: 'type'
            },
            {
                data: 'actions'
            }
        ],
        processing: true,
        serverSide: true
    });
    table2.ajax.reload()
}

function loadRecord(school_id, grade_id, subject_id) {
    $.ajax({
        type: "POST",
        url: site_url + 'api/content/show',
        data: {
            school_id: school_id,
            grade_id: grade_id,
            subject_id: subject_id,
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
            $('#content_name').text(data.name);
            $('#content_name').text(data.content_name);
            $('#content_status').text(data.content_status);
            $('#content_created_at').text(data.content_created_at);
            $('#content_updated_at').text(data.content_updated_at);
            $('#name').val(data.name);
            $('#content_id').val(data.content_id);
            $('#status').val(data.status);
            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").html("Update");
            $("#modal-form-title").html("content Update Form");

        }),
        dataType: 'json'
    });
}

function download(filename) {
    alert('Iam here');
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
var deleteRecordID = 0;

function deleteRecord() {

    if (deleteRecordID == 0)
        return;

    $.ajax({
        type: "POST",
        url: site_url + 'api/content/delete',
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
    $("#modal-form-title").html("contents Add Form");

    $('#school_id').val('');
    $('#grade_id').val('');
    $('#subject_id').val('');
});
</script>

@stop