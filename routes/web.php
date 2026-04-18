<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegionalManagementOfficeController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\UserCreationRequestController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentParentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\LibraryDocumentContentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\LibraryDocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibraryVideoController;
use App\Http\Controllers\LibraryAudioController;
use App\Http\Controllers\LibraryKitController;
use App\Http\Controllers\LibraryVideoContentController;
use App\Http\Controllers\LibraryAudioContentController;
use App\Http\Controllers\LibraryKitContentController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Session;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['domain' => config('app.app_url_domain')], function () {

    // Route::get('/', [HomeController::class, 'landing'])->name('home');
    // Route::get('/{lang?}', [FrontEndController::class, 'index'])->name('home');
    Route::prefix('/{lang?}')->name('frontend.')->group(function(){
        Route::get('/', [FrontEndController::class, 'index'])->name('/');
        Route::get('aboutus', [FrontEndController::class, 'aboutus'])->name('aboutus');
        Route::get('content', [FrontEndController::class, 'content'])->name('content');
        Route::get('contact', [FrontEndController::class, 'contact'])->name('contact');
        Route::post('contact_submit', [FrontEndController::class, 'contact_submit'])->name('contact_submit');
        Route::get('grade/{id}', [FrontEndController::class, 'grade'])->name('grade');
        Route::get('grade/{grade_id}/subject/{subject_id}', [FrontEndController::class, 'subject'])->name('subject');
        Route::get('request_form', [FrontEndController::class, 'request_form'])->name('request_form');
        Route::post('request_form_submit', [FrontEndController::class, 'request_form_submit'])->name('request_form_submit');
        Route::get('course', [FrontEndController::class, 'course'])->name('course');
        Route::get('courseContent/{id}', [FrontEndController::class, 'courseContent'])->name('courseContent');
         Route::get('term_and_policy', [FrontEndController::class, 'term_and_policy'])->name('term_and_policy');
    });
    Route::post('/get_districts', [DistrictController::class, 'getDistrictsThroughProvince']);
        Route::post('/get_grades', [FrontEndController::class, 'getGradedThroughLanguage']);
    // Route::get('/', function () {
    //     return view('underconstruction');
    // });

    Route::prefix('landing')->name('landing.')->group(function(){

        Route::get('subject/{grade_id}', [HomeController::class, 'subjectList'])->name('subject');
        Route::get('lessons/{subject_id}', [HomeController::class, 'lessonList'])->name('lessons');
    });

});

Route::group(['domain' => config('app.app_admin_domain')], function () {

        Route::post('/get_districts', [DistrictController::class, 'getDistrictsThroughProvince']);
        Route::post('/get_provinces', [ProvinceController::class, 'getProvincesThroughRMO']);
        Route::post('/get_subjects', [SubjectController::class, 'getSubjectsThroughGrade']);

});

