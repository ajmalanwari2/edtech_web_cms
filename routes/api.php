<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\LibraryDocumentContentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LibraryDocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibraryVideoController;
use App\Http\Controllers\LibraryAudioController;
use App\Http\Controllers\LibraryKitController;
use App\Http\Controllers\LibraryVideoContentController;
use App\Http\Controllers\LibraryAudioContentController;
use App\Http\Controllers\LibraryKitContentController;
use App\Http\Controllers\CourseQuizController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CourseBookmarkController;
use App\Http\Controllers\LibraryDocumentBookmarkController;
use App\Http\Controllers\LibraryVideoBookmarkController;
use App\Http\Controllers\LibraryAudioBookmarkController;
use App\Http\Controllers\LibraryKitBookmarkController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['domain' => config('app.app_admin_domain')], function () {
    Route::get('student-list-based-on-district/{district_id}', [StudentController::class, 'getStudentList']);
    Route::get('start-quiz/subject_id',[QuizController::class, 'startQuizMobile']);
    
    Route::get('provinces', [ProvinceController::class, 'getProvinces']);
    Route::get('districts', [DistrictController::class, 'getDistricts']);
    Route::get('schools', [SchoolController::class, 'getSchools']);
    
    Route::get('districts-based-on-province/{province_id}', [DistrictController::class, 'getDistrictsThroughProvinceMobile']);
    Route::get('provinces-based-on-rmo/{rmo_id}', [DistrictController::class, 'getProvinceThroughRMOMobile']);
    Route::get('schools-based-on-district/{district_id}', [DistrictController::class, 'getSchoolThroughDistrictMobile']);
    Route::get('grades-based-on-school/{school_id}', [DistrictController::class, 'getGradeThroughSchoolMobile']);
    Route::get('grades-based-on-language/{language}', [DistrictController::class, 'getGradesThroughLanguageMobile']);
    
    Route::post('token', [AuthController::class, 'requestToken']);
    Route::post('/forgot-password', [AuthController::class,'resetPassword'])->middleware('guest');

    Route::group(['prefix' => 'request'], function () {
        Route::post('list',[UserCreationRequestController::class, 'list']);
        Route::post('save',[UserCreationRequestController::class, 'store']);
        Route::post('show',[UserCreationRequestController::class, 'show']);
        Route::post('update',[UserCreationRequestController::class, 'update']);
        Route::post('approve',[UserCreationRequestController::class, 'approve']);
        Route::post('reject',[UserCreationRequestController::class, 'reject']);
    });
});
    
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});
 // mobile App APIs
