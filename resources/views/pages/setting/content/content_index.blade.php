@extends('layouts.master')
@section('title')
<title>Lesson Contents</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Lesson Contents</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Lesson Contents</div>
                    </div>
                    <!-- <a href="{{ route('quiz.start', $chapter_id) }}" style="margin-right: 5px;" class="btn btn-primary" >Quiz</a> -->
                    <a class="btn btn-danger" href="{{route('subject.content_index', $subject_id)}}"
                        style="margin-right: 5px;">Back</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#modal-form">Add New
                        Record</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>
                    

                </div>
                <div class="card-body">
                <table id="content_view" class="display  table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Lesson Content Title</th>
                                            <th>Lesson Content</th>
                                            <th>Lesson Content Type</th>
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
                <h5 class="modal-title" id="modal-form-title">Lesson Content</h5>
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
                                <label class="text-label" for="title">Lesson Content Title:</label>
                                <div class="input-group input-group-merge">
                                    <input id="title" type="text" required=""
                                        class="form-control form-control-prepended" placeholder="Lesson Content Title"
                                        value="{{ old('title') }}">
                                        <input type="hidden" id="chapter_id" name="chapter_id" value="{{$chapter_id}}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="email">Content Type:</label>
                                <div class="input-group input-group-merge">
                                    <select id="type" data-toggle="select" name="Type" class="form-control" required="">
                                        <option value="">select</option>
                                        <option value="video">Video</option>
                                        <option value="audio">Audio</option>
                                        <option value="file">file</option>
                                        <option value="text">Text</option>
                                        <option value="picture">Picture</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-eye-slash"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-3" id="file_field" style="display: none;">
                                    <label class="text-label" for="file">File:</label>
                                    <div class="input-group input-group-merge">
                                        <label for="file" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload File
                                        </label>
                                        <input id="file" name="file" class="file_input visually-hidden" type="file">
                                            <div class="file_status"></div>
                                    </div>
                            </div>
                            <div class="col-12 col-md-12 mb-3" id="text_field" style="display: none;">
                                <label for="type">text</label>
                                <textarea class="form-control" id="text" name="text" value="{{ old('text') }}"
                                    required="" width="400px"></textarea>
                            </div>
                            <div class="col-12 col-md-12 mb-3" id="video_field" style="display: none;">
                                <label for="type">Video</label>
                                <input type="text" class="form-control" id="video" name="video"
                                    value="{{ old('video') }}" required="">
                            </div>

                            <div class="col-12 col-md-12 mb-3" id="audio_field" style="display: none;">
                                    <label class="text-label" for="file">File:</label>
                                    <div class="input-group input-group-merge">
                                        <label for="audio_file" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload File
                                        </label>
                                        <input id="audio_file" name="audio_file" class="file_input visually-hidden" type="file">
                                            <div class="file_status"></div>
                                    </div>
                            </div>
                            
                            <div class="col-12 col-md-12 mb-3" id="picture_field" style="display: none;">
                                    <label class="text-label" for="file">File:</label>
                                    <div class="input-group input-group-merge">
                                        <label for="picture_file" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload File
                                        </label>
                                        <input id="picture_file" name="picture_file" class="file_input visually-hidden" type="file">
                                            <div class="file_status"></div>
                                    </div>
                            </div> 
                        </div>
                    </div>
                </form>
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveButton" id="saveBTN" onclick="saveForm()">Save</button>
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
                <h5 class="modal-title" id="modal-form-title">Lesson Content</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="me-1">Lesson Content Title:</div>
                    <div id = "chapter_content_title" class="text-muted"></div>
                </div>
                 
                <div class="col-md-6" id="file_view" style="display: none;">
                        <div class="me-1">Lesson Content:</div>
                        <a id="fileId" href="#"> <i class="material-icons" ; style="color:primary"><img
                                    src="{{asset('assets/images/icons/pdf.png')}}" width="30" height="30" alt="avatar">
                            </i></a>
                    </div>
                    <div class="col-md-6" id="video_view" style="display: none;">
                        <div class="me-1">Lesson Content:</div>
                        <a id="fileId" href="#"> <i class="material-icons" ; style="color:primary"><img
                                    src="{{asset('assets/images/icons/video.svg')}}" width="30" height="30" alt="avatar">
                            </i></a>
                    </div>
                    <div class="col-md-6" id="text_view" style="display: none;">
                        <div class="me-1">Lesson Content:</div>
                        <div id="chapter_content" class="text-muted"></div>
                    </div>
                    <div class="col-md-6" id="audio_view" style="display: none;">
                        <div class="me-1">Lesson Content:</div>
                        <a id="fileId" href="#"> <i class="material-icons" ; style="color:primary">Download Audio
                            </i></a>
                    </div>

            </div>
            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <div class="me-1">Type:</div>
                    <div id = "chapter_content_type" class="text-muted"></div>
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
<style>
    .file_uploads {
            cursor: pointer;
            display: inline-block;
            padding: 10px 20px;
            /* background-color: #007bff; */
            /* color: #fff; */
            /* border-radius: 4px; */
        }

        .file_uploads i {
            margin-right: 5px;
        }

        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
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
            $('#audio_field').hide();
            $('#text_field').hide();
            $('#file_field').hide();
            $('#picture_field').hide();
        } else if (this.value == 'audio') {
            $('#audio_field').show();
            $('#text_field').hide();
            $('#file_field').hide();
            $('#video_field').hide();
            $('#picture_field').hide();
        } 
        else if (this.value == 'text') {
            $('#text_field').show();
            $('#audio_field').hide();
            $('#file_field').hide();
            $('#video_field').hide();
            $('#picture_field').hide();
        } else if (this.value == 'picture') {
            $('#picture_field').show();
            $('#text_field').hide();
            $('#audio_field').hide();
            $('#file_field').hide();
            $('#video_field').hide();
        } else {
            $('#file_field').show();
            $('#audio_field').hide();
            $('#text_field').hide();
            $('#video_field').hide();
            $('#picture_field').hide();
        }
    });

});



