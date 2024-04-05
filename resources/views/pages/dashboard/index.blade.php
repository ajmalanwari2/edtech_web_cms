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
                <div class="card radius-10 border-0 card-h">
                    <div class="card-body cardbody">
                        <div class="row">
                            <!-- start of icon box -->
                            <div class="widgets_div col">
                                <div class="icon_div">
                                    <span><i class="bx bx-group"></i></span>
                                </div>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.student_index') }}">
                                <div class="text_div">
                                    <span class="std">Students</span><br>
                                    <span class="std-num">{{ $student_count }}</span><br>
                                    <span class="std-per">{{  $studentPercentage }}%</span>
                                </div>
                            </a>
                            </div>
                            <!-- end of icon box -->
                            <!-- start of icon box -->
                            <div class="widgets_div col">
                                <div class="icon_div">
                                    <span><i class="bx bx-group"></i></span>
                                </div>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.teacher_index') }}">
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
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.parent_index') }}">
                                <div class="text_div">
                                    <span class="std">Parents</span><br>
                                    <span class="std-num">{{ $parent_count }}</span><br>
                                    <span class="std-per">{{$parentPercentage}}%</span>
                                </div>
                            </a>
                            </div>
                            <!-- end of icon box -->
                            <!-- start of icon box -->
                            <div class="widgets_div col">
                                <div class="icon_div">
                                    <span><i class="bx bx-user-check"></i></span>
                                </div>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.sync_users') }}">
                                <div class="text_div">
                                    <span class="std">Active Users</span><br>
                                    <span class="std-num">{{$syncUsers}}</span><br>
                                    <span class="std-per">{{$syncUserPercentage}}%</span>
                                </div>
                            </a>
                            </div>
                            <!-- end of icon box -->
                            <!-- start of icon box -->
                            <div class="widgets_div col">
                                <div class="icon_div">
                                    <span><i class="bx bx-user-x"></i></span>
                                </div>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.unsync_users') }}">
                                <div class="text_div">
                                    <span class="std">Inactive Users</span><br>
                                    <span class="std-num">{{$unSyncUsers}}</span><br>
                                    <span class="std-per">{{$unSyncUserPercentage}}%</span>
                                </div>
                                </a>
                            </div>
                            <!-- end of icon box -->
                            <!-- start of icon box -->
                            <div class="widgets_div col" style="border-right: 0;">
                                <div class="icon_div">
                                    <span><i class="bx bx-user-plus"></i></span>
                                </div>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('user.regisered_index') }}">
                                <div class="text_div">
                                    <span class="std">All Users</span><br>
                                    <span class="std-num">{{$totalUsers}}</span><br>
                                    <span class="std-per">{{$totalUsersPercentage}}%</span>
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
                            @foreach($subject_statistics as $subject_statistic)
                            <div class="col col-md-6 col-xs-12 col-sm-12 no-pad">
                            <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.subject_index', $subject_statistic->subject_id) }}">
                                <div class="m_card">
                                <img src="{{ asset('storage/uploads/icon/' . $subject_statistic->subject_icon) }}">
                                    <h6>{{$subject_statistic->subject_name}}</h6>
                                    <div class="d-flex justify-content-center">
                                        <div class="icon-v">
                                            <i class="bx bx-video-recording v-icon"></i>
                                            <span class="v-text">{{$subject_statistic->video_count}}</span>
                                        </div>
                                        <div class="icon-v">
                                            <i class="bx bx-volume-full"></i>
                                            <span class="v-text">{{$subject_statistic->audio_count}}</span>
                                        </div>
                                        <div class="icon-v">
                                            <i class="bx bx-file"></i>
                                            <span class="v-text">{{$subject_statistic->doc_count}}</span>
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
                            @foreach($courses_statistics as $courses_statistic)
                            <div class="col col-md-6 col-xs-12 col-sm-12 no-pad">
                            <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.course_index', $courses_statistic->course_id) }}">
                                <div class="m_card">
                                <img src="{{ asset('storage/uploads/course_icon/' . $courses_statistic->course_icon) }}">
                                    <h6>{{$courses_statistic->course_name}}</h6>
                                    <div class="d-flex justify-content-center">
                                        <div class="icon-v">
                                            <i class="bx bx-video-recording v-icon"></i>
                                            <span class="v-text">{{$courses_statistic->video_count}}</span>
                                        </div>
                                        <div class="icon-v">
                                            <i class="bx bx-volume-full"></i>
                                            <span class="v-text">{{$courses_statistic->audio_count}}</span>
                                        </div>
                                        <div class="icon-v">
                                            <i class="bx bx-file"></i>
                                            <span class="v-text">{{$courses_statistic->doc_count}}</span>
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
                        <div class="row card-hh">
                            @foreach($library_documents as $library_document)
                            <div class="listg" id="library_documents_div">
                            <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.library_document_index', $library_document->document_id) }}">
                                <div class="list-text">
                                    <i class="bx bx-book"></i>
                                    <h4 class="ms-2">{{$library_document->description}}</h4>
                                </div>
                            </a>
