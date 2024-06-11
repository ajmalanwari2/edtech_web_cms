<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use DataTables;
use App\Models\CourseContent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.course.index');
    }

    public function indexQuiz($course_id)
    {
        $course_id = $course_id;
        $references = CourseContent::where('course_id',$course_id)->get();
        // dd($references[0]->title);

        return view('pages.course.quiz_index', compact('course_id','references'));
    }

    public function list(Request $request){
        if ($request->ajax()) {

            $data = Course::latest()->get();
            $data = DB::select('
            SELECT
                c.id,
                c.number,
                c.updated_at,
                c.name,
                c.status,
                c.language,
                GROUP_CONCAT(DISTINCT cc.type SEPARATOR ", ") AS content_types
        FROM courses AS c
        LEFT JOIN course_contents AS cc ON c.id = cc.course_id
        GROUP BY c.id
        ORDER BY c.updated_at desc
            ');           
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('course_status', function ($row) {
                    if($row->status){
                        return 'Active'; 
                    }else{
                        return 'In active';
                    }
                  
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '
                    <div class="dropdown ml-auto">
                        <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#edit-modal-form">
                        <i class="material-icons">edit</i>Edit</a>
                        <a class="dropdown-item" onclick="loadRecord('.$row->id.')" href="javascript:void(0)" data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i> View</a>
                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm" 
                    onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i> Delete</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="'.route('course_content.show', $row->id).'"><i class="material-icons">add</i></i> Course Content</a>
                            <a class="dropdown-item" href="'.route('course.show', $row->id).'"><i class="material-icons">add</i></i> Add Quiz</a>
                        </div>
                    </div>
                    ';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
               
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //    \Log::info($request->all());
    //     try {
    //         if ($request->ajax()) 
    //         {
    //             DB::beginTransaction();
    //             $data = $request->input();
    //             $data['created_by'] = auth()->user()->id;
    //             $result = Course::create($data);
    //             DB::commit();  
    //                 if(!empty($result->id))
    //                 {
    //                     return response(['id' => $result->id], 201)
    //                     ->header('Content-Type', 'text/json');
    //                 }
    //         }         
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return redirect(route('subject.index'))->with('error',$e->getMessage());
    //     }
    // }

public function store(Request $request)
    {
        try {
            if ($request->ajax()) {
                DB::beginTransaction();
                $data = $request->all();
                for ($i=0; $i<$data['count'];  $i++) {

                    $item['created_by'] = auth()->user()->id;
                    $item['number'] = $data['number'.$i];
                    $item['name'] = $data['name'.$i];
                    $item['status'] =$data['status'.$i];
                    $item['total_quiz_time'] = $data['total_quiz_time'.$i];
                    $item['description'] = $data['description'.$i];
                    $item['language'] =$data['language'.$i];
                    $item['icon'] = 'N/A';
                    $result = Course::create($item);
                    DB::commit();
                    $rec = Course::find($result->id);
                    if (isset($data['icon'.$i]) && $data['icon'.$i] != 'undefined') {
                        $file1 = mulistoreFiles($request, ['icon'.$i],'course_icon' , $result->id . '-icon');
    
                        $file_name = explode('/', $file1['icon'.$i]);
    
                        if (empty($file1)) {
                            throw new \Exception('icon for course could not be uploaded');
                        } else {
    
                            //we will delete old file
    
                            $res = File::delete(base_path() .'/storage/app/public/uploads/course_icon/' .$rec->icon);
                            $rec->icon = end($file_name);
                        }
                    } 
                    $r = $rec->save();

                }

                DB::commit();

                return response(['success' => true], 201)
                    ->header('Content-Type', 'text/json');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('course.index'))->with('error', $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        if ($request->ajax()) {
            $course = Course::find($request->id);
    
            if ($course) {
                $course->course_status = $course->status ? 'Active' : 'In active'; 
    
                // Load the related contents for the chapter
                $course->loadContents();
    
                return response()->json($course, 200)
                ->header('Content-Type', 'text/json');
            }else{
                return response(['data' => null], 404)
                      ->header('Content-Type', 'text/json');
            }
    }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {

            $course = Course::find($request->id);
    
            // Check if the number has changed in the request
            if ($course->number !== $request->number) {
                $existingCourse = Course::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existingCourse) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }
            $course->number  = $request->number ;
            $course->name = $request->name;
            $course->status = $request->status;
            $course->language = $request->language;
            $course->total_quiz_time = $request->total_quiz_time;
            $course->description = $request->description;

            if (isset($request->icon) && $request->icon != 'undefined') {
                $file1 = mulistoreFiles($request, ['icon'], 'course_icon',  $request->id . '-icon');

              

                if (empty($file1)) {
                    throw new \Exception('icon for course could not be uploaded');
                } else {

                    $filePath = 'uploads/course_icon/'.$course->icon;
    
                    // Check if the file exists in the storage
                    if (Storage::disk('public')->exists($filePath)) {
                        // Delete the file
                        Storage::disk('public')->delete($filePath);
                        // File deleted successfully
                    }
                    
                    $file_name = explode('/', $file1['icon']);
                    $course->icon = end($file_name);
                }
            }

            $result = $course->save();
            if (!empty($result))
                return response([$result], 201)
                    ->header('Content-Type', 'text/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     */


    
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
           
            $courseContents = DB::table('course_contents')->where('course_id', $request->id)->get();
            foreach($courseContents as $courseContent){
              
                $filePath = str_replace('storage/', '', $courseContent->body);
 
                // Check if the file exists in the storage
                if (Storage::disk('public')->exists($filePath)) {
                    // Delete the file
                    Storage::disk('public')->delete($filePath);
                    // File deleted successfully
                }
                CourseContent::destroy($courseContent->id);
                }
                $result = Course::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }



    public function courseList(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        if ($user->last_seen === null) {
            $user->update(['last_seen' => date("Y-m-d H:i:s")]);
        } else {
            $user->update(['last_seen' => date("Y-m-d H:i:s")]);
        }

        $grade_language = NULL;
        if($user->role === 'student'){
        $language = Student::select('language')->where('user_id', $user_id)->get();
        $grade_language = $language && $language[0] ? $language[0]->language : NULL;
        if($user == NULL || $language == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
    }
    if($user->role === 'teacher'){
        $language = Teacher::select('language')->where('user_id', $user_id)->get();
        $grade_language = $language && $language[0] ? $language[0]->language : NULL;
        if($user == NULL || $language == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
    }
    if($grade_language && ($user->role === 'student' || $user->role === 'teacher')){
$courses = [];
$courses['course_language'] = '';
 if($grade_language === 'en'){
    $courses['course_language'] = 'English';
}elseif($grade_language === 'da'){
    $courses['course_language'] = 'دری';
}else{
    $courses['course_language'] = 'پشتو';
};
$courseCount = DB::select('select
    count(c.id) as course_count
    from courses as c
    where c.language = \''.$grade_language.'\'');

    $totalCourseLessons = DB::select('select
    count(c.id) as total_course_lessons
    from courses as c
    where c.language = \''.$grade_language.'\'');
    $courses['total_course_lessons'] = $totalCourseLessons[0]->total_course_lessons;

    $totalCoursePassedLessons = DB::select('select
    count(c.id) as total_course_passed_lessons
    from courses as c
    JOIN course_states AS cs ON c.id = cs.course_id and cs.user_id = '.$user_id.'
    where c.language = \''.$grade_language.'\'');
    $courses['total_course_passed_lessons'] = $totalCoursePassedLessons[0]->total_course_passed_lessons;
        $courses['courses'] = DB::select('select 
                        c.id,
                       c.name,
                       c.description,
                       c.state as course_state,
                       cb.state as bookmark_state,
                       CASE
                       WHEN c.icon != "" THEN CONCAT("storage/uploads/course_icon/", c.icon)
                   ELSE NULL
                   END AS course_icon,
                   (select count(cc.id) from course_contents as cc
                    where cc.course_id = c.id
                    and cc.type = \'video\') as video_count,
                    (select count(cc.id) from course_contents as cc
                    where cc.course_id = c.id
                    and cc.type = \'file\') as doc_count,
                    (select count(cc.id) from course_contents as cc
                    where cc.course_id = c.id
                    and cc.type = \'audio\') as audio_count
                    from courses as c
                    LEFT JOIN course_bookmarks AS cb ON c.id = cb.course_id AND cb.user_id = '.$user_id.'    
                    where c.language = \''.$grade_language.'\'');

                if($courses == []){
                    return response(['message' => 'No course is available'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($courses, 200);
                }

            }
            else{
                return response(['message' => 'The user is not registered as student/teacher'], 422)
                ->header('Content-Type', 'text/json');
            }      
    }



    public function courseContentList(Request $request){
        $course_id = $request->course_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if($user->role === 'student'){
        $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
        $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
        if($user == NULL || $grade_id == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
        $content = [];
                $course_contents = DB::select('
                        select
                            cc.title as content_title,
                            cc.type as content_type, 
                            cc.body as course_content_path,
                            cc.file_size
                        from course_contents as cc
                        where cc.course_id = '.$course_id .'');

                        $content['course_id'] = $course_id;
            $content['course_content'] = $course_contents;
                $startQuiz = DB::select('
                    select
                            count(cq.id) as total_question,
                            c.name as course_name,
                            c.total_quiz_time,
                            cs.state as quiz_status
                    from courses as c
                        left join course_quizes as cq
                            on c.id = cq.course_id
                    left join course_quiz_results as cqr
                        on c.id = cqr.course_id
                    LEFT JOIN course_states AS cs ON c.id = cs.course_id and cs.user_id = '.$user_id.'                      
                        WHERE c.id = ?
                        GROUP BY c.id, cqr.state', [$course_id]);

                    $content['course_title'] = $startQuiz[0]->course_name;
                    $content['total_quiz_time'] = $startQuiz[0]->total_quiz_time;
                    $content['total_question'] = $startQuiz[0]->total_question;
                    $content['quiz_status'] = $startQuiz[0]->quiz_status;

        $questions = DB::select('
        select
                q.id as question_id,
               q.question_text as question,
               CASE
                    WHEN q.question_image != "" THEN CONCAT("storage/uploads/q_image/", q.question_image)
                ELSE NULL
                END AS question_image,
               q.option_a_text as optiona,
               CASE
                    WHEN q.option_a_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_a_image)
                ELSE NULL
                END AS option_a_image,
               q.option_b_text as optionb,
               CASE
               WHEN q.option_b_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_b_image)
           ELSE NULL
           END AS option_b_image,
               CASE
               WHEN q.option_b_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_b_image)
           ELSE NULL
           END AS option_a_image,
               q.option_b_text as optionc,
               CASE
               WHEN q.option_c_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_c_image)
           ELSE NULL
           END AS option_c_image,
               q.option_d_text as optiond,
               CASE
               WHEN q.option_d_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_d_image)
           ELSE NULL
           END AS option_d_image,
               q.correct_answer,
               q.references
        from courses as c  
            left join course_quizes as q
                on c.id = q.course_id      
        where  c.id = ?', [$course_id]);
      
        if (!empty($questions)) {
            foreach ($questions as $q) {
                if ($q->question_id !== null) {
                    $q->references = CourseContent::select('title', 'type', 'body', 'file_size')->whereIn('id', explode(',', $q->references))->get();
                    $content['course_quiz_questions'][] = $q;
                } else {
                    $content['course_quiz_questions'] = [];
                }
            }
        }
              
                    $quizAnswers = DB::select('select 
                                    qa.question_id,
                                    qa.answer
                                from course_quiz_answers as qa    
                                left join course_quizes as q
                                    on q.id = qa.question_id
                                left join courses as c
                                    on c.id = q.course_id
                                where c.id = '.$course_id .'');
                                $content['answers'] = $quizAnswers;
               


        if($content == []){
            return response(['message' => 'The student is not registered'], 422)
                ->header('Content-Type', 'text/json');
        }else{
            return response()->json($content, 200);
        }

    } else if($user->role === 'teacher'){

        $content = [];
        $course_contents = DB::select('
                select
                    cc.title as content_title,
                    cc.type as content_type, 
                    cc.body as course_content_path,
                    cc.file_size
                from course_contents as cc
                where cc.course_id = '.$course_id .'');

                $content['course_id'] = $course_id;
    $content['course_content'] = $course_contents;
if($content == []){
    return response(['message' => 'The teacher is not registered'], 422)
        ->header('Content-Type', 'text/json');
}else{
    return response()->json($content, 200);
}

    }
 }

   



    
}