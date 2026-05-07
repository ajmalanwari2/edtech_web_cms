@extends('layouts.master')
@section('title')
    <title>Dashboard</title>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card radius-10 border-0 card-h" style="
    background-color: #075c7d;">
                        <div class="card-body cardbody">
                            <div class="row">
                                <!-- start of icon box -->
                                <div class="widgets_div col">
                                    <div class="icon_div">
                                        <span><i class="bx bx-group"></i></span>
                                    </div>
                                    <a style="text-decoration:none; color: inherit;"
                                        href="{{ route('dashboard.student_index') }}">
                                        <div class="text_div">
                                            <span class="std">Students</span><br>
                                            <span class="std-num">{{ $student_count }}</span><br>
                                            <span class="std-per">{{ $studentPercentage }}%</span>
                                        </div>
                                    </a>
                                </div>
                                <!-- end of icon box -->
                                <!-- start of icon box -->
                                <div class="widgets_div col">
                                    <div class="icon_div">
                                        <span><i class="bx bx-group"></i></span>
                                    </div>
                                    <a style="text-decoration:none; color: inherit;"
                                        href="{{ route('dashboard.teacher_index') }}">
                                        <div class="text_div">
                                            <span class="std">Teachers</span><br>
                                            <span class="std-num">{{ $teacher_count }}</span><br>
                                            <span class="std-per">{{ $teacherPercentage }}%</span>
                                        </div>
                                    </a>
                                </div>
                                <!-- end of icon box -->
                                <!-- start of icon box -->
                                <div class="widgets_div col">
                                    <div class="icon_div">
                                        <span><i class="bx bx-group"></i></span>
                                    </div>
                                    <a style="text-decoration:none; color: inherit;"
                                        href="{{ route('dashboard.parent_index') }}">
                                        <div class="text_div">
                                            <span class="std">Parents</span><br>
                                            <span class="std-num">{{ $parent_count }}</span><br>
                                            <span class="std-per">{{ $parentPercentage }}%</span>
                                        </div>
                                    </a>
                                </div>
                                <!-- end of icon box -->
                                <!-- start of icon box -->
                                <div class="widgets_div col">
                                    <div class="icon_div">
                                        <span><i class="bx bx-user-check"></i></span>
                                    </div>
                                    <a style="text-decoration:none; color: inherit;"
                                        href="{{ route('dashboard.sync_users') }}">
                                        <div class="text_div">
                                            <span class="std">Active Users</span><br>
                                            <span class="std-num">{{ $syncUsers }}</span><br>
                                            <span class="std-per">{{ $syncUserPercentage }}%</span>
                                        </div>
                                    </a>
                                </div>
                                <!-- end of icon box -->
                                <!-- start of icon box -->
                                <div class="widgets_div col">
                                    <div class="icon_div">
                                        <span><i class="bx bx-user-x"></i></span>
                                    </div>
                                    <a style="text-decoration:none; color: inherit;"
                                        href="{{ route('dashboard.unsync_users') }}">
                                        <div class="text_div">
                                            <span class="std">Inactive Users</span><br>
                                            <span class="std-num">{{ $unSyncUsers }}</span><br>
                                            <span class="std-per">{{ $unSyncUserPercentage }}%</span>
                                        </div>
                                    </a>
                                </div>
                                <!-- end of icon box -->
                                <!-- start of icon box -->
                                <div class="widgets_div col" style="border-right: 0;">
                                    <div class="icon_div">
                                        <span><i class="bx bx-user-plus"></i></span>
                                    </div>
                                    <a style="text-decoration:none; color: inherit;"
                                        href="{{ route('user.regisered_index') }}">
                                        <div class="text_div">
                                            <span class="std">All Users</span><br>
                                            <span class="std-num">{{ $totalUsers }}</span><br>
                                            <span class="std-per">{{ $totalUsersPercentage }}%</span>
                                        </div>
                                    </a>
                                </div>
                                <!-- end of icon box -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of chart design -->
            <div class="row">
                <div class="col-md-4 mb-1">
                    <div class="card border-0 card-h mt-3">
                        <div class="card-body div-box-height">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title cardTitle mb-0">Number of Registered Students</h5>
                                <div class="col-md-5">
                                    <select class="form-select border-0 bg-light" id="studentGenderFilter">
                                        <option value="all">All</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div id="studentGenderPie" style="height: 320px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-1">
                    <div class="card border-0 card-h mt-3">
                        <div class="card-body div-box-height">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title cardTitle mb-0">Number of Registered Teachers</h5>
                                <div class="col-md-5">
                                    <select class="form-select border-0 bg-light" id="teacherGenderFilter">
                                        <option value="all">All</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div id="teacherGenderPie" style="height: 320px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-1">
                    <div class="card border-0 card-h mt-3">
                        <div class="card-body div-box-height">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title cardTitle mb-0">Number of Registered Parents</h5>
                                <div class="col-md-5">
                                    <select class="form-select border-0 bg-light" id="parentGenderFilter">
                                        <option value="all">All</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div id="parentGenderPie" style="height: 320px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-1">
                    <div class="card border-0 card-h mt-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title cardTitle mb-0">Number of Registered Students By Grade and Gender</h5>
                                <div class="d-flex gap-2">
                                    <select class="form-select border-0 bg-light" id="gradeStudentGradeFilter">
                                        <option value="all">All Grades</option>
                                        @foreach ($grade_statisticts as $grade_statistict)
                                            <option value="{{ $grade_statistict->grade_id }}">
                                                {{ $grade_statistict->grade_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select class="form-select border-0 bg-light" id="gradeStudentGenderFilter">
                                        <option value="all">All Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div id="gradeGenderBarChart" style="height: 320px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"><br><br><br></div>
            <!-- subject section start -->
            <div class="row">
                <div class="col-md-4 mb-1">
                    <div class="card border-0 card-h mt-3">
                        <div class="card-body div-box-height">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title cardTitle">Subject Statistics</h5>
                                <div class="col-md-6">

                                    <select class="form-select border-0 bg-light" onchange="getSubjectStatics()"
                                        id="subject_statistics" name="subject_statistics">

                                        @foreach ($grades as $grade)
                                            <option {{ old('grade_id') == $grade->id ? 'selected' : '' }}
                                                value="{{ $grade->id }}">
                                                {{ $grade->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row card-hh" id="subject_statistics_div">
                                @foreach ($subject_statistics as $subject_statistic)
                                    <div class="col col-md-6 col-xs-12 col-sm-12 no-pad">
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.subject_index', $subject_statistic->subject_id) }}">
                                            <div class="m_card">
                                                <img
                                                    src="{{ asset('storage/uploads/icon/' . $subject_statistic->subject_icon) }}">
                                                <h6>{{ $subject_statistic->subject_name }}</h6>
                                                <div class="d-flex justify-content-center">
                                                    <div class="icon-v">
                                                        <i class="bx bx-video-recording v-icon"></i>
                                                        <span class="v-text">{{ $subject_statistic->video_count }}</span>
                                                    </div>
                                                    <div class="icon-v">
                                                        <i class="bx bx-volume-full"></i>
                                                        <span class="v-text">{{ $subject_statistic->audio_count }}</span>
                                                    </div>
                                                    <div class="icon-v">
                                                        <i class="bx bx-file"></i>
                                                        <span class="v-text">{{ $subject_statistic->doc_count }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- subject section end -->
                <!-- Course Statistics start -->
                <div class="col-md-4 mb-1">
                    <div class="card border-0 card-h mt-3">
                        <div class="card-body div-box-height">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title cardTitle">Courses Statistics</h5>
                            </div>
                            <hr>
                            <div class="row card-hh">
                                @foreach ($courses_statistics as $courses_statistic)
                                    <div class="col col-md-6 col-xs-12 col-sm-12 no-pad">
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.course_index', $courses_statistic->course_id) }}">
                                            <div class="m_card">
                                                <img
                                                    src="{{ asset('storage/uploads/course_icon/' . $courses_statistic->course_icon) }}">
                                                <h6>{{ $courses_statistic->course_name }}</h6>
                                                <div class="d-flex justify-content-center">
                                                    <div class="icon-v">
                                                        <i class="bx bx-video-recording v-icon"></i>
                                                        <span class="v-text">{{ $courses_statistic->video_count }}</span>
                                                    </div>
                                                    <div class="icon-v">
                                                        <i class="bx bx-volume-full"></i>
                                                        <span class="v-text">{{ $courses_statistic->audio_count }}</span>
                                                    </div>
                                                    <div class="icon-v">
                                                        <i class="bx bx-file"></i>
                                                        <span class="v-text">{{ $courses_statistic->doc_count }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Course Statistics end -->
                <!-- Library Statistics start -->
                <div class="col-md-4 mb-1">
                    <div class="card border-0 card-h mt-3">
                        <div class="card-body div-box-height">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title cardTitle">Library Statistics</h5>
                                <div class="col-md-6">
                                    <select class="form-select border-0 bg-light" id="library_statistics"
                                        name="library_statistics" onchange="getLibraryStatics()">
                                        <option value="all">Filter by: All</option>
                                        <option value="video">Video</option>
                                        <option value="audio">Audio</option>
                                        <option value="document">Document</option>
                                        <option value="iqra-kit">IQRA Kit</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row card-hh" id="main_div">
                                @foreach ($library_documents as $library_document)
                                    <div class="listg" id="library_documents_div">
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.library_document_index', $library_document->document_id) }}">
                                            <div class="list-text">
                                                <i class="bx bx-book"></i>
                                                <h4 class="ms-2">{{ $library_document->description }}</h4>
                                            </div>
                                        </a>
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.library_document_index', $library_document->document_id) }}">
                                            <div class="num-text">
                                                <span>{{ $library_document->library_document_count }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                @foreach ($library_videos as $library_video)
                                    <div class="listg" id="library_videos_div">
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.library_video_index', $library_video->video_id) }}">
                                            <div class="list-text">
                                                <i class="bx bx-video-recording"></i>
                                                <h4 class="ms-2">{{ $library_video->description }}</h4>
                                            </div>
                                        </a>
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.library_video_index', $library_video->video_id) }}">
                                            <div class="num-text">
                                                <span>{{ $library_video->library_video_count }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                @foreach ($library_audios as $library_audio)
                                    <div class="listg" id="library_audios_div">
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.library_audio_index', $library_audio->audio_id) }}">
                                            <div class="list-text">
                                                <i class="bx bx-volume-full"></i>
                                                <h4 class="ms-2">{{ $library_audio->description }}</h4>
                                            </div>
                                        </a>
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.library_audio_index', $library_audio->audio_id) }}">
                                            <div class="num-text">
                                                <span>{{ $library_audio->library_audio_count }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                @foreach ($library_kits as $library_kit)
                                    <div class="listg" id="library_kits_div">
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.library_kit_index', $library_kit->kit_id) }}">
                                            <div class="list-text">
                                                <i class="bx bx-folder"></i>
                                                <h4 class="ms-2">{{ $library_kit->name }}</h4>
                                            </div>
                                        </a>
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.library_kit_index', $library_kit->kit_id) }}">
                                            <div class="num-text">
                                                <span>{{ $library_kit->library_kit_count }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Library Statistics end -->
            </div>
            <div class="col-md-12 mb-1">
                <div class="card border-0 card-h mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title cardTitle">Enrollment Progress</h5>
                            <div class="col-md-3">
                                <select class="form-select border-0 bg-light" id="yearFilter">
                                    <option value="2023" {{ $year == 2023 ? 'selected' : '' }}>2023</option>
                                    <option value="2024" {{ $year == 2024 ? 'selected' : '' }}>2024</option>
                                    <option value="2025" {{ $year == 2025 ? 'selected' : '' }}>2025</option>
                                    <option value="2026" {{ $year == 2026 ? 'selected' : '' }}>2026</option>
                                    <option value="2027" {{ $year == 2027 ? 'selected' : '' }}>2027</option>
                                    <option value="2028" {{ $year == 2028 ? 'selected' : '' }}>2028</option>
                                    <option value="2029" {{ $year == 2029 ? 'selected' : '' }}>2029</option>
                                    <option value="2030" {{ $year == 2030 ? 'selected' : '' }}>2030</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div id="columnchart_material1" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
            <!-- last part start -->
            <div class="row">
                <div class="col col-md-8 col-sm-12 col-xs-12 mb-1">
                    <div class="card border-0 card-h mt-3">
                        <div class="card-body div-box-height">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title cardTitle">Grade Statistics</h5>
                            </div>
                            <hr>
                            <div class="row card-hhh">
                                @foreach ($grade_statisticts as $grade_statistict)
                                    <!-- row 1 start -->
                                    <div class="content-box">
                                        <div class="grd" style="width: 120px !important">
                                            <span>{{ $grade_statistict->grade_name }}</span>
                                        </div>
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.grade_index', $grade_statistict->grade_id) }}">
                                            <div class="grd-m">
                                                <i class="bx bx-male"></i>
                                                <span>{{ $grade_statistict->male_student_count }}</span>
                                            </div>
                                        </a>
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.grade_index', $grade_statistict->grade_id) }}">
                                            <div class="grd-f">
                                                <i class="bx bx-female"></i>
                                                <span>{{ $grade_statistict->female_student_count }}</span>
                                            </div>
                                        </a>
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.grade_lessons_index', $grade_statistict->grade_id) }}">
                                            <div class="grd-v">
                                                <i class="bx bx-video-recording"></i>
                                                <span>{{ $grade_statistict->video_count }}</span>
                                            </div>
                                        </a>
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.grade_lessons_index', $grade_statistict->grade_id) }}">
                                            <div class="grd-s">
                                                <i class="bx bx-volume-full"></i>
                                                <span>{{ $grade_statistict->audio_count }}</span>
                                            </div>
                                        </a>
                                        <a style="text-decoration:none; color: inherit;"
                                            href="{{ route('dashboard.grade_lessons_index', $grade_statistict->grade_id) }}">
                                            <div class="grd-ff">
                                                <i class="bx bx-folder-open"></i>
                                                <span>{{ $grade_statistict->doc_count }}</span>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- row 1 end -->
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end last part -->
                <!-- last part2 start -->
                <div class="col col-md-4 col-sm-12 col-xs-12 mb-5">
                    <div class="card border-0 card-h mt-3">
                        <div class="card-body div-box-height">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title cardTitle">Provincial Users Statistics</h5>
                            </div>
                            <hr>
                            <div class="row card-hhh">
                                <!-- row1 start -->
                                @foreach ($provincial_user_statistics as $provincial_user_statistic)
                                    <div class="prv-box">
                                        <div class="prv-g">
                                            <span>{{ $provincial_user_statistic->province_name }}</span>
                                        </div>
                                        <div class="pro-box">
                                            <a style="text-decoration:none; color: inherit;"
                                                href="{{ route('dashboard.province_student_index', $provincial_user_statistic->province_id) }}">
                                                <div class="prv-std">
                                                    <p>Students</p>
                                                    <span
                                                        class="pmale">{{ $provincial_user_statistic->male_student_count }}</span>
                                                    <span
                                                        class="pfemale">{{ $provincial_user_statistic->female_student_count }}</span>
                                                </div>
                                            </a>
                                            <a style="text-decoration:none; color: inherit;"
                                                href="{{ route('dashboard.province_teacher_index', $provincial_user_statistic->province_id) }}">
                                                <div class="prv-tchr">
                                                    <p>Teachers</p>
                                                    <span
                                                        class="pmale">{{ $provincial_user_statistic->male_teacher_count }}</span>
                                                    <span
                                                        class="pfemale">{{ $provincial_user_statistic->female_teacher_count }}</span>
                                                </div>
                                            </a>
                                            <a style="text-decoration:none; color: inherit;"
                                                href="{{ route('dashboard.province_parent_index', $provincial_user_statistic->province_id) }}">
                                                <div class="prv-prnt">
                                                    <p>Parents</p>
                                                    <span
                                                        class="pmale">{{ $provincial_user_statistic->male_parent_count }}</span>
                                                    <span
                                                        class="pfemale">{{ $provincial_user_statistic->female_parent_count }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- row1 end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <style>
        .div-box-height {
            min-height: 29rem !important;
        }

        .card-hhh {
            max-height: 29rem !important;
        }
    </style>
@stop
@section('scripts')

    <script>
        function getSubjectStatics() {
            $.ajax({
                type: "POST",
                url: site_url + 'api/dashboard/index',
                data: {
                    '_token': '{{ csrf_token() }}',
                    subject_statistics: $('#subject_statistics').val(),
                },
                error: function() {
                    $.toaster({
                        priority: 'danger',
                        title: 'Info',
                        message: 'There was an error loading the record.',
                    });
                },
                success: function(data) {
                    var html = '';
                    $('#subject_statistics_div').html('');
                    $.each(data.subject_statistics, function(i) {
                        var subjectId = data.subject_statistics[i].subject_id;
                        var subjectIcon = data.subject_statistics[i].subject_icon;
                        var subjectName = data.subject_statistics[i].subject_name;
                        var videoCount = data.subject_statistics[i].video_count;
                        var audioCount = data.subject_statistics[i].audio_count;
                        var docCount = data.subject_statistics[i].doc_count;

                        var subjectHtml = `<div class="col col-md-6 col-xs-12 col-sm-12 no-pad">
                    <a style="text-decoration:none; color: inherit;" href="/dashboard/subject_index/${subjectId}">
                        <div class="m_card">
                            <img src="/storage/uploads/icon/${subjectIcon}" >
                            <h6>${subjectName}</h6>
                            <div class="d-flex justify-content-center">
                                <div class="icon-v">
                                    <i class="bx bx-video-recording v-icon"></i>
                                    <span class="v-text">${videoCount}</span>
                                </div>
                                <div class="icon-v">
                                    <i class="bx bx-volume-full"></i>
                                    <span class="v-text">${audioCount}</span>
                                </div>
                                <div class="icon-v">
                                    <i class="bx bx-file"></i>
                                    <span class="v-text">${docCount}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>`;

                        html += subjectHtml;
                    });

                    $('#subject_statistics_div').html(html);
                },
                dataType: 'json',
            });
        }

        function getLibraryStatics() {
            var selectedValue = $('#library_statistics').val();
            $.ajax({
                type: "POST",
                url: site_url + 'api/dashboard/library',
                data: {
                    '_token': '{{ csrf_token() }}',
                    library_statistics: selectedValue,
                },
                fail: function() {
                    $.toaster({
                        priority: 'danger',
                        title: 'Info',
                        message: 'There was an error loading records.'
                    });
                },
                success: function(data) {
                    $('.listg').remove(); // Empty all elements with the class 'listg'
                    if (data) {
                        if (data.library_documents) {
                            console.log('Iam here inside document', data);
                            var html_document = '';
                            $.each(data.library_documents, function(i) {

                                html_document += `<div class="listg" id="library_documents_div">
                                            <div class="list-text">
                                            <i class="bx bx-book"></i>
                                            <h4 class="ms-2">${data.library_documents[i].description}</h4>
                                        </div>
                                        <div class="num-text">
                                            <span>${data.library_documents[i].library_document_count}</span>
                                        </div>
                                        </div>`;
                            });
                            $('#main_div').html(html_document);
                        }

                        if (data.library_videos) {
                            console.log('Iam here inside video', data);
                            var html_video = '';
                            $.each(data.library_videos, function(i) {
                                console.log('Iam here inside video', data.library_videos[i]
                                .description);
                                html_video += `<div class="listg" id="library_videos_div"> 
                                        <div class="list-text">
                                            <i class="bx bx-video-recording"></i>
                                            <h4 class="ms-2">${data.library_videos[i].description}</h4>
                                        </div>
                                        <div class="num-text">
                                            <span>${data.library_videos[i].library_video_count}</span>
                                        </div>
                                        </div>`;
                            });
                            $('#main_div').html(html_video);
                        }

                        if (data.library_audios) {
                            var html_audio = '';
                            $.each(data.library_audios, function(i) {
                                html_audio += `<div class="listg" id="library_audios_div">
                                        <div class="list-text">
                                            <i class="bx bx-volume-full"></i>
                                            <h4 class="ms-2">${data.library_audios[i].description}</h4>
                                        </div>
                                        <div class="num-text">
                                            <span>${data.library_audios[i].library_audio_count}</span>
                                        </div></div>`;
                            });
                            $('#main_div').html(html_audio);
                        }

                        if (data.library_kits) {
                            var html_kit = '';
                            $.each(data.library_kits, function(i) {
                                html_kit += `<div class="listg" id="library_kits_div"><div class="list-text">
                                            <i class="bx bx-folder"></i>
                                            <h4 class="ms-2">${data.library_kits[i].name}</h4>
                                        </div>
                                        <div class="num-text">
                                            <span>${data.library_kits[i].library_kit_count}</span>
                                        </div></div>`;
                            });
                            $('#main_div').html(html_kit);
                        }
                    } else {
                        // Display a message when no data is returned
                        $('#library_documents_div').html('<p>No data available for this selection.</p>');
                        $('#library_videos_div').html('<p>No data available for this selection.</p>');
                        $('#library_audios_div').html('<p>No data available for this selection.</p>');
                        $('#library_kits_div').html('<p>No data available for this selection.</p>');
                    }
                },
                error: function(err) {
                    console.error('Error fetching data:', err);
                },
                dataType: 'json'
            });
        }

        google.charts.load('current', {
            'packages': ['bar', 'corechart']
        });
       
        document.addEventListener("DOMContentLoaded", function() {
            var genderChartConfigs = [{
                    elementId: 'studentGenderPie',
                    filterId: 'studentGenderFilter',
                    title: '',
                    counts: {
                        male: {{ (int) $student_male_count }},
                        female: {{ (int) $student_female_count }}
                    }
                },
                {
                    elementId: 'teacherGenderPie',
                    filterId: 'teacherGenderFilter',
                    title: '',
                    counts: {
                        male: {{ (int) $teacher_male_count }},
                        female: {{ (int) $teacher_female_count }}
                    }
                },
                {
                    elementId: 'parentGenderPie',
                    filterId: 'parentGenderFilter',
                    title: '',
                    counts: {
                        male: {{ (int) $parent_male_count }},
                        female: {{ (int) $parent_female_count }}
                    }
                }
            ];
            var gradeGenderChartData = {!! json_encode($grade_statisticts) !!};
            var chartResizeTimer = null;

            // ✅ Year Filter Change Event
            document.getElementById("yearFilter").addEventListener("change", function() {
                let selectedYear = this.value;
                window.location.href = "?year=" + selectedYear;
            });

            // ✅ Load Google Chart
            google.charts.setOnLoadCallback(drawChart);

            function isMobileView() {
                return window.innerWidth < 768;
            }

            function drawGenderPie(elementId, title, counts, selectedGender) {
                var maleCount = parseInt(counts.male) || 0;
                var femaleCount = parseInt(counts.female) || 0;
                var chartTitle = title;

                if (selectedGender === 'male') {
                    femaleCount = 0;
                    chartTitle = title + ' (Male)';
                } else if (selectedGender === 'female') {
                    maleCount = 0;
                    chartTitle = title + ' (Female)';
                }

                var data = google.visualization.arrayToDataTable([
                    ['Gender', 'Count'],
                    ['Male', maleCount],
                    ['Female', femaleCount]
                ]);

                var options = {
                    title: chartTitle,
                    height: isMobileView() ? 240 : 300,
                    pieHole: 0.4,
                    colors: ['#4e79a7', '#f28e2b'],
                    legend: {
                        position: 'bottom'
                    },
                    chartArea: {
                        width: isMobileView() ? '90%' : '85%',
                        height: isMobileView() ? '72%' : '78%'
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById(elementId));
                chart.draw(data, options);
            }

            function renderGenderCharts() {
                genderChartConfigs.forEach(function(config) {
                    var filter = document.getElementById(config.filterId);
                    var selectedGender = filter ? filter.value : 'all';
                    drawGenderPie(config.elementId, config.title, config.counts, selectedGender);
                });
            }

            function drawGradeGenderBarChart() {
                var selectedGrade = document.getElementById('gradeStudentGradeFilter') ?
                    document.getElementById('gradeStudentGradeFilter').value :
                    'all';
                var selectedGender = document.getElementById('gradeStudentGenderFilter') ?
                    document.getElementById('gradeStudentGenderFilter').value :
                    'all';
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Grade');

                if (selectedGender === 'male') {
                    data.addColumn('number', 'Male');
                } else if (selectedGender === 'female') {
                    data.addColumn('number', 'Female');
                } else {
                    data.addColumn('number', 'Male');
                    data.addColumn('number', 'Female');
                }

                gradeGenderChartData.forEach(function(item) {
                    if (selectedGrade !== 'all' && String(item.grade_id) !== String(selectedGrade)) {
                        return;
                    }

                    var maleCount = parseInt(item.male_student_count) || 0;
                    var femaleCount = parseInt(item.female_student_count) || 0;

                    if (selectedGender === 'male') {
                        data.addRow([item.grade_name, maleCount]);
                    } else if (selectedGender === 'female') {
                        data.addRow([item.grade_name, femaleCount]);
                    } else {
                        data.addRow([item.grade_name, maleCount, femaleCount]);
                    }
                });

                var options = {
                    height: isMobileView() ? 320 : 400,
                    legend: {
                        position: 'top'
                    },
                    colors: ['#4e79a7', '#f28e2b'],
                    chartArea: {
                        width: isMobileView() ? '88%' : '82%',
                        height: isMobileView() ? '48%' : '52%'
                    },
                    vAxis: {
                        minValue: 0
                    },
                    hAxis: {
                        slantedText: true,
                        slantedTextAngle: isMobileView() ? 70 : 45,
                        showTextEvery: 1,
                        textStyle: {
                            fontSize: isMobileView() ? 10 : 12
                        }
                    },
                    bar: {
                        groupWidth: isMobileView() ? '85%' : '65%'
                    }
                };

                var chart = new google.visualization.ColumnChart(
                    document.getElementById('gradeGenderBarChart')
                );

                chart.draw(data, options);
            }

            genderChartConfigs.forEach(function(config) {
                var filter = document.getElementById(config.filterId);
                if (filter) {
                    filter.addEventListener('change', renderGenderCharts);
                }
            });

            ['gradeStudentGradeFilter', 'gradeStudentGenderFilter'].forEach(function(filterId) {
                var filter = document.getElementById(filterId);
                if (filter) {
                    filter.addEventListener('change', drawGradeGenderBarChart);
                }
            });

            function drawChart() {

                var chartData = {!! json_encode($chartData) !!};

                chartData.forEach(function(item) {
                    item.student_count = parseInt(item.student_count);
                    item.teacher_count = parseInt(item.teacher_count);
                    item.parent_count = parseInt(item.parent_count);
                });

                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Month');
                data.addColumn('number', 'Student');
                data.addColumn('number', 'Teacher');
                data.addColumn('number', 'Parent');

                chartData.forEach(function(item) {
                    data.addRow([
                        item.month,
                        item.student_count,
                        item.teacher_count,
                        item.parent_count
                    ]);
                });

                var options = {
                    legend: {
                        position: isMobileView() ? 'top' : 'none'
                    },
                    bar: {
                        groupWidth: isMobileView() ? '45%' : '20%'
                    },
                    height: isMobileView() ? 280 : 350
                };

                var chart = new google.charts.Bar(
                    document.getElementById('columnchart_material1')
                );

                chart.draw(data, google.charts.Bar.convertOptions(options));

                renderGenderCharts();
                drawGradeGenderBarChart();
            }

            window.addEventListener('resize', function() {
                clearTimeout(chartResizeTimer);
                chartResizeTimer = setTimeout(function() {
                    drawChart();
                }, 150);
            });

        });
    </script>
@stop
