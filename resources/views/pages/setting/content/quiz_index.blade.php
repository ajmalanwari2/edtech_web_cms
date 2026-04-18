@extends('layouts.master')
@section('title')
    <title>Chapter Contents</title>
@endsection
@section('content')
    <div class="page__heading">
        <div class="container-fluid page__container">
            <h1 class="mb-0">Quiz</h1>
        </div>
    </div>
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-large bg-light d-flex align-items-center">
                        <div class="flex">
                            <div class="card-subtitle text-muted">List of Quizes</div>
                        </div>
                        <a class="btn btn-danger" href="{{route('subject.content_index', $subject_id)}}"
                        style="margin-right: 5px;">Back</a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                            Record</button>
                        <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                            style="margin-left: 5px;">Reload</button>


                    </div>
                    <div class="card-body">
                        <table id="content_view" class="display  table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Difficulty Level</th>
                                    <th>Option A</th>
                                    <th>Option B</th>
                                    <th>Option C</th>
                                    <th>Option D</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <!-- ADD/EDIT FORM START-->
    <div id="modal-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-title">Quiz Form </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <form action="#" method="post" enctype="multipart/form-data" id="entry_edit_form">
                        @csrf
                        <div class="was-validated">
                            <div class="form-row">

                                <div class="col-12 col-md-12 mb-12">
                                    <label class="text-label" for="q_text">Write question or upload question in form of
                                        picture:</label>
                                    <div class="input-group input-group-merge">

                                        <textarea class="form-control" id="q_text" name="q_text" value="" required="" width="400px"></textarea>
                                        <br>
                                        {{-- <input type="file" id="q_image" name="q_image"> --}}
                                        <label for="q_image" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload File
                                        </label>
                                        <input id="q_image" name="q_image" class="file_input" type="file" style="display: none;">
                                        <div class="file_status"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-6 col-md-6 mb-6">
                                    <label class="text-label" for="difficulty_level">Choose Difficulty Level:</label>
                                    <div class="input-group input-group-merge">
                                        <select id="difficulty_level" data-toggle="select" name="difficulty_level"
                                            class="form-control" required="">
                                            <option value="">select</option>
                                            <option value="easy">Easy</option>
                                            <option value="medium">Medium</option>
                                            <option value="hard">Hard</option>

                                        </select>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fab fa-accessible-icon	"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 mb-6">
                                    <label class="text-label" for="references">Choose Lesson Content Reference</label>
                                    <div class="input-group input-group-merge">
                                        <select id="references" name="references[]" required data-toggle="select" multiple
                                            class="form-control">
                                            @foreach ($references as $reference)
                                                <option {{ old('references') == $reference->id ? 'selected' : '' }}
                                                    value="{{ $reference->id }}">
                                                    {{ $reference->title }} - {{$reference->type}}</option>
                                            @endforeach
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
                                <p>Write options for the question or upload option in form of picture</p>
                            </div>
                            <div class="form-row">


                                <div class="col-12 col-md-12 mb-12">
                                    <label class="text-label" for="option_a_text">Option A:</label>
                                    <div class="input-group input-group-merge">

                                        <textarea class="form-control" id="option_a_text" name="option_a_text" value="{{ old('option_a_text') }}"
                                            required="" width="400px"></textarea>
                                        <br>
                                        {{-- <input type="file" id="option_a_image" name="option_a_image"> --}}
                                        <label for="option_a_image" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload File
                                        </label>
                                        <input id="option_a_image" name="option_a_image" class="file_input" type="file"
                                            style="display: none;">
                                            <div class="file_status"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">


                                <div class="col-12 col-md-12 mb-12">
                                    <label class="text-label" for="option_b_text">Option B:</label>
                                    <div class="input-group input-group-merge">

                                        <textarea class="form-control" id="option_b_text" name="option_b_text" value="{{ old('option_b_text') }}"
                                            required="" width="400px"></textarea>
                                        <br>
                                        {{-- <input type="file" id="option_b_image" name="option_b_image"> --}}
                                        <label for="option_b_image" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload File
                                        </label>
                                        <input id="option_b_image" name="option_b_image" class="file_input" type="file"
                                            style="display: none;">
                                            <div class="file_status"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">


                                <div class="col-12 col-md-12 mb-12">
                                    <label class="text-label" for="option_c_text">Option C:</label>
                                    <div class="input-group input-group-merge">

                                        <textarea class="form-control" id="option_c_text" name="option_c_text" value="{{ old('option_c_text') }}"
                                            required="" width="400px"></textarea>
                                        <br>
                                        {{-- <input type="file" id="option_c_image" name="option_c_image"> --}}
                                        <label for="option_c_image" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload File
                                        </label>
                                        <input id="option_c_image" name="option_c_image" class="file_input" type="file"
                                            style="display: none;">
                                            <div class="file_status"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-12 mb-12">
                                    <label class="text-label" for="option_d_text">Option D:</label>
                                    <div class="input-group input-group-merge">

                                        <textarea class="form-control" id="option_d_text" name="option_d_text" value="{{ old('option_d_text') }}"
                                            required="" width="400px"></textarea>
                                        <br>
                                        {{-- <input type="file" id="option_d_image" name="option_d_image"> --}}
                                        <label for="option_d_image" class="file_uploads">
                                            <i class="fa fa-paperclip"></i> Upload File
                                        </label>
                                        <input id="option_d_image" name="option_d_image" class="file_input" type="file"
                                            style="display: none;">
                                            <div class="file_status"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-12 mb-12">
                                    <label class="text-label" for="answer">Choose Correct Answer from above given
                                        options:</label>
                                    <div class="input-group input-group-merge">
                                        <select id="answer" data-toggle="select" name="answer" class="form-control"
                                            required="">
                                            <option value="">select</option>
                                            <option value="a">A</option>
                                            <option value="b">B</option>
                                            <option value="c">C</option>
                                            <option value="d">D</option>
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
    <div id="modal-view" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-detail-title"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-detail-title">Quiz details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="me-1">Question:</div>
                            <div id ="d_question_text" class="text-muted"></div>
                            <a id="d_question_image" href="#" target="_blank"> <i class="material-icons"
                                    style="color:primary"><img src="{{ asset('assets/images/icons/pdf.png') }}"
                                        width="30" height="30" alt="avatar">
                                </i></a>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="me-1">Option A:</div>
                            <div id ="d_option_a_text" class="text-muted"></div>
                            <a id="d_option_a_image" href="#" target="_blank"> <i class="material-icons"
                                    style="color:primary"><img src="{{ asset('assets/images/icons/pdf.png') }}"
                                        width="30" height="30" alt="avatar">
                                </i></a>
                        </div>
                        <div class="col-md-6">
                            <div class="me-1">Option B:</div>
                            <div id ="d_option_b_text" class="text-muted"></div>
                            <a id="d_option_b_image" href="#" target="_blank"> <i class="material-icons"
                                    style="color:primary"><img src="{{ asset('assets/images/icons/pdf.png') }}"
                                        width="30" height="30" alt="avatar">
                                </i></a>
                        </div>
                        <div class="col-md-6">
                            <div class="me-1">Option C:</div>
                            <div id ="d_option_c_text" class="text-muted"></div>
                            <a id="d_option_c_image" href="#" target="_blank"> <i class="material-icons"
                                    style="color:primary"><img src="{{ asset('assets/images/icons/pdf.png') }}"
                                        width="30" height="30" alt="avatar">
                                </i></a>
                        </div>
                        <div class="col-md-6">
                            <div class="me-1">Option D:</div>
                            <div id ="d_option_d_text" class="text-muted"></div>
                            <a id="d_option_d_image" href="#" target="_blank"> <i class="material-icons"
                                    style="color:primary"><img src="{{ asset('assets/images/icons/pdf.png') }}"
                                        width="30" height="30" alt="avatar">
                                </i></a>
                        </div>
                        <div class="col-md-6">
                            <div class="me-1">Correct Answer</div>
                            <div id ="d_correct_answer" class="text-muted"></div>

                        </div>
                        <div class="col-md-6">
                            <div class="me-1">Difficulty level</div>
                            <div id ="d_difficulty_level" class="text-muted"></div>

                        </div>
                        <div class="col-md-6">
                            <div class="me-1">Lesson references</div>
                            <div id ="d_lesson_references" class="text-muted"></div>

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