<a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.library_document_index', $library_document->document_id) }}">
                                <div class="num-text">
                                    <span>{{$library_document->library_document_count}}</span>
                                </div>
                                </a>
                            </div>
                            @endforeach
                            @foreach($library_videos as $library_video)
                            <div class="listg" id="library_videos_div">
                            <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.library_video_index', $library_video->video_id) }}">
                                <div class="list-text">
                                    <i class="bx bx-video-recording"></i>
                                    <h4 class="ms-2">{{$library_video->description}}</h4>
                                </div>
                                </a>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.library_video_index', $library_video->video_id) }}">
                                <div class="num-text">
                                    <span>{{$library_video->library_video_count}}</span>
                                </div>
                            </a>
                            </div>
                            @endforeach
                            @foreach($library_audios as $library_audio)
                            <div class="listg" id="library_audios_div">
                            <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.library_audio_index', $library_audio->audio_id) }}">
                                <div class="list-text">
                                    <i class="bx bx-volume-full"></i>
                                    <h4 class="ms-2">{{$library_audio->description}}</h4>
                                </div>
                                </a>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.library_audio_index', $library_audio->audio_id) }}">
                                <div class="num-text">
                                    <span>{{$library_audio->library_audio_count}}</span>
                                </div>
                            </a>
                            </div>
                            @endforeach
                            @foreach($library_kits as $library_kit)
                            <div class="listg" id="library_kits_div">
                            <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.library_kit_index', $library_kit->kit_id) }}">
                                <div class="list-text">
                                    <i class="bx bx-folder"></i>
                                    <h4 class="ms-2">{{$library_kit->name}}</h4>
                                </div>
