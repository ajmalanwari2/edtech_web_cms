@extends('layouts.master')
@section('title')
    <title>Course Contents</title>
@endsection
@section('content')
    <div class="page__heading">
        <div class="container-fluid page__container">
            <h1 class="mb-0">Course Contents</h1>
        </div>
    </div>
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-large bg-light d-flex align-items-center">
                        <div class="flex">
                            <div class="card-subtitle text-muted">List of Course Contents</div>
                        </div>
                        <a class="btn btn-danger" href="{{ route('dashboard.index') }}" style="margin-right: 5px;">Back</a>
                        <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                            style="margin-left: 5px;">Reload</button>


                    </div>
                    <div class="card-body">
                        <table id="content_view" class="display  table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Course Content Title</th>
                                    <th>Course Content</th>
                                    <th>Course Content Type</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('modals')
  
    <!-- VIEW FORM START-->
    <div id="modal-view" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-title">Course Content View Form </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="me-1">Course Content Title:</div>
                            <div id="course_content_title" class="text-muted"></div>
                        </div>

                        <div class="col-md-6" id="file_view" style="display: none;">
                            <div class="me-1">Course Content:</div>
                            <a id="fileId" href="#"> <i class="material-icons" ; style="color:primary"><img
                                        src="{{ asset('assets/images/icons/pdf.png') }}" width="30" height="30"
                                        alt="avatar">
                                </i></a>
                        </div>
                        <div class="col-md-6" id="video_view" style="display: none;">
                            <div class="me-1">Course Content:</div>
                            <a id="fileId" href="#"> <i class="material-icons" ; style="color:primary"><img
                                        src="{{ asset('assets/images/icons/video.svg') }}" width="30" height="30"
                                        alt="avatar">
                                </i></a>
                        </div>
                        <div class="col-md-6" id="text_view" style="display: none;">
                            <div class="me-1">Course Content:</div>
                            <div id="course_content" class="text-muted"></div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <div class="me-1">Type:</div>
                            <div id="course_content_type" class="text-muted"></div>
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

  


    


    function closeModal() {
        $('#modal-confirm').removeClass('show');
        $('.modal-backdrop').remove();
    }

    function loadRecord(id) {
        $.ajax({
            type: "POST",
            url: site_url + 'api/course_content/course-content-show',
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
                $('#course_content_number').text(data.number);
                $('#course_content').html(data.course_content);
                $('#course_content_title').text(data.title);
                $("#fileId").attr("href", site_url + data.course_content);
                $('#course_content_type').text(data.type);
                $('#title').val(data.title);
                $('#video').val(data.course_content);
                $('#text').val(data.course_content);
                $('#type').val(data.type);
                if (data.type == 'video') {
            $('#video_view').show();
            $('#audio_view').hide();
            $('#text_view').hide();
            $('#file_view').hide();
            $('#video_field').show();
            $('#audio_field').hide();
            $('#text_field').hide();
            $('#file_field').hide();
            $('#picture_view').hide();
            $('#picture_field').hide();
        } else if (data.type == 'audio') {
            $('#audio_view').show();
            $('#video_view').hide();
            $('#text_view').hide();
            $('#file_view').hide();
            $('#audio_field').show();
            $('#video_field').hide();
            $('#text_field').hide();
            $('#file_field').hide();
            $('#picture_view').hide();
            $('#picture_field').hide();
        } else if (data.type == 'picture') {
            $('#picture_view').show();
            $('#picture_field').show();
            $('#audio_view').hide();
            $('#video_view').hide();
            $('#text_view').hide();
            $('#file_view').hide();
            $('#audio_field').show();
            $('#video_field').hide();
            $('#text_field').hide();
            $('#file_field').hide();
        } else if (data.type == 'text') {
            $('#video_view').hide();
            $('#text_view').show();
            $('#audio_view').hide();
            $('#file_view').hide();
            $('#text_field').show();
            $('#file_field').hide();
            $('#video_field').hide();
            $('#audio_field').hide();
            $('#picture_field').hide();
            $('#picture_view').hide();
        } else {
            $('#video_view').hide();
            $('#audio_view').hide();
            $('#text_view').hide();
            $('#file_view').show();
            $('#file_field').show();
            $('#text_field').hide();
            $('#video_field').hide();
            $('#audio_field').hide();
            $('#picture_field').hide();
            $('#picture_view').hide();
        }
                $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
                $("#saveBTN").html("Save");
                $("#modal-form-title").html("Content Add Form");

            }),
            dataType: 'json'
        });
    }

    var courseId = {{ $course_id }};
    var table = $('#content_view').DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: ['pageLength', {
            extend: 'excelHtml5',

            exportOptions: {
                columns: [0, 1, 2]
            }
        }, ],
    serverSide: true,
        ajax: {
            
            url: site_url + 'api/dashboard/course-list',
            type: 'POST',
            data: {
                course_id: courseId,
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
            url: site_url + 'api/course_content/delete',
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
    });
</script>

@stop