Route::group(['middleware' => ['auth:sanctum', 'EnsureUserIsActive', 'DebugBarCheck'],'domain' => config('app.app_admin_domain')], function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin_home');
    Route::get('/home', [HomeController::class, 'index']);
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('create', [HomeController::class, 'create'])->name('create');
        Route::post('store', [HomeController::class, 'store'])->name('store');
    });
    Route::prefix('rmo')->name('rmo.')->group(function () {
        Route::get('index', [RegionalManagementOfficeController::class, 'index'])->name('index');
    });
    Route::prefix('province')->name('province.')->group(function () {
        Route::get('index', [ProvinceController::class, 'index'])->name('index');
    });
    Route::prefix('district')->name('district.')->group(function () {
        Route::get('index', [DistrictController::class, 'index'])->name('index');
    });
    Route::prefix('school')->name('school.')->group(function () {
        Route::get('index', [SchoolController::class, 'index'])->name('index');
    });
    Route::prefix('grade')->name('grade.')->group(function () {
        Route::get('index', [GradeController::class, 'index'])->name('index');
        Route::get('subject_index/{grade_id}', [GradeController::class, 'subjectIndex'])->name('subject_index');
    });
    Route::prefix('subject')->name('subject.')->group(function () {
        Route::get('index', [SubjectController::class, 'index'])->name('index');
        Route::get('content_index/{subject_id}', [SubjectController::class, 'contentIndex'])->name('content_index');
    });
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('index', [StudentController::class, 'index'])->name('index');
    });
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('index', [TeacherController::class, 'index'])->name('index');
    });
    Route::prefix('parent')->name('parent.')->group(function () {
        Route::get('index', [StudentParentController::class, 'index'])->name('index');
    });
    Route::prefix('content')->name('content.')->group(function () {
        Route::get('index', [ContentController::class, 'index'])->name('index');
        Route::get('show/{subject_id}/{chapter_id}', [ContentController::class, 'show'])->name('show');
    });

    Route::prefix('notice')->name('notice.')->group(function () {
        Route::get('index', [NoticeController::class, 'index'])->name('index');
    });

    Route::prefix('news')->name('news.')->group(function () {
        Route::get('index', [NewsController::class, 'index'])->name('index');
    });
    Route::prefix('game')->name('game.')->group(function () {
        Route::get('index', [GameController::class, 'index'])->name('index');
    });

    Route::prefix('feedback')->name('feedback.')->group(function () {
        Route::get('index', [FeedbackController::class, 'index'])->name('index');
    });

    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('list/{subject_id}/{chapter_id}', [QuizController::class, 'index'])->name('show');
        Route::get('start/{chapter_id}', [QuizController::class, 'startQuiz'])->name('start');
        Route::get('answer/{chapter_id}', [QuizController::class, 'quizAnswer'])->name('answer');
        Route::post('submit_answare', [QuizController::class, 'submitAnsware'])->name('submit_answare');
    });

    Route::prefix('course')->name('course.')->group(function () {
        Route::get('index', [CourseController::class, 'index'])->name('index');
        Route::get('show/{course_id}', [CourseController::class, 'indexQuiz'])->name('show');
    });
    Route::prefix('course_content')->name('course_content.')->group(function () {
        Route::get('show/{course_id}', [CourseContentController::class, 'show'])->name('show');
    });

    Route::prefix('library_document')->name('library_document.')->group(function () {
        Route::get('index', [LibraryDocumentController::class, 'index'])->name('index');
    });

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('index', [DashboardController::class, 'index'])->name('index');
        Route::get('student_index', [DashboardController::class, 'studentIndex'])->name('student_index');
        Route::get('teacher_index', [DashboardController::class, 'teacherIndex'])->name('teacher_index');
        Route::get('parent_index', [DashboardController::class, 'parentIndex'])->name('parent_index');
        Route::get('sync_users', [DashboardController::class, 'syncUsers'])->name('sync_users');
        Route::get('unsync_users', [DashboardController::class, 'unSyncUsers'])->name('unsync_users');
        Route::get('subject_index/{subject_id}', [DashboardController::class, 'subjectIndex'])->name('subject_index');
        Route::get('course_index/{course_id}', [DashboardController::class, 'courseIndex'])->name('course_index');
        Route::get('grade_index/{grade_id}', [DashboardController::class, 'gradeIndex'])->name('grade_index');
        Route::get('grade_lessons_index/{grade_id}', [DashboardController::class, 'gradeLessonsIndex'])->name('grade_lessons_index');
        Route::get('province_student_index/{province_id}', [DashboardController::class, 'gradeStudentIndex'])->name('province_student_index');
        Route::get('province_teacher_index/{province_id}', [DashboardController::class, 'gradeTeacherIndex'])->name('province_teacher_index');
        Route::get('province_parent_index/{province_id}', [DashboardController::class, 'gradeParentIndex'])->name('province_parent_index');
        Route::get('library_document_index/{library_document_id}', [LibraryDocumentContentController::class, 'show'])->name('library_document_index');
        Route::get('library_video_index/{library_video_id}', [LibraryVideoContentController::class, 'show'])->name('library_video_index');
        Route::get('library_audio_index/{library_audio_id}', [LibraryAudioContentController::class, 'show'])->name('library_audio_index');
        Route::get('library_kit_index/{library_kit_id}', [LibrarykitContentController::class, 'show'])->name('library_kit_index');
    });

    Route::prefix('report')->name('report.')->group(function () {
        Route::get('index', [ReportController::class, 'index'])->name('index');
    });

    Route::prefix('library_document_content')->name('library_document_content.')->group(function () {
        Route::get('show/{library_document_id}', [LibraryDocumentContentController::class, 'show'])->name('show');
    });


    Route::prefix('library_video')->name('library_video.')->group(function () {
        Route::get('index', [LibraryVideoController::class, 'index'])->name('index');
    });
    Route::prefix('library_video_content')->name('library_video_content.')->group(function () {
        Route::get('show/{library_video_id}', [LibraryVideoContentController::class, 'show'])->name('show');
    });

    Route::prefix('library_audio')->name('library_audio.')->group(function () {
        Route::get('index', [LibraryAudioController::class, 'index'])->name('index');
    });
    Route::prefix('library_audio_content')->name('library_audio_content.')->group(function () {
        Route::get('show/{library_audio_id}', [LibraryAudioContentController::class, 'show'])->name('show');
    });

    Route::prefix('library_kit')->name('library_kit.')->group(function () {
        Route::get('index', [LibraryKitController::class, 'index'])->name('index');
    });
    Route::prefix('library_kit_content')->name('library_kit_content.')->group(function () {
        Route::get('show/{library_kit_id}', [LibrarykitContentController::class, 'show'])->name('show');
    });
    Route::get('/download/{filename}', [ContentController::class, 'download'])->name('download');
    //update server commands
    Route::get('cmnd/{migrate}/{seed}', [MiscController::class, 'updateServer']);


    // Route::prefix('password')->name('password.')->group(function () {
    //     Route::post('update', [ResetPasswordController::class, 'reset'])->name('reset');
    // });
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('request', [UserCreationRequestController::class, 'userRequests'])->name('request');
        Route::get('index', [UserCreationRequestController::class, 'index'])->name('index');
        Route::get('regisered_index', [UserCreationRequestController::class, 'allRegisteredUserindex'])->name('regisered_index');
        Route::get('profile/{id}', [UserCreationRequestController::class, 'profile'])->name('profile');
        Route::put('update/{id}', [UserCreationRequestController::class, 'updateProfile'])->name('update');
        Route::get('deleted_user_index', [UserCreationRequestController::class, 'deleteUserIndex'])->name('deleted_user_index');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/{id}', [StudentController::class, 'studentProfile']);
    });
});



Route::group(['middleware' => ['DebugBarCheck'],'domain' => config('app.app_admin_domain')], function () {
    Auth::routes();
});