</a>
<a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.library_kit_index', $library_kit->kit_id) }}">
                                <div class="num-text">
                                    <span>{{$library_kit->library_kit_count}}</span>
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
                            <select class="form-select border-0 bg-light" id="inputCollection">
                                <option><span class="filter">Filter by:</span>Year</option>
                                <option value="1">2024</option>
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
                            @foreach($grade_statisticts as $grade_statistict)
                            <!-- row 1 start -->
                            <div class="content-box">
                                <div class="grd" style="width: 120px !important">
                                    <span>{{$grade_statistict->grade_name}}</span>
                                </div>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.grade_index', $grade_statistict->grade_id) }}">
                                <div class="grd-m">
                                    <i class="bx bx-male"></i>
                                    <span>{{$grade_statistict->male_student_count}}</span>
                                </div>
                                </a>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.grade_index', $grade_statistict->grade_id) }}">
                                <div class="grd-f">
                                    <i class="bx bx-female"></i>
                                    <span>{{$grade_statistict->female_student_count}}</span>
                                </div>
                            </a>
                            <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.grade_lessons_index', $grade_statistict->grade_id) }}">
                                <div class="grd-v">
                                    <i class="bx bx-video-recording"></i>
                                    <span>{{$grade_statistict->video_count}}</span>
                                </div>
                            </a>
                            <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.grade_lessons_index', $grade_statistict->grade_id) }}">
                                <div class="grd-s">
                                    <i class="bx bx-volume-full"></i>
                                    <span>{{$grade_statistict->audio_count}}</span>
                                </div>
                            </a>
                            <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.grade_lessons_index', $grade_statistict->grade_id) }}">
                                <div class="grd-ff">
                                    <i class="bx bx-folder-open"></i>
                                    <span>{{$grade_statistict->doc_count}}</span>
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
                            @foreach($provincial_user_statistics as $provincial_user_statistic)
                            <div class="prv-box">
                                <div class="prv-g">
                                    <span>{{$provincial_user_statistic->province_name}}</span>
                                </div>
                                <div class="pro-box">
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.province_student_index', $provincial_user_statistic->province_id) }}">
                                    <div class="prv-std">
                                        <p>Students</p>
                                        <span class="pmale">{{$provincial_user_statistic->male_student_count}}</span>
                                        <span
                                            class="pfemale">{{$provincial_user_statistic->female_student_count}}</span>
                                    </div>
                                </a>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.province_teacher_index', $provincial_user_statistic->province_id) }}">
                                    <div class="prv-tchr">
                                        <p>Teachers</p>
                                        <span class="pmale">{{$provincial_user_statistic->male_teacher_count}}</span>
                                        <span
                                            class="pfemale">{{$provincial_user_statistic->female_teacher_count}}</span>
                                    </div>
                                </a>
                                <a style="text-decoration:none; color: inherit;" href="{{ route('dashboard.province_parent_index', $provincial_user_statistic->province_id) }}">
                                    <div class="prv-prnt">
                                        <p>Parents</p>
                                        <span class="pmale">{{$provincial_user_statistic->male_parent_count}}</span>
                                        <span class="pfemale">{{$provincial_user_statistic->female_parent_count}}</span>
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

    $.ajax({
        type: "POST",
        url: site_url + 'api/dashboard/library',
        data: {
            '_token': '{{ csrf_token() }}',
            library_statistics: $('#library_statistics').val(),

        },
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'There was error loading record.'
            });
        }),
        success: (function(data) {
            var html_document = '';
            var html_video = '';
            var html_audio = '';
            var html_kit = '';
            $('#library_documents_div').html('');
            $('#library_videos_div').html('');
            $('#library_audios_div').html('');
            $('#library_kits_div').html('');
            console.log(data);
            if (data && data.library_documents) {
                $.each(data.library_documents, function(i) {
                    html_document += `<div class="list-text">
                                        <i class="bx bx-book"></i>
                                        <h4 class="ms-2">${data.library_documents[i].description}</h4>
                                    </div>
                                    <div class="num-text">
                                        <span>${data.library_documents[i].library_document_count}</span>
                                    </div>`;
                });
                $('#library_documents_div').html(html_document);
            } else if (data && data.library_videos) {
                $.each(data.library_videos, function(i) {
                    html_video += `<div class="list-text">
<i class="bx bx-video-recording"></i>
                                        <h4 class="ms-2">${data.library_videos[i].description}</h4>
                                    </div>
                                    <div class="num-text">
                                        <span>${data.library_videos[i].library_video_count}</span>
                                    </div>`;
                });


                $('#library_videos_div').html(html_video);
            } else if (data && data.library_audios) {
                $.each(data.library_audios, function(i) {
                    html_audio += `<div class="list-text">
<i class="bx bx-volume-full"></i>
                                        <h4 class="ms-2">${data.library_audios[i].description}</h4>
                                    </div>
                                    <div class="num-text">
                                        <span>${data.library_audios[i].library_audio_count}</span>
                                        </div>`;
                });
                $('#library_audios_div').html(html_audio);
            } else if (data && data.library_kits) {
                $.each(data.library_kits, function(i) {
                    html_kit += `<div class="list-text">
<i class="bx bx-folder"></i>
                                        <h4 class="ms-2">${data.library_kits[i].name}</h4>
                                    </div>
                                    <div class="num-text">
                                        <span>${data.library_kits[i].library_kit_count}</span>`;
                });
                $('#library_kits_div').html(html_kit);
            } else {



                $.each(data.library_documents, function(i) {
                    html_document += `<div class="list-text">
                                        <i class="bx bx-book"></i>
                                        <h4 class="ms-2">${data.library_documents[i].description}</h4>
                                    </div>
                                    <div class="num-text">
                                        <span>${data.library_documents[i].library_document_count}</span>
                                    </div>`;
                });
                $.each(data.library_videos, function(i) {
                    html_video += `<div class="list-text">
<i class="bx bx-video-recording"></i>
                                        <h4 class="ms-2">${data.library_videos[i].description}</h4>
                                    </div>
                                    <div class="num-text">
                                        <span>${data.library_videos[i].library_video_count}</span>
                                    </div>`;
                });
                $.each(data.library_audios, function(i) {
                    html_audio += `<div class="list-text">
<i class="bx bx-volume-full"></i>
                                        <h4 class="ms-2">${data.library_audios[i].description}</h4>
                                    </div>
                                    <div class="num-text">
                                        <span>${data.library_audios[i].library_audio_count}</span>
                                        </div>`;
                });
                $.each(data.library_kits, function(i) {
                    html_kit += `<div class="list-text">
<i class="bx bx-folder"></i>
                                        <h4 class="ms-2">${data.library_kits[i].name}</h4>
                                    </div>
                                    <div class="num-text">
                                        <span>${data.library_kits[i].library_kit_count}</span>`;
                });
                $('#library_documents_div').html(html_document);
                $('#library_videos_div').html(html_video);
                $('#library_audios_div').html(html_audio);
                $('#library_kits_div').html(html_kit);

            }
        }),
        dataType: 'json'
    });
}