@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/vendor-select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}" />
    <style>
        [dir=ltr] .select2-container--bootstrap4 .select2-selection--multiple {
            border: 1px solid #D52222 !important;
        }

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
    </style>


@stop
@section('scripts')
    {{-- <script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#references').select2();
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

        function saveForm(id) {
            try {
                var url = site_url + 'api/quiz/save';
                var formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                      var str = $('#q_text').val();
 var charactersToReplace = ['ټ', 'ځ', 'ا'];
   var replacements = ['t', 'j', 'a'];
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



                // formData.append('q_text', $('#q_text').val());
                formData.append('q_text', newStr);
                formData.append('q_image', $('#q_image')[0].files[0]);

                formData.append('option_a_text', $('#option_a_text').val());
                formData.append('option_a_image', $('#option_a_image')[0].files[0]);
                formData.append('option_b_text', $('#option_b_text').val());
                formData.append('option_b_image', $('#option_b_image')[0].files[0]);
                formData.append('option_c_text', $('#option_c_text').val());
                formData.append('option_c_image', $('#option_c_image')[0].files[0]);
                formData.append('option_d_text', $('#option_d_text').val());
                formData.append('option_d_image', $('#option_d_image')[0].files[0]);

                formData.append('answer', $('#answer').val());
                formData.append('difficulty_level', $('#difficulty_level').val());

                formData.append('chapter_id', chapterId);
                formData.append('references', $("#references").val());



                if (!(id === undefined)) {
                    url = site_url + 'api/quiz/update';
                    formData.append('id', id);
                }

                const btn = document.querySelector(".saveButton");
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
            } catch (e) {
                console.log('error: ' + e);
            }
        }



        function closeModal() {
            $('#modal-confirm').removeClass('show');
            $('.modal-backdrop').remove();
        }

        function loadRecord(type, id) {

            $.ajax({
                type: "POST",
                url: site_url + 'api/quiz/show',
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
                    data = data[0];
                    // quiz = data.quiz[0];
                    if (type == 'edit') {
                        $('#q_text').text(data.quiz.question_text);
                        $('#option_a_text').text(data.quiz.option_a_text);
                        $('#option_b_text').text(data.quiz.option_b_text);
                        $('#option_c_text').text(data.quiz.option_c_text);
                        $('#option_d_text').text(data.quiz.option_d_text);
                        $('#difficulty_level').val(data.quiz.difficulty_level);
                        // alert(data.correct_answer);
                        $('#answer').val(data.quiz.correct_answer);

                        if (data.lesson_reference != null) {
                            var lesson_reference = new Array();
                            $.each(data.lesson_reference, function(key, value) {
                                lesson_reference.push(value['id']);
                            });
                            $('#references').val(lesson_reference);
                            $("#references").trigger('change');
                        }

                        $("#saveBTN").attr("onclick", "saveForm(" + data.quiz.id + ")");
                        $("#saveBTN").html("Save");
                        $("#modal-form-title").html("Content Add Form");
                    } else {
                        $("#d_question_text").text(data.quiz.question_text);
                        if (data.quiz.question_image == '') {
                            $("#d_question_image").hide();
                        } else {
                            $("#d_question_image").show();
                            $("#fileId").attr("href", site_url + data.course_content);

                            $("#d_question_image").attr('href', site_url + 'storage/uploads/q_image/' + data
                                .quiz.question_image);
                            $("#d_question_image").find('img').attr('src', site_url +
                                'storage/uploads/q_image/' + data.quiz.question_image);
                        }

                        $("#d_option_a_text").text(data.quiz.option_a_text);
                        if (data.quiz.option_a_image == '') {
                            $("#d_option_a_image").hide();
                        } else {
                            $("#d_option_a_image").show();
                            $("#d_option_a_image").attr('href', site_url +
                                'storage/uploads/option_a_image/' + data.quiz.option_a_image);
                            $("#d_option_a_image").find('img').attr('src', site_url +
                                'storage/uploads/option_a_image/' + data.quiz.option_a_image);
                        }

                        $("#d_option_b_text").text(data.quiz.option_b_text);
                        if (data.quiz.option_b_image == '') {
                            $("#d_option_b_image").hide();
                        } else {
                            $("#d_option_b_image").show();
                            $("#d_option_b_image").attr('href', site_url +
                                'storage/uploads/option_b_image/' + data.quiz.option_b_image);
                            $("#d_option_b_image").find('img').attr('src', site_url +
                                'storage/uploads/option_b_image/' + data.quiz.option_b_image);
                        }

                        $("#d_option_c_text").text(data.quiz.option_c_text);
                        if (data.quiz.option_c_image == '') {
                            $("#d_option_c_image").hide();
                        } else {
                            $("#d_option_c_image").show();
                            $("#d_option_c_image").attr('href', site_url +
                                'storage/uploads/option_c_image/' + data.quiz.option_c_image);
                            $("#d_option_c_image").find('img').attr('src', site_url +
                                'storage/uploads/option_c_image/' + data.quiz.option_c_image);
                        }

                        $("#d_option_d_text").text(data.quiz.option_d_text);
                        if (data.quiz.option_a_image == '') {
                            $("#d_option_d_image").hide();
                        } else {
                            $("#d_option_d_image").show();
                            $("#d_option_d_image").attr('href', site_url +
                                'storage/uploads/option_d_image/' + data.quiz.option_d_image);
                            $("#d_option_d_image").find('img').attr('src', site_url +
                                'storage/uploads/option_d_image/' + data.quiz.option_d_image);
                        }
                        $("#d_correct_answer").text(data.quiz.correct_answer);
                        $("#d_difficulty_level").text(data.quiz.difficulty_level);

                        if (data.lesson_reference) {
                            $.each(data.lesson_reference, function(key, value) {
                                $('#d_lesson_references').append(value.title);
                                $('#d_lesson_references').append('<br>');



                            });
                        }
                    }
                }),
                dataType: 'json'
            });
        }
        var chapterId = {{ $chapter_id }};
        var table = $('#content_view').DataTable({
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
                url: site_url + 'api/quiz/list',
                type: 'POST',
                data: {
                    chapter_id: chapterId,
                    '_token': '{{ csrf_token() }}'
                }
            },
            columns: [{
                    data: 'question_text'
                },
                {
                    data: 'difficulty_level'
                },
                {
                    data: 'option_a_text'
                },
                {
                    data: 'option_b_text'
                },
                {
                    data: 'option_c_text'
                },
                {
                    data: 'option_d_text'
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
                url: site_url + 'api/quiz/delete',
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
        $(document).on('hide.bs.modal', '#modal-form', function() {
            // alert('ssss');
            $('#entry_edit_form').get(0).reset();
            // $('#entry_edit_form').trigger("reset");
            $("#saveBTN").attr("onclick", "saveForm()");
            $("#saveBTN").html("Save");
            $("#modal-form-title").html("Quiz Add Form");
        });
    </script>

@stop