function saveForm(id) {
    var url = site_url + 'api/content/save';
    var formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    var str = $('#title').val();
   var charactersToReplace = ['ټ', 'ځ', '-'];
    var replacements = ['t', 'j', '.'];
    var newStr = str;

    for (var i = 0; i < charactersToReplace.length; i++) {
    var character = charactersToReplace[i];
    var replacement = replacements[i];
    var index = newStr.indexOf(character);

    while (index !== -1) {
        newStr = newStr.replace(character, replacement);
        index = newStr.indexOf(character, index + 1);
    }
    }
formData.append('title', newStr);
    formData.append('type', $('#type').val());
    formData.append('chapter_id', $('#chapter_id').val());
    if ($('#type').val() == 'video') {
        formData.append('body', $('#video').val());
    } else if ($('#type').val() == 'audio') {
        formData.append('audio_file', $('#audio_file')[0].files[0]);
    } else if ($('#type').val() == 'picture') {
        formData.append('picture_file', $('#picture_file')[0].files[0]);
    } else if ($('#type').val() == 'text') {
        formData.append('body', tinyMCE.activeEditor.getContent());
    } else {
        formData.append('file', $('#file')[0].files[0]);
    }
    if (!(id === undefined)) {
        url = site_url + 'api/content/update';
        formData.append('id',id);
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



function closeModal(){
    $('#modal-confirm').removeClass('show');
    $('.modal-backdrop').remove();
}

function loadRecord(id) {
    $.ajax({
        type: "POST",
        url: site_url + 'api/content/content-show',
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
            $('#chapter_content_number').text(data.number);
            $('#chapter_content').html(data.chapter_content);
            $('#chapter_content_title').text(data.title);
            $("#fileId").attr("href", site_url + data.chapter_content);
            $('#chapter_content_type').text(data.type);
            $('#title').val(data.title);
            tinymce.get('text').setContent(data.chapter_content);
            $('#type').val(data.type);

            if (data.type == 'video') {
                $('#video_view').show();
                $('#audio_view').hide();
                $('#text_view').hide();
                $('#file_view').hide();
                $('#picture_view').hide();

                // Show the video field and set the value
                $('#video_field').show();
                $('#video').val(data.chapter_content);

                // Hide other fields
                $('#audio_field').hide();
                $('#text_field').hide();
                $('#file_field').hide();
                $('#picture_field').hide();
            } else if (data.type == 'audio') {
                $('#audio_view').show();
                $('#video_view').hide();
                $('#text_view').hide();
                $('#file_view').hide();
                $('#picture_view').hide();

                // Show the audio field and set the value
                $('#audio_field').show();
                $('#audio_file').val('');

                // Hide other fields
                $('#video_field').hide();
                $('#text_field').hide();
                $('#file_field').hide();
                $('#picture_field').hide();
                $('.file_status').text(data.chapter_content);
                if (data.chapter_content == '') {
                            $("#audio_file").hide();
                        } else {
                            $("#audio_file").show();
                            $("#audio_file").attr('href', site_url + data.chapter_content);
                            $("#audio_file").find('img').attr('src', site_url + data.chapter_content);
                        }

            } else if (data.type == 'picture') {
                $('#picture_view').show();
                $('#audio_view').hide();
                $('#video_view').hide();
                $('#text_view').hide();
                $('#file_view').hide();

                // Show the picture field
                $('#picture_field').show();

                // Hide other fields
                $('#audio_field').hide();
                $('#video_field').hide();
                $('#text_field').hide();
                $('#file_field').hide();
                $('.file_status').text(data.chapter_content);
                if (data.chapter_content == '') {
                            $("#picture_file").hide();
                        } else {
                            $("#picture_file").show();
                            $("#picture_file").attr('href', site_url + data.chapter_content);
                            $("#picture_file").find('img').attr('src', site_url + data.chapter_content);
                        }
            } else if (data.type == 'text') {
                $('#text_view').show();
                $('#video_view').hide();
                $('#audio_view').hide();
                $('#file_view').hide();
                $('#picture_view').hide();

                // Show the text field and set the value
                $('#text_field').show();
                $('#text').val(data.chapter_content);

                // Hide other fields
                $('#audio_field').hide();
                $('#video_field').hide();
                $('#file_field').hide();
                $('#picture_field').hide();
            } else {
                $('#file_view').show();
                $('#video_view').hide();
                $('#audio_view').hide();
                $('#text_view').hide();
                $('#picture_view').hide();

                // Show the file field
                $('#file_field').show();

                // Set the file name
               

                // Hide other fields
                $('#audio_field').hide();
                $('#video_field').hide();
                $('#text_field').hide();
                $('#picture_field').hide();
                $('.file_status').text(data.chapter_content);
                if (data.chapter_content == '') {
                            $("#file").hide();
                        } else {
                            $("#file").show();
                            $("#file").attr('href', site_url + data.chapter_content);
                            $("#file").find('img').attr('src', site_url + data.chapter_content);
                        }
            }
            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").html("Save");
            $("#modal-form-title").html("Content Edit Form");
        }),
        dataType: 'json'
    });
}
var chapterId= {{$chapter_id}};
var table = $('#content_view').DataTable({
    serverSide: true,
    ajax: {
        url: site_url + 'api/content/list',
        type: 'POST',
        data: {
            chapter_id: chapterId,
            '_token': '{{ csrf_token() }}'
        }
    },
    columns: [{
                data: 'title'
            },
            {
                data: 'Contents'
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
    $("#modal-form-title").html("Lesson Content");
});

$(document).ready(function() {
    $('#type').on('change', function(){
    if(this.value == 'file'){
        $('.file_input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            var statusElement = $(this).next('.file_status');
            if (fileName) {
                statusElement.text('File uploaded: ' + fileName);
            } else {
                statusElement.text('No file uploaded');
            }
        });
    }
    if(this.value == 'audio'){
        console.log('Iam in audio');
        $('.file_input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            var statusElement = $(this).next('.file_status');
            if (fileName) {
                statusElement.text('File uploaded: ' + fileName);
            } else {
                statusElement.text('No file uploaded');
            }
        });
    }
    if(this.value == 'picture'){
        console.log('Iam in picture');
        $('.file_input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            var statusElement = $(this).next('.file_status');
            if (fileName) {
                statusElement.text('File uploaded: ' + fileName);
            } else {
                statusElement.text('No file uploaded');
            }
        });
    }
    });
});

</script>

@stop