google.charts.load('current', {
    'packages': ['bar']
});
// google.charts.setOnLoadCallback(drawChart);
// function drawChart() {
//     var chartData = {!!json_encode($chartData) !!};

//     // Convert string values to numbers
//     chartData.forEach(function(item) {
//         item.student_count = parseInt(item.student_count);
//         item.teacher_count = parseInt(item.teacher_count);
//         item.parent_count = parseInt(item.parent_count);
//     });

//     var data = google.visualization.arrayToDataTable([
//         ['Month', 'Student', 'Teacher', 'Parent'],
//         [chartData[0].month, chartData[0].student_count, chartData[0].teacher_count, chartData[0].parent_count],
//         [chartData[1].month, chartData[1].student_count, chartData[1].teacher_count, chartData[1].parent_count]
//     ]);

//     var options = {
//         legend: {
//             position: 'none'
//         },
//         chart: {},
//         axes: {
//             x: {
//                 0: {
//                     side: 'top',
//                     label: '.'
//                 }
//             } // Top x-axis.
//         },
//         bar: {
//             groupWidth: "20%"
//         },
//         colors: ['#1c6ac6', '#b3e49c'],
//         is3D: true
//     };

//     var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));
//     chart.draw(data, google.charts.Bar.convertOptions(options));
// }

google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var chartData = {!!json_encode($chartData) !!};

    // Convert string values to numbers
    chartData.forEach(function (item) {
        item.student_count = parseInt(item.student_count);
        item.teacher_count = parseInt(item.teacher_count);
        item.parent_count = parseInt(item.parent_count);
    });

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Month');
    data.addColumn('number', 'Student');
    data.addColumn('number', 'Teacher');
    data.addColumn('number', 'Parent');

    chartData.forEach(function (item) {
        data.addRow([item.month, item.student_count, item.teacher_count, item.parent_count]);
    });

    var options = {
        legend: {
            position: 'none'
        },
        chart: {},
        axes: {
            x: {
                0: {
                    side: 'top',
                    label: '.'
                }
            } // Top x-axis.
        },
        bar: {
            groupWidth: "20%"
        },
        colors: ['#1c6ac6', '#b3e49c'],
        is3D: true
    };

    var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
}
</script>
@stop