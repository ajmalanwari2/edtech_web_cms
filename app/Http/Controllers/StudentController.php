<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Province;
use App\Models\District;
use App\Models\School;
use App\Models\Grade;
use App\Models\User;
use App\Models\Content;
use App\Models\StudentTrackingChapter;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource with view.
     */
    public function index()
    {
        $provinces = Province::all();
        $districts = District::all();
        $schools = School::all();
        $grades = Grade::all();
        return view('pages.student.index', compact('provinces', 'districts', 'schools', 'grades' ));
    }
    /**
     * Display a listing of the resource as json .
     */
    public function list(Request $request){
        if ($request->ajax()) {
            $data = Student::with('province', 'school', 'user')->latest()->get();   
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('province', function($row){
                    return $row->province ? $row->province->name : '';
                })
                ->addColumn('school', function($row){
                    return $row->school ? $row->school->name : '';
                })
                ->addColumn('name', function($row){
                    return $row->user ? $row->user->name : '';
                })
                ->addColumn('email', function($row){
                    return $row->user ? $row->user->email : '';
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#modal-form">
                    <i class="material-icons">edit</i></i></a> <a onclick="loadRecord('.$row->id.')" href="javascript:void(0)" 
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }


    // public function list(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Student::latest()->get();
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('created_at', function ($row) {
    //                 if($row->created_at){
    //                     return date("Y-m-d ", strtotime($row->created_at));
    //                 }else{
    //                     return '';
    //                 }
    //             })
    //             ->addColumn('updated_at', function ($row) {
    //                 if($row->updated_at){
    //                     return date("Y-m-d ", strtotime($row->updated_at));
    //                 }else{
    //                     return '';
    //                 }
    //             })
    //             ->addColumn('action', function ($row) {
    //                 $actionBtn = '<a onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#modal-form">
    //                 <i class="material-icons">edit</i></i></a> <a onclick="loadRecord('.$row->id.')" href="javascript:void(0)" 
    //                 data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>
    //                 <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm" 
    //                 onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i></a>';
    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $result = Student::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'created_at' => date("Y-m-d H:i:s")
            ]);
            if (!empty($result->id))
                return response(['id' => $result->id], 201)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }

    /**
     * Store a newly created resource in storage.
     */

     
    public function store(Request $request)
    {
        try {
            if ($request->ajax()) {
                DB::beginTransaction();
                $user = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'student'
                ];
                $user_id = User::create($user)->id;
                    $student = [
                        'phone_no' => $request->phone_no,
                        'user_id' => $user_id,
                        'student_parent_id' => $request->student_parent_id,
                        'province_id' => $request->province_id,
                        'district_id' => $request->district_id,
                        'school_id' => $request->school_id,
                        'grade_id' => $request->grade_id,
                    ];
                    Student::create($student);


                    $mail_data = [
                        'recipient' =>  $request->email,
                        'fromEmail' => 'aanwari02@gmail.com',
                        'fromName' => 'Email creation',
                        'subject' => 'Email created',
                        'body' => 'Email message'
                    ];
                    \Mail::send('email-template', $mail_data, function($message) use ($mail_data){
                        $message->to($mail_data['recipient'])
                        ->from($mail_data['fromEmail'], $mail_data['fromName'])
                        ->subject($mail_data['subject']);
                    });
                       
                    
                DB::commit();  
                if (!empty($user_id))
                return response(['id' => $user_id], 201)
                    ->header('Content-Type', 'text/json');
            else
                return response([$user_id], 400)
                    ->header('Content-Type', 'text/json');
            }
            } catch (Exception $e) {
                DB::rollBack();
                return redirect(route('student.index'))->with('error',$e->getMessage());
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $student = Student::find($request->id);
            if (!empty($student->id))
                return response($student, 200)
                    ->header('Content-Type', 'text/json');
        } else {
            return response(['data' => null], 404)
                ->header('Content-Type', 'text/json');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $student = Student::find($request->id);
            $student->name = $request->name;
            $student->last_name = $request->last_name;
            $student->email = $request->email;
            $student->updated_at = date("Y-m-d H:i:s");
            $result = $student->save();

            if (!empty($result))
                return response([$result], 201)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $result = Student::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }
    // public function emailCheck(){
    //     $mail_data = [
    //         'recipient' =>  'aanwari02@gmail.com',
    //         'fromEmail' => 'elearningedtech02@gmail.com',
    //         'fromName' => 'Email creation',
    //         'subject' => 'Email created',
    //         'body' => 'Email message'
    //     ];
    //     \Mail::send('email-template', $mail_data, function($message) use ($mail_data){
    //         $message->to($mail_data['recipient'])
    //         ->from($mail_data['fromEmail'], $mail_data['fromName'])
    //         ->subject($mail_data['subject']);

    //     });
           
    // }


    public function studentSubjectList(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        if ($user->last_seen === null) {
            $user->update(['last_seen' => date("Y-m-d H:i:s")]);
        } else {
            $user->update(['last_seen' => date("Y-m-d H:i:s")]);
        }
        if($user->role === 'student'){
        $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
        $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
        if($user == NULL || $grade_id == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
        
        $grade = DB::select('
SELECT
name AS grade_name,
CASE
    WHEN language = "en" THEN "English"
    WHEN language = "da" THEN "Dari"
    ELSE "Pashto"
END AS grade_language
FROM
grades
where id = '.$grade_id.'
');
$subjectCount = DB::select('
        select 
            count(s.id) as subject_count
        from subjects as s
        join subjects_in_grades as sig
            on s.id = sig.subject_id
        where sig.grade_id = '.$grade_id.'        
    ');

$totalGradeLessons = DB::select('
select
    count(ch.id) as total_grade_lessons
from chapters as ch
join subjects as s
on s.id = ch.subject_id
join subjects_in_grades as sig
on s.id = sig.subject_id
join grades as g
on g.id = sig.grade_id
where sig.grade_id = '.$grade_id.';
');

$totalGradePassedLessons = DB::select('
select
	count(ch.id) as total_grade_passed_lessons
from chapters as ch
JOIN chapter_states AS cs ON ch.id = cs.chapter_id and cs.user_id = '.$user_id.'
join subjects as s
on s.id = ch.subject_id
join subjects_in_grades as sig
on s.id = sig.subject_id
join grades as g
on g.id = sig.grade_id
WHERE sig.grade_id = '.$grade_id.';
');

$subjects = [];
$subjects['grade_name'] = $grade[0]->grade_name;
$subjects['grade_language'] = $grade[0]->grade_language;
$subjects['subject_count'] = $subjectCount[0]->subject_count;
$subjects['total_grade_lessons'] = $totalGradeLessons[0]->total_grade_lessons;
$subjects['total_grade_passed_lessons'] = $totalGradePassedLessons[0]->total_grade_passed_lessons;
        $subjects['subjects'] = DB::select('select 
        sub.id as subject_id,
                       sub.name as subject_name,
                       CASE
                       WHEN sub.icon != "" THEN CONCAT("storage/uploads/icon/", sub.icon)
                   ELSE NULL
                   END AS subject_icon,
                   (select count(sl.id) from subject_lessons as sl
        join chapters as ch
        on ch.id = sl.chapter_id
        where ch.subject_id = sub.id
        and sl.type = \'video\') as video_count,
           (select count(sl.id) from subject_lessons as sl
        join chapters as ch
        on ch.id = sl.chapter_id
        where ch.subject_id = sub.id
        and sl.type = \'file\') as doc_count,
           (select count(sl.id) from subject_lessons as sl
        join chapters as ch
        on ch.id = sl.chapter_id
        where ch.subject_id = sub.id
        and sl.type = \'audio\') as audio_count,
        (select
        count(ch.id) 
    from chapters as ch
    where ch.subject_id = sub.id) as total_subject_lessons,
    (select
    count(ch.id)
from chapters as ch
where ch.subject_id = sub.id
and ch.id in (select chapter_id from chapter_states where user_id = '.$user_id.' )) as total_subject_passed_lessons
                    from users as u
                       left join students as s
                       on u.id = s.user_id
                       left join schools as sh
                       on sh.id = s.school_id
                       left join grades as g
                       on g.id = s.grade_id
                       left join subjects_in_grades as sig
                           on g.id = sig.grade_id
                       left join subjects as sub
                           on sub.id = sig.subject_id
                   where u.id = '.$user_id .'
                   and s.grade_id = '.$grade_id.'');

                if($subjects == []){
                    return response(['message' => 'The student is not registered'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($subjects, 200);
                }

            }
            else{
                return response(['message' => 'The user is not registered as student'], 422)
                ->header('Content-Type', 'text/json');
            }      

    }




    public function studentSubjectChapterList(Request $request){
        $subject_id = $request->subject_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
        $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
        if($user == NULL || $grade_id == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }

        $grade = DB::select('
        SELECT
        s.name AS subject_name,
        CASE
            WHEN g.language = "en" THEN "English"
            WHEN g.language = "da" THEN "Dari"
            ELSE "Pashto"
        END AS grade_language
        FROM
        grades as g
        join subjects_in_grades as sig
        on g.id = sig.grade_id
        join subjects as s
        on s.id = sig.subject_id
        where sig.grade_id = '.$grade_id.'
        AND sig.subject_id = '.$subject_id.'
        ');
     
        $subjectCount = DB::select('
        select 
            count(c.id) as lessons_count
        from chapters as c
        where c.subject_id = '.$subject_id.'        
    ');

    $chapters = [];
$chapters['subject_name'] = $grade[0]->subject_name;
$chapters['grade_language'] = $grade[0]->grade_language;
$chapters['lesson_count'] = $subjectCount[0]->lessons_count;


        $chapters['lessons'] = DB::select('SELECT DISTINCT
        c.id AS chapter_id,
        c.name AS chapter_name,
        c.subject_id,
        cs.state AS chapter_state,
        COALESCE(b.state, 0) AS bookmark_state,
        (
            SELECT COUNT(q.id)
            FROM quizes AS q 
            WHERE q.chapter_id = c.id
        ) AS quiz_count,
        (
            SELECT COUNT(sll.id)
            FROM subject_lessons AS sll
            WHERE sll.type = \'video\' AND sll.chapter_id = c.id
        ) AS video_lesson_count,
        (
            SELECT COUNT(sll.id)
            FROM subject_lessons AS sll
            WHERE sll.type = \'audio\' AND sll.chapter_id = c.id
        ) AS audio_lesson_count,
        (
            SELECT COUNT(sll.id)
            FROM subject_lessons AS sll
            WHERE sll.type = \'file\' AND sll.chapter_id = c.id
        ) AS file_lesson_count
    FROM
        users AS u
        LEFT JOIN students AS s ON u.id = s.user_id
        LEFT JOIN schools AS sh ON sh.id = s.school_id
        LEFT JOIN grades AS g ON g.id = s.grade_id
        LEFT JOIN subjects_in_grades AS sig ON g.id = sig.grade_id
        LEFT JOIN subjects AS sub ON sub.id = sig.subject_id
        LEFT JOIN chapters AS c ON sub.id = c.subject_id
        LEFT JOIN chapter_states AS cs ON c.id = cs.chapter_id and cs.user_id = '.$user_id.'
        left join bookmarks as b on c.id = b.chapter_id and b.state = \'1\' and b.user_id = '.$user_id.'
    WHERE
        c.subject_id = '.$subject_id.'
        AND sig.grade_id = '.$grade_id.'
        AND u.id = '.$user_id .'');

                                //    $updatedChapters = [];

                            //   foreach ($chapters as $chapter) {
                            //         $count = DB::select('select 
                            //             count(sl.id) as chapter_content_count
                            //             from subject_lessons as sl
                            //             where sl.chapter_id = '.$chapter->chapter_id.'');
                                    
                            //         $chapter->chapter_content_count = $count[0]->chapter_content_count;
                                    
                            //         $updatedChapters[] = $chapter;
                            //     }
$chapters['textbook'] = DB::select('select
    ldc.title as document_title,
    ldc.body as document_content_path
    from library_document_contents as ldc
    join library_documents as ld
    on ld.id = ldc.library_document_id
    where ld.subject_id = '.$subject_id.'
    and ldc.is_main = \'1\'');
                                if (empty($chapters)) {
                                    return response(['message' => 'This subject dont have any chapter'], 422)
                                        ->header('Content-Type', 'text/json');
                                } else {
                                    return response()->json($chapters, 200);
}

    }



    public function studentChapterContentList(Request $request){
        $chapter_id = $request->chapter_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
        $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
        if($user == NULL || $grade_id == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
        $data = [
            'student_id' => $user_id,
            'chapter_id' => $chapter_id,
            'chapter_start_date' => date("Y-m-d H:i:s"),
            'chapter_end_date' => NULL,
        ];
        $res = StudentTrackingChapter::create($data);

        if ($user->last_seen === null) {
            $user->update(['last_seen' => date("Y-m-d H:i:s")]);
        } else {
            $user->update(['last_seen' => date("Y-m-d H:i:s")]);
        }

        $content = [];
        $grade = DB::select('
        SELECT
        ch.name AS chapter_name,
        CASE
            WHEN g.language = "en" THEN "English"
            WHEN g.language = "da" THEN "Dari"
            ELSE "Pashto"
        END AS grade_language
        FROM
        grades as g
        join subjects_in_grades as sig
        on g.id = sig.grade_id
        join subjects as s
        on s.id = sig.subject_id
        join chapters as ch
        on s.id = ch.subject_id
        where ch.id = '.$chapter_id.'
        ');
     
        $ContentCount = DB::select('
        select 
            count(sl.id) as content_count
        from subject_lessons as sl
        where sl.chapter_id = '.$chapter_id.'        
    ');

$content['chapter_name'] = $grade[0]->chapter_name;
$content['grade_language'] = $grade[0]->grade_language;
$content['lesson_count'] = $ContentCount[0]->content_count;
        
                $chapterContents = DB::select('
                        select
                            sl.title as content_title,
                            sl.type as content_type, 
                            sl.body as chapter_content_path
                        from subject_lessons as sl
                        where sl.chapter_id = '.$chapter_id .'');

                        $content['chapter_id'] = $chapter_id;
            $content['chapter_content'] = $chapterContents;
                $startQuiz = DB::select('
                    select
                    (select count(q.id)
                    from quizes as q
                where c.id = q.chapter_id) as total_question,
                            c.total_quiz_time,
                            s.name as subject,
                            cs.state as quiz_status
                    from chapters as c
                        left join subjects as s
                        	on s.id = c.subject_id
                    left join quiz_results as qr
                        on c.id = qr.chapter_id 
                    LEFT JOIN chapter_states AS cs ON c.id = cs.chapter_id and cs.user_id = '.$user_id.'                    
                        WHERE c.id = ?
                        GROUP BY c.id, c.total_quiz_time, s.name, cs.state, qr.state', [$chapter_id]);

                    $content['subject'] = $startQuiz[0]->subject;
                    $content['total_question'] = $startQuiz[0]->total_question;
                    $content['total_quiz_time'] = $startQuiz[0]->total_quiz_time;
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
        from chapters as c  
            left join quizes as q
                on c.id = q.chapter_id      
        where  c.id = ?', [$chapter_id]);
      
        if (!empty($questions)) {
            foreach ($questions as $q) {
                if ($q->question_id !== null) {
                    $q->references = Content::select('title','type', 'body')->whereIn('id', explode(',', $q->references))->get();
                    $content['chapter_quiz_questions'][] = $q;
                } else {
                    $content['chapter_quiz_questions'] = [];
                }
            }
        }
              
                   $quizAnswers = DB::select('select 
                                    qa.question_id,
                                    qa.answer
                                from quiz_answers as qa    
                                join quizes as q
                                    on q.id = qa.question_id
                                join chapters as c
                                    on c.id = q.chapter_id
                                where c.id = '.$chapter_id .'
                                and qa.created_by = '.$user_id.'');
                                $content['answers'] = $quizAnswers;

                            // if($quizAnswers == []){
                            //     return response(['message' => 'There is no submitted quiz for this chapter'], 422)
                            //         ->header('Content-Type', 'text/json');
                            // }else{
                            //     return response()->json($quizAnswers, 200);
                            // }
            
               


        if($content == []){
            return response(['message' => 'The student is not registered'], 422)
                ->header('Content-Type', 'text/json');
        }else{
            return response()->json($content, 200);
        }

    }

    public function studentSubject(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
        $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
        if($user == NULL || $grade_id == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
       
        $subjectGroups = [];
        $subjects = DB::select('select 
        sub.id as subject_id,
                       sub.name as subject
                    from users as u
                       left join students as s
                       on u.id = s.user_id
                       left join schools as sh
                       on sh.id = s.school_id
                       left join grades as g
                       on g.id = s.grade_id
                       left join subjects_in_grades as sig
                           on g.id = sig.grade_id
                       left join subjects as sub
                           on sub.id = sig.subject_id
                   where u.id = '.$user_id .'');

                   foreach ($subjects as $subject) {
                    if (!isset($subjectGroups[$subject->subject_id])) {
                        $subjectGroups[$subject->subject_id] = [
                            'subject_id' => $subject->subject_id,
                            'subject' => $subject->subject,
                            'chapters' => [],
                        ];
                    }
                
                    $chapters = DB::select('SELECT
                        c.id AS chapter_id,
                        c.name AS chapter_name
                    FROM
                        chapters AS c
                    WHERE
                        c.subject_id = '.$subject->subject_id.' 
                        AND c.grade_id = '.$grade_id.'
                    ');
                
                    foreach ($chapters as $chapter) {
                        $chapterContents = DB::select('SELECT
                            sl.body AS chapter_content
                        FROM
                            subject_lessons AS sl
                        WHERE
                            sl.chapter_id = '.$chapter->chapter_id.'
                        ');
                
                        $chapter->contents = $chapterContents;
                    }
                
                    if ($chapters) {
                        $subjectGroups[$subject->subject_id]['chapters'] = $chapters;
                    }
                }
                
                // Convert the associative array to a sequential array
                $groupedSubjects = array_values($subjectGroups);
                

                if($groupedSubjects == []){
                    return response(['message' => 'The student is not registered'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($groupedSubjects, 200);
                }

    }

   
    public function getStudentList(Request $request){
        $district_id = $request->district_id;
     $grades = [];
        $grades = DB::select('
        select 
            st.id as student_id,
            concat(u.name, "-(",u.identity_number, ")") as student_name
        from users as u
            left join students as st
                on u.id = st.user_id
            left join districts as d
                on d.id = st.district_id
        where st.district_id = '.$district_id.'    
        ');
        return response()->json($grades, 200);

    }     

    public function studentProfile($id){
        $rec = [];
        try{
        // $grade_id = $request->grade_id;
        $user_id = $id;
        $user = User::find($user_id);
    
        // if ($user->role === 'parent') {
    
            $studentGroups = [];
    
            $students = DB::select('SELECT 
                u.name as student_name,
                g.name as grade_name,
                (select name from users where id=sp.user_id) as parent_name,
                g.id as current_grade_id,
                u.id as student_user_id,
                sc.name as school_name,
                pr.name as province_name,
                dis.name as district_name,
                u.email as student_email,
                u.profile_image,
                u.identity_number,
                s.gender as student_gender,
                s.dob as dob,
                u.sync_datetime  as last_sync

            FROM users as u
            JOIN students as s ON u.id = s.user_id
            JOIN schools as sc ON sc.id = s.school_id
            JOIN student_in_parents as sip ON s.id = sip.student_id
            JOIN student_parents as sp ON sp.id = sip.student_parent_id
            JOIN grades as g ON g.id = s.grade_id
            JOIN provinces as pr ON pr.id= s.province_id
            JOIN districts as dis ON dis.id= s.district_id
            WHERE u.id = ' . $user_id);

            $students = json_decode(json_encode($students[0]), true);            
// dd($students);
            
            $students['grades'] = DB::select('select grade_id from student_logs where user_id='.$user_id.' group by grade_id order by grade_id desc');
            $students['grades'] = json_decode(json_encode($students['grades']), true);
            $students['grades'][count($students['grades'])]['grade_id'] = $students['current_grade_id'];


            // dd($students);
            $rec = [
                'student_name' => $students['student_name'],
                'profile_image'=>$students['profile_image'],
                'identity_number'=>$students['identity_number'],
                'student_gender'=>$students['student_gender'],
                'last_sync'=>$students['last_sync'],
                'grade_name' => $students['grade_name'],
                'student_user_id' => $students['student_user_id'],
                "school_name"=>$students['school_name'],
                "province_name"=>$students['province_name'],
                "district_name"=>$students['district_name'],
                "student_email"=>$students['student_email'],
                "parent_name"=>$students['parent_name'],
                "dob"=>$students['dob'],
                "grades"=>[],
                // 'subjects' => [],
                // 'progress' => [], // Initialize the subjects array
            ];
            //add previous grades to the list so that 
            // dd($previous_grades);
            for($i=0;$i<count($students['grades']);$i++) {
                $rec['grades'][$i]['grade_name'] = DB::select('SELECT name from grades where id='.$students['grades'][$i]['grade_id'])[0]->name;
                $total_chapters = DB::select('SELECT COUNT(c.id) AS total_chapters
                FROM chapters AS c
                WHERE c.grade_id =' . $students['grades'][$i]['grade_id'])[0]->total_chapters;
                $learned_chapters = DB::select('SELECT COUNT(c.id) AS learned_chapters
                FROM chapters AS c
                WHERE c.state = 1 and c.grade_id =' . $students['grades'][$i]['grade_id'])[0]->learned_chapters;

                $learned_chapters_per_month = DB::select('
                SELECT COUNT(chapter_id) AS number_of_learned_chapter_per_month,
                DATE_FORMAT(chapter_start_date, \'%M\') AS month_name
                FROM student_tracking_chapters
                WHERE chapter_end_date IS NOT NULL
                and student_id = '.$students['student_user_id'].'
                GROUP BY month_name
                ORDER BY MIN(chapter_start_date);
                ');

                $progressData = [
                    'total_chapters' => $total_chapters,
                    'learned_chapters' => $learned_chapters,
                    'learned_chapters_per_month' => $learned_chapters_per_month,
                ];

                $subjects = DB::select('SELECT
                    s.name as subject_name,
                    s.id as subject_id
                 FROM subjects as s
                 LEFT JOIN subjects_in_grades as sig ON s.id = sig.subject_id
                 LEFT JOIN grades as g ON g.id = sig.grade_id
                 WHERE g.id = ' . $students['grades'][$i]['grade_id']);

                 

                foreach ($subjects as $subject) {
                    $chapters = DB::select('select name,state from chapters where grade_id='.$students['grades'][$i]['grade_id'].' and subject_id='.$subject->subject_id.'');
                 $total_chapters = DB::select('select
                    count(ch.id) as count
                from chapters as ch
                join subjects as s
                on s.id = ch.subject_id
                join subjects_in_grades as sig
                on s.id = sig.subject_id
                join grades as g
                on g.id = sig.grade_id
                where s.id='.$subject->subject_id.' and sig.grade_id = '.$students['grades'][$i]['grade_id'].';
                ');
                    $total_completed_chapters = DB::select('select
                    count(ch.id) as count
                from chapters as ch
                JOIN chapter_states AS cs ON ch.id = cs.chapter_id and cs.user_id = '.$user_id.'
                join subjects as s
                on s.id = ch.subject_id
                join subjects_in_grades as sig
                on s.id = sig.subject_id
                join grades as g
                on g.id = sig.grade_id
                WHERE s.id='.$subject->subject_id.' and sig.grade_id = '.$students['grades'][$i]['grade_id']);
//dd($total_completed_chapters[0]->count);
                    // Add subject_name to the subjects array
                    $subjectData = [
                        'subject_name' => $subject->subject_name,
                        'subject_id' => $subject->subject_id,
                        // 'isRead' => $subject->isRead,
                        'chapters'=>json_decode(json_encode($chapters), true),
                        'quizzes' => [], // Initialize the quizzes array
                        'total_chapters' =>$total_chapters[0]->count,
                        'total_completed_chapters' =>$total_completed_chapters[0]->count,
                    ];

                    $totalQuizzes = DB::select('SELECT COUNT(DISTINCT q.chapter_id) AS total_quizzes
                    FROM quizes AS q
                    JOIN chapters AS c ON c.id = q.chapter_id
                    JOIN subjects AS s ON s.id = c.subject_id
                    WHERE s.id = ' . $subject->subject_id);

                    $attemptedQuizzes = DB::select('SELECT COUNT(qr.id) as number_attempted_quizzes,
                            ROUND(((SUM(qr.total_correct_answers) * 100)/SUM(qr.total_questions)), 2) as percentage_mark,
                        CASE
                    WHEN ((SUM(qr.total_correct_answers) * 100)/SUM(qr.total_questions)) >= 70
                        THEN \'passed\'
                    ELSE
                        CASE
                            WHEN COUNT(qr.id) = 0 THEN NULL
                            ELSE \'failed\'
                        END
                    END AS student_result
                        FROM quiz_results AS qr
                        JOIN chapters AS c ON c.id = qr.chapter_id
                        JOIN subjects AS s ON s.id = c.subject_id
                        WHERE s.id = ' . $subject->subject_id
                        .' AND qr.student_id = '.$students['student_user_id']);

                    $studentQuizHistory = DB::select('SELECT
                        q.question_text AS question,
                        CASE
                            WHEN q.question_image != "" THEN CONCAT("storage/uploads/q_image/", q.question_image)
                            ELSE NULL
                        END AS question_image,
                        q.correct_answer,
                        qa.answer AS student_answer
                        FROM users AS u
                        JOIN students AS s ON u.id = s.user_id
                        JOIN schools AS sh ON sh.id = s.school_id
                        JOIN grades AS g ON g.id = s.grade_id
                        JOIN subjects_in_grades AS sig ON g.id = sig.grade_id
                        JOIN subjects AS sub ON sub.id = sig.subject_id
                        JOIN chapters AS c ON sub.id = c.subject_id
                        JOIN quizes AS q ON c.id = q.chapter_id 
                        JOIN quiz_answers AS qa ON q.id = qa.question_id
                        WHERE sub.id = ' . $subject->subject_id
                        .' AND u.id = '.$students['student_user_id']);

                    $subjectData['quizzes'][] = [
                        'total_quizzes' => $totalQuizzes[0]->total_quizzes,
                        'number_attempted_quizzes' =>$attemptedQuizzes[0]->number_attempted_quizzes,
                        'number_unattempted_quizzes' => $totalQuizzes[0]->total_quizzes - $attemptedQuizzes[0]->number_attempted_quizzes,
                        'percentage_mark' => $attemptedQuizzes[0]->percentage_mark,
                        'student_result' => $attemptedQuizzes[0]->student_result,
                        'student_quiz_history' => $studentQuizHistory,
                    ];

                    // $rec['grades'][$students['grades'][$i]['grade_id']]['subjects'][] = $subjectData;
                    $rec['grades'][$i]['subjects'][] = $subjectData;
                }
                // $rec['grades'][$students['grades'][$i]['grade_id']]['progress'][] = $progressData;
                $rec['grades'][$i]['progress'][] = $progressData;

            }
             //dd($rec);
             //dd($rec['grades'][0]['subjects'][0]['quizzes'][0]['number_attempted_quizzes']);

        return view('pages.profile.index',compact('rec'));
        }catch(Exception $e){
            return view('pages.profile.index',compact('rec'));
        }
    }

    
}