//  Route::delete('delete-answer-data', [QuizController::class, 'deleteQuizData']);
//  Route::delete('delete-course-answer-data', [CourseQuizController::class, 'deleteCourseQuizData']);
Route::group(['middleware'=> 'auth:sanctum','domain' => config('app.app_admin_domain')], function () {
    Route::get('user-profile', [UserCreationRequestController::class, 'userProfile']);
    Route::post('user-profile-update',[UserCreationRequestController::class, 'updateUserProfile']);
    Route::post('user-profile-image',[UserCreationRequestController::class, 'userProfileImage']);
    Route::post('user-password-update',[UserCreationRequestController::class, 'userPasswordUpdate']);
    Route::get('student-subjects',[StudentController::class, 'studentSubject']);
    Route::get('subject-list',[StudentController::class, 'studentSubjectList']);
    Route::get('subject-chapter-list/{subject_id}',[StudentController::class, 'studentSubjectChapterList']);
    Route::get('subject-chapter-content-list/{chapter_id}',[StudentController::class, 'studentChapterContentList']);
    Route::post('sync-user', [UserCreationRequestController::class, 'syncUser']);
    Route::post('inactive-user', [UserCreationRequestController::class, 'inactiveUser']);
    Route::post('contact', [UserCreationRequestController::class, 'contact']);

    //notices
    Route::get('notice-list',[NoticeController::class, 'noticeList']);
    Route::post('read-notice', [NoticeController::class, 'readNotice']);

    //teacher
    Route::get('teacher-grade-list',[TeacherController::class, 'teacherGradeList']);
    Route::get('grade-subject-list/{grade_id}',[TeacherController::class, 'gradeSubjectList']);

    //parent
    Route::get('parent-analysis',[StudentParentController::class, 'parentAnalysis']);
      //teacher
    Route::get('teacher-analysis',[TeacherController::class, 'teacherAnalysis']);

    //Quiz
    Route::post('submit-quiz', [QuizController::class, 'submitQuizQuesAnswareMobile']);
    Route::get('quiz-answers/{chapter_id}',[QuizController::class, 'quizAnswers']);

    //Bookmark
    Route::get('bookmark-list',[BookmarkController::class, 'bookmarkList']);
    Route::post('submit-bookmark', [BookmarkController::class, 'update']);

    //course Bookmark
    Route::get('course-bookmark-list',[CourseBookmarkController::class, 'bookmarkList']);
    Route::post('submit-course-bookmark', [CourseBookmarkController::class, 'update']);

  //Library Bookmarks
     Route::get('library-document-bookmark-list',[LibraryDocumentBookmarkController::class, 'bookmarkList']);
     Route::post('submit-library-document-bookmark', [LibraryDocumentBookmarkController::class, 'update']);
     Route::get('library-video-bookmark-list',[LibraryVideoBookmarkController::class, 'bookmarkList']);
     Route::post('submit-library-video-bookmark', [LibraryVideoBookmarkController::class, 'update']);
     Route::get('library-audio-bookmark-list',[LibraryAudioBookmarkController::class, 'bookmarkList']);
     Route::post('submit-library-audio-bookmark', [LibraryAudioBookmarkController::class, 'update']);
     Route::get('library-kit-bookmark-list',[LibraryKitBookmarkController::class, 'bookmarkList']);
     Route::post('submit-library-kit-bookmark', [LibraryKitBookmarkController::class, 'update']);

    //courses API
    Route::get('course-list',[CourseController::class, 'courseList']);
    Route::get('course-content-list/{course_id}',[CourseController::class, 'courseContentList']);

    Route::post('submit-course-quiz', [CourseQuizController::class, 'submitCourseQuizQuesAnswareMobile']);
    Route::get('course-quiz-answers/{course_id}',[CourseQuizController::class, 'courseQuizAnswers']);


    //Game API
    Route::get('game-list',[GameController::class, 'gameList']);
    //RMO List as per province

    Route::get('rmo-based-on-province/{province_id}', [RegionalManagementOfficeController::class, 'getRMOThroughProvince']);

    // Library
    Route::get('library-quran-karim',[LibraryDocumentController::class, 'libraryQuranKarim']);
    Route::get('library-document-list',[LibraryDocumentController::class, 'libraryDocumentList']);
    Route::get('library-document-contents/{library_document_id}',[LibraryDocumentController::class, 'libraryDocumentContent']);
    Route::get('library-video-list',[LibraryVideoController::class, 'libraryVideoList']);
    Route::get('library-video-contents/{library_video_id}',[LibraryVideoController::class, 'libraryVideoContent']);
    Route::get('library-audio-list',[LibraryAudioController::class, 'libraryAudioList']);
    Route::get('library-audio-contents/{library_audio_id}',[LibraryAudioController::class, 'libraryAudioContent']);
    Route::get('library-kit-list',[LibraryKitController::class, 'libraryKitList']);
    Route::get('library-kit-contents/{library_kit_id}',[LibraryKitController::class, 'libraryKitContent']);

});

//delete all tokens of the user
Route::middleware('auth:sanctum')->post('delete-token', [AuthController::class, 'delete_tokens']);



Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});
// end of mobile APP APIs

Route::group(['prefix' => 'auth', 'domain' => config('app.app_admin_domain')], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::group(['middleware' => 'auth:sanctum','domain' => config('app.app_admin_domain')], function() {
    Route::group(['prefix' => 'student'], function () {
        Route::post('list',[StudentController::class, 'list']);
        Route::post('save',[StudentController::class, 'store']);
        Route::post('show',[StudentController::class, 'show']);
        Route::post('update',[StudentController::class, 'update']);
        Route::post('delete',[StudentController::class, 'destroy']);
    });

    Route::group(['prefix' => 'teacher'], function () {
        Route::post('list',[TeacherController::class, 'list']);
        Route::post('save',[TeacherController::class, 'store']);
        Route::post('show',[TeacherController::class, 'show']);
        Route::post('update',[TeacherController::class, 'update']);
        Route::post('delete',[TeacherController::class, 'destroy']);
    });

    Route::group(['prefix' => 'parent'], function () {
        Route::post('list',[StudentParentController::class, 'list']);
        Route::post('save',[StudentParentController::class, 'store']);
        Route::post('show',[StudentParentController::class, 'show']);
        Route::post('update',[StudentParentController::class, 'update']);
        Route::post('delete',[StudentParentController::class, 'destroy']);
    });

    Route::group(['prefix' => 'rmo'], function () {
        Route::post('list',[RegionalManagementOfficeController::class, 'list']);
        Route::post('save',[RegionalManagementOfficeController::class, 'store']);
        Route::post('show',[RegionalManagementOfficeController::class, 'show']);
        Route::post('update',[RegionalManagementOfficeController::class, 'update']);
        Route::post('delete',[RegionalManagementOfficeController::class, 'destroy']);
    });

    
    Route::group(['prefix' => 'dashboard'], function () {
        Route::post('list',[DashboardController::class, 'list']);
        Route::post('student-list',[DashboardController::class, 'studentList']);
        Route::post('teacher-list',[DashboardController::class, 'teacherList']);
        Route::post('parent-list',[DashboardController::class, 'parentList']);
        Route::post('sync-users-list',[DashboardController::class, 'syncUserList']);
        Route::post('unsync-users-list',[DashboardController::class, 'unSyncUserList']);
        Route::post('index',[DashboardController::class, 'getJsonData']);
        Route::post('library',[DashboardController::class, 'getLibraryJsonData']);
        Route::post('subject-list',[DashboardController::class, 'subjectList']);
        Route::post('course-list',[DashboardController::class, 'courseList']);
        Route::post('grade-list',[DashboardController::class, 'gradeList']);
        Route::post('grade-lessons-list',[DashboardController::class, 'gradLessonslist']);
        Route::post('grade-student-list',[DashboardController::class, 'gradStudentlist']);
        Route::post('grade-teacher-list',[DashboardController::class, 'gradTeacherlist']);
        Route::post('grade-parent-list',[DashboardController::class, 'gradParentlist']);
    });

    Route::group(['prefix' => 'province'], function () {
        Route::post('list',[ProvinceController::class, 'list']);
        Route::post('save',[ProvinceController::class, 'store']);
        Route::post('show',[ProvinceController::class, 'show']);
        Route::post('update',[ProvinceController::class, 'update']);
        Route::post('delete',[ProvinceController::class, 'destroy']);
    });

    Route::group(['prefix' => 'district'], function () {
        Route::post('list',[DistrictController::class, 'list']);
        Route::post('save',[DistrictController::class, 'store']);
        Route::post('show',[DistrictController::class, 'show']);
        Route::post('update',[DistrictController::class, 'update']);
        Route::post('delete',[DistrictController::class, 'destroy']);
    });

    Route::group(['prefix' => 'school'], function () {
        Route::post('list',[SchoolController::class, 'list']);
        Route::post('save',[SchoolController::class, 'store']);
        Route::post('show',[SchoolController::class, 'show']);
        Route::post('update',[SchoolController::class, 'update']);
        Route::post('delete',[SchoolController::class, 'destroy']);
    });

    Route::group(['prefix' => 'notice'], function () {
        Route::post('list',[NoticeController::class, 'list']);
        Route::post('save',[NoticeController::class, 'store']);
        Route::post('show',[NoticeController::class, 'show']);
        Route::post('update',[NoticeController::class, 'update']);
        Route::post('delete',[NoticeController::class, 'destroy']);
    });

    Route::group(['prefix' => 'news'], function () {
        Route::post('list',[NewsController::class, 'list']);
        Route::post('save',[NewsController::class, 'store']);
        Route::post('show',[NewsController::class, 'show']);
        Route::post('update',[NewsController::class, 'update']);
        Route::post('delete',[NewsController::class, 'destroy']);
    });

    Route::group(['prefix' => 'game'], function () {
        Route::post('list',[GameController::class, 'list']);
        Route::post('save',[GameController::class, 'store']);
        Route::post('show',[GameController::class, 'show']);
        Route::post('update',[GameController::class, 'update']);
        Route::post('delete',[GameController::class, 'destroy']);
    });

    Route::group(['prefix' => 'feedback'], function () {
        Route::post('list',[FeedbackController::class, 'list']);
        Route::post('show',[FeedbackController::class, 'show']);
    });

    Route::group(['prefix' => 'grade'], function () {
        Route::post('list',[GradeController::class, 'list']);
        Route::post('save',[GradeController::class, 'store']);
        Route::post('show',[GradeController::class, 'show']);
        Route::post('update',[GradeController::class, 'update']);
        Route::post('delete',[GradeController::class, 'destroy']);
        Route::post('subject_list',[GradeController::class, 'subject_list']);
    });

    Route::group(['prefix' => 'subject'], function () {
        Route::post('list',[SubjectController::class, 'list']);
        Route::post('save',[SubjectController::class, 'store']);
        Route::post('show',[SubjectController::class, 'show']);
        Route::post('update',[SubjectController::class, 'update']);
        Route::post('delete',[SubjectController::class, 'destroy']);
        Route::post('content_list',[SubjectController::class, 'content_list']);
    });

    Route::group(['prefix' => 'chapter'], function () {
        Route::post('list',[ChapterController::class, 'list']);
        Route::post('save',[ChapterController::class, 'store']);
        Route::post('show',[ChapterController::class, 'show']);
        Route::post('update',[ChapterController::class, 'update']);
        Route::post('delete',[ChapterController::class, 'destroy']);
    });

    Route::group(['prefix' => 'content'], function () {
        Route::post('list',[ContentController::class, 'list']);
        Route::post('save',[ContentController::class, 'store']);
        Route::post('show',[ContentController::class, 'show']);
        Route::post('content-show',[ContentController::class, 'showContent']);
        Route::post('update',[ContentController::class, 'update']);
        Route::post('delete',[ContentController::class, 'destroy']);
    });


    Route::group(['prefix' => 'course'], function () {
        Route::post('list',[CourseController::class, 'list']);
        Route::post('save',[CourseController::class, 'store']);
        Route::post('show',[CourseController::class, 'show']);
        Route::post('update',[CourseController::class, 'update']);
        Route::post('delete',[CourseController::class, 'destroy']);
    });

    Route::group(['prefix' => 'course_content'], function () {
        Route::post('list',[CourseContentController::class, 'list']);
        Route::post('save',[CourseContentController::class, 'store']);
        Route::post('show',[CourseContentController::class, 'show']);
        Route::post('course-content-show',[CourseContentController::class, 'showCourseContent']);
        Route::post('update',[CourseContentController::class, 'update']);
        Route::post('delete',[CourseContentController::class, 'destroy']);
    });

    Route::group(['prefix' => 'course_quiz'], function () {
        Route::post('list',[CourseQuizController::class, 'list']);
        Route::post('save',[CourseQuizController::class, 'store']);
        Route::post('show',[CourseQuizController::class, 'show']);
        Route::post('update',[CourseQuizController::class, 'edit']);
        Route::post('delete',[CourseQuizController::class, 'destroy']);
        Route::post('store_images',[CourseQuizController::class, 'storeImages']);
    });

    Route::group(['prefix' => 'library_document'], function () {
        Route::post('list',[LibraryDocumentController::class, 'list']);
        Route::post('save',[LibraryDocumentController::class, 'store']);
        Route::post('show',[LibraryDocumentController::class, 'show']);
        Route::post('update',[LibraryDocumentController::class, 'update']);
        Route::post('delete',[LibraryDocumentController::class, 'destroy']);
    });

    Route::group(['prefix' => 'library_document_content'], function () {
        Route::post('list',[LibraryDocumentContentController::class, 'list']);
        Route::post('save',[LibraryDocumentContentController::class, 'store']);
        Route::post('show',[LibraryDocumentContentController::class, 'show']);
        Route::post('library-document-content-show',[LibraryDocumentContentController::class, 'showLibraryDocumentContent']);
        Route::post('update',[LibraryDocumentContentController::class, 'update']);
        Route::post('delete',[LibraryDocumentContentController::class, 'destroy']);
    });

    Route::group(['prefix' => 'library_video'], function () {
        Route::post('list',[LibraryVideoController::class, 'list']);
        Route::post('save',[LibraryVideoController::class, 'store']);
        Route::post('show',[LibraryVideoController::class, 'show']);
        Route::post('update',[LibraryVideoController::class, 'update']);
        Route::post('delete',[LibraryVideoController::class, 'destroy']);
    });

    Route::group(['prefix' => 'library_video_content'], function () {
        Route::post('list',[LibraryVideoContentController::class, 'list']);
        Route::post('save',[LibraryVideoContentController::class, 'store']);
        Route::post('show',[LibraryVideoContentController::class, 'show']);
        Route::post('library-video-content-show',[LibraryVideoContentController::class, 'showLibraryVideoContent']);
        Route::post('update',[LibraryVideoContentController::class, 'update']);
        Route::post('delete',[LibraryVideoContentController::class, 'destroy']);
    });

    Route::group(['prefix' => 'library_audio'], function () {
        Route::post('list',[LibraryAudioController::class, 'list']);
        Route::post('save',[LibraryAudioController::class, 'store']);
        Route::post('show',[LibraryAudioController::class, 'show']);
        Route::post('update',[LibraryAudioController::class, 'update']);
        Route::post('delete',[LibraryAudioController::class, 'destroy']);
    });

    Route::group(['prefix' => 'library_audio_content'], function () {
        Route::post('list',[LibraryAudioContentController::class, 'list']);
        Route::post('save',[LibraryAudioContentController::class, 'store']);
        Route::post('show',[LibraryAudioContentController::class, 'show']);
        Route::post('library-audio-content-show',[LibraryAudioContentController::class, 'showLibraryAudioContent']);
        Route::post('update',[LibraryAudioContentController::class, 'update']);
        Route::post('delete',[LibraryAudioContentController::class, 'destroy']);
    });

    Route::group(['prefix' => 'library_kit'], function () {
        Route::post('list',[LibraryKitController::class, 'list']);
        Route::post('save',[LibraryKitController::class, 'store']);
        Route::post('show',[LibraryKitController::class, 'show']);
        Route::post('update',[LibraryKitController::class, 'update']);
        Route::post('delete',[LibraryKitController::class, 'destroy']);
    });

    Route::group(['prefix' => 'library_kit_content'], function () {
        Route::post('list',[LibraryKitContentController::class, 'list']);
        Route::post('save',[LibraryKitContentController::class, 'store']);
        Route::post('show',[LibraryKitContentController::class, 'show']);
        Route::post('library-kit-content-show',[LibraryKitContentController::class, 'showLibraryKitContent']);
        Route::post('update',[LibraryKitContentController::class, 'update']);
        Route::post('delete',[LibraryKitContentController::class, 'destroy']);
    });

    Route::group(['prefix' => 'quiz'], function () {
        Route::post('list',[QuizController::class, 'list']);
        Route::post('save',[QuizController::class, 'store']);
        Route::post('show',[QuizController::class, 'show']);
        Route::post('update',[QuizController::class, 'edit']);
        Route::post('delete',[QuizController::class, 'destroy']);
        Route::post('store_images',[QuizController::class, 'storeImages']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::post('list',[UserCreationRequestController::class, 'allRegisteredUserList']);
        Route::post('save',[UserCreationRequestController::class, 'addNewUser']);
        Route::post('show',[UserCreationRequestController::class, 'registeredUserShow']);
        Route::post('update',[UserCreationRequestController::class, 'updateRegisteredUser']);
        Route::post('approve',[UserCreationRequestController::class, 'approve']);
        Route::post('reject',[UserCreationRequestController::class, 'reject']);
        Route::post('delete',[UserCreationRequestController::class, 'destroy']);
    });


});

Route::get('grade/videos/{grade_id}',[HomeController::class, 'loadGradeVideos']);