<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Province;
use App\Models\District;
use App\Models\School;
use App\Models\Grade;
use App\Models\User;
use App\Models\Content;
use App\Models\Chapter;
use App\Models\StudentTrackingChapter;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

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
        s.id as subject_id,
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
$chapters['subject_id'] = $grade[0]->subject_id;
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
    ldc.body as document_content_path,
    ldc.file_size
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
        $visible_question = Chapter::select('visible_question')->where('id', $chapter_id)->get();
        $visible_question = $visible_question && $visible_question[0] ? $visible_question[0]->visible_question : 0;
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
        ch.id as chapter_id,
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

$content['chapter_id'] = $grade[0]->chapter_id;
$content['chapter_name'] = $grade[0]->chapter_name;
$content['grade_language'] = $grade[0]->grade_language;
$content['lesson_count'] = $ContentCount[0]->content_count;
        
                $chapterContents = DB::select('
                        select
                            sl.title as content_title,
                            sl.type as content_type, 
                            sl.body as chapter_content_path,
                            sl.file_size
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



                        $quizResult = DB::select('SELECT COUNT(qr.id) as number_attempted_quizzes,
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
                    WHERE c.id = ' . $chapter_id
                    .' AND qr.student_id = '.$user_id);
                    

                    $content['subject'] = $startQuiz[0]->subject;
                    $content['total_question'] = $startQuiz[0]->total_question;
                    $content['total_quiz_time'] = $startQuiz[0]->total_quiz_time;
                    $content['quiz_status'] = $quizResult[0]->student_result && $quizResult[0]->student_result == 'pass' ?
                    '1' : '0';
                    $content['chapter_quiz_questions'] = [];

$questions = DB::select('
        SELECT
    q.id AS question_id,
    q.question_text AS question,
    CASE
        WHEN q.question_image != "" THEN CONCAT("storage/uploads/q_image/", q.question_image)
        ELSE NULL
    END AS question_image,
    q.option_a_text AS optiona,
    CASE
        WHEN q.option_a_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_a_image)
        ELSE NULL
    END AS option_a_image,
    q.option_b_text AS optionb,
    CASE
        WHEN q.option_b_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_b_image)
        ELSE NULL
    END AS option_b_image,
    q.option_c_text AS optionc,
    CASE
        WHEN q.option_c_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_c_image)
        ELSE NULL
    END AS option_c_image,
    q.option_d_text AS optiond,
    CASE
        WHEN q.option_d_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_d_image)
        ELSE NULL
    END AS option_d_image,
    q.correct_answer,
    q.references
FROM
    chapters AS c
    JOIN (
        SELECT
            inner_q.*
        FROM
            quizes AS inner_q
        WHERE
            inner_q.chapter_id = ?
        ORDER BY
            RAND()
        LIMIT '.$visible_question.'
    ) AS q ON c.id = q.chapter_id;', [$chapter_id]);
      
        if (!empty($questions)) {
            foreach ($questions as $q) {
                if ($q->question_id !== null) {
                    $q->references = Content::select('title','type', 'body', 'file_size')->whereIn('id', explode(',', $q->references))->get();
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
            LEFT JOIN students as s ON u.id = s.user_id
            LEFT JOIN schools as sc ON sc.id = s.school_id
            LEFT JOIN student_in_parents as sip ON s.id = sip.student_id
            LEFT JOIN student_parents as sp ON sp.id = sip.student_parent_id
            LEFT JOIN grades as g ON g.id = s.grade_id
            LEFT JOIN provinces as pr ON pr.id= s.province_id
            LEFT JOIN districts as dis ON dis.id= s.district_id
            WHERE u.id = ' . $user_id);
            if(empty($students))
                throw new Exception('Profile cant not be found');

            $students = json_decode(json_encode($students[0]), true);            
            
            
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
        }catch(\Exception $e){
            return view('pages.profile.index',compact('rec'));
        }
    }


public function singleAPI(){
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
$libraries = [];

        $libraries['library_documents'] = DB::select('select 
        ld.id as id,
        s.name as title,
        ld.description,
        (
            SELECT count(ldc.id) as count
            FROM library_document_contents AS ldc
            where ld.id = ldc.library_document_id
        ) AS count
    from library_documents as ld
    left join subjects as s
        on s.id = ld.subject_id    
    where ld.language = \''.$grade_language.'\''
    );
    foreach($libraries['library_documents'] as $library){
        $library->library_document_contents = DB::select('select 
        ldc.library_document_id as id,                
        ldc.title,
        ldc.body as file_path,
        ldc.file_size
    from library_document_contents as ldc
    where ldc.library_document_id  = '.$library->id .'');
    }

    $libraries['library_videos'] = DB::select('select 
    lv.id as id,
    s.name as title,
    lv.description,
     (
        SELECT count(lvc.id) as count
        FROM library_video_contents AS lvc
        where lv.id = lvc.library_video_id
    ) AS count
    from library_videos as lv
    left join subjects as s
        on s.id = lv.subject_id
    where lv.language = \''.$grade_language.'\''
                );
foreach($libraries['library_videos'] as $library_video){
    $library_video->library_video_contents = DB::select('select 
    lvc.library_video_id as id,                
    lvc.title,
    lvc.body as file_path
from library_video_contents as lvc
where lvc.library_video_id  = '.$library_video->id .'');
}


$libraries['library_audio'] = DB::select('select 
la.id as id,
s.name as title,
la.description,
(
    SELECT count(lac.id) as count
    FROM library_audio_contents AS lac
    where la.id = lac.library_audio_id
) AS count
from library_audios as la
left join subjects as s
on s.id = la.subject_id  
where la.language = \''.$grade_language.'\''
);
foreach($libraries['library_audio'] as $library_audio){
$library_audio->library_audio_contents = DB::select('select 
lac.library_audio_id as id,                
lac.title,
lac.body as file_path,
lac.file_size
from library_audio_contents as lac
where lac.library_audio_id  = '.$library_audio->id .'');

}

$libraries['library_kit'] = DB::select('select 
lk.id as id,
lk.name as title,
lk.description,
(
    SELECT count(lkc.id) as count
    FROM library_kit_contents AS lkc
    where lk.id = lkc.library_kit_id
) AS count
from library_kits as lk
where lk.language = \''.$grade_language.'\''
);
foreach($libraries['library_kit'] as $library_kit){
$library_kit->library_kit_contents = DB::select('select 
lkc.library_kit_id as id,                
lkc.title,
lkc.body as file_path,
lkc.file_size
from library_kit_contents as lkc
where lkc.library_kit_id  = '.$library_kit->id .'');

}



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
                                foreach($courses['courses'] as  $course){
                                    $course->course_contents = DB::select('
                                    select
                                        cc.title as content_title,
                                        cc.type as content_type, 
                                        cc.body as course_content_path,
                                        cc.file_size
                                    from course_contents as cc
                                    where cc.course_id = '.$course->id .'');
                                }

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

            $allInSingleApi = [];
            $allInSingleApi['grade_name'] = $grade[0]->grade_name;
            $allInSingleApi['grade_language'] = $grade[0]->grade_language;
            $allInSingleApi['subject_count'] = $subjectCount[0]->subject_count;
            $allInSingleApi['total_grade_lessons'] = $totalGradeLessons[0]->total_grade_lessons;
            $allInSingleApi['total_grade_passed_lessons'] = $totalGradePassedLessons[0]->total_grade_passed_lessons;
                    $allInSingleApi['subjects'] = DB::select('select 
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
foreach($allInSingleApi['subjects'] as $subject){

    $subject->chapters = DB::select('SELECT DISTINCT
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
        c.subject_id = '.$subject->subject_id.'');

        foreach ($subject->chapters as $lesson) {
            $lesson->chapter_contents = DB::select('
                SELECT
                    sl.title as content_title,
                    sl.type as content_type, 
                    sl.body as chapter_content_path,
                    sl.file_size
                FROM subject_lessons as sl
                WHERE sl.chapter_id = ?', [$lesson->chapter_id]); // Providing the binding as an array
        
            $startQuiz = DB::select('
                SELECT
                    (SELECT COUNT(q.id)
                    FROM quizes as q
                    WHERE c.id = q.chapter_id) as total_question,
                    c.total_quiz_time,
                    s.name as subject,
                    cs.state as quiz_status
                FROM chapters as c
                LEFT JOIN subjects as s ON s.id = c.subject_id
                LEFT JOIN quiz_results as qr ON c.id = qr.chapter_id 
                LEFT JOIN chapter_states AS cs ON c.id = cs.chapter_id AND cs.user_id = ?
                WHERE c.id = ?
                GROUP BY c.id, c.total_quiz_time, s.name, cs.state, qr.state', [$user_id, $lesson->chapter_id]); // Providing bindings as an array
        
            $lesson->total_question = $startQuiz[0]->total_question;
            $lesson->total_quiz_time = $startQuiz[0]->total_quiz_time;
            $lesson->quiz_status = $startQuiz[0]->quiz_status;
            $lesson->chapter_quiz_questions = [];

            $visible_question = Chapter::select('visible_question')->where('id', $lesson->chapter_id)->get();
            $visible_question = $visible_question && $visible_question[0] ? $visible_question[0]->visible_question : 0;
            
                        $questions = DB::select('
                        SELECT
                        q.id AS question_id,
                        q.question_text AS question,
                        CASE
                        WHEN q.question_image != "" THEN CONCAT("storage/uploads/q_image/", q.question_image)
                        ELSE NULL
                        END AS question_image,
                        q.option_a_text AS optiona,
                        CASE
                        WHEN q.option_a_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_a_image)
                        ELSE NULL
                        END AS option_a_image,
                        q.option_b_text AS optionb,
                        CASE
                        WHEN q.option_b_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_b_image)
                        ELSE NULL
                        END AS option_b_image,
                        q.option_c_text AS optionc,
                        CASE
                        WHEN q.option_c_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_c_image)
                        ELSE NULL
                        END AS option_c_image,
                        q.option_d_text AS optiond,
                        CASE
                        WHEN q.option_d_image != "" THEN CONCAT("storage/uploads/q_image/", q.option_d_image)
                        ELSE NULL
                        END AS option_d_image,
                        q.correct_answer,
                        q.references
                        FROM
                        chapters AS c
                        JOIN (
                        SELECT
                            inner_q.*
                        FROM
                            quizes AS inner_q
                        WHERE
                            inner_q.chapter_id = ?
                        ORDER BY
                            RAND()
                        LIMIT '.$visible_question.'
                        ) AS q ON c.id = q.chapter_id;', [$lesson->chapter_id]);

                        if (!empty($questions)) {
                            foreach ($questions as $q) {
                                if ($q->question_id !== null) {
                                    $q->references = Content::select('title','type', 'body', 'file_size')->whereIn('id', explode(',', $q->references))->get();
                                    $lesson->chapter_quiz_questions = $q;
                                } else {
                                    $lesson->chapter_quiz_questions = [];
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
                                                where c.id = '.$lesson->chapter_id .'
                                                and qa.created_by = '.$user_id.'');
                                                $lesson->answers = $quizAnswers;
                                            
                                }    
                                
                                
                                $subject->textbook = DB::select('select
    ldc.title as document_title,
    ldc.body as document_content_path,
    ldc.file_size
    from library_document_contents as ldc
    join library_documents as ld
    on ld.id = ldc.library_document_id
    where ld.subject_id = '.$subject->subject_id.'
    and ldc.is_main = \'1\'');
                            }
                            if($allInSingleApi == []){
                                return response(['message' => 'The student is not registered'], 422)
                                    ->header('Content-Type', 'text/json');
                            }else{
                                return response()->json(['lessons' => $allInSingleApi, 'courses' => $courses, 'libraries' => $libraries], 200);
                            }

                        }elseif($user->role === 'teacher'){
                            if($user->role === 'teacher'){
                                $language = Teacher::select('language')->where('user_id', $user_id)->get();
                                $grade_language = $language && $language[0] ? $language[0]->language : NULL;
                                if($user == NULL || $language == NULL){
                                    return response(['message' => 'The user is not registered'], 400)
                                        ->header('Content-Type', 'text/json');
                                }


                                $teacher = Teacher::select('school_id', 'language')->where('user_id', $user_id)->get();
                                $school_id = $teacher && $teacher[0] ? $teacher[0]->school_id : NULL;
                                $grade_language = $teacher && $teacher[0] ? $teacher[0]->language : NULL;
                                if($user == NULL || $school_id == NULL){
                                    return response(['message' => 'The user is not registered'], 400)
                                        ->header('Content-Type', 'text/json');
                                }



                                $libraries = [];

                                $libraries['library_documents'] = DB::select('select 
                                ld.id as id,
                                s.name as title,
                                ld.description,
                                (
                                    SELECT count(ldc.id) as count
                                    FROM library_document_contents AS ldc
                                    where ld.id = ldc.library_document_id
                                ) AS count
                            from library_documents as ld
                            left join subjects as s
                                on s.id = ld.subject_id    
                            where ld.language = \''.$grade_language.'\''
                            );
                            foreach($libraries['library_documents'] as $library){
                                $library->library_document_contents = DB::select('select 
                                ldc.library_document_id as id,                
                                ldc.title,
                                ldc.body as file_path,
                                ldc.file_size
                            from library_document_contents as ldc
                            where ldc.library_document_id  = '.$library->id .'');
                            }
                        
                            $libraries['library_videos'] = DB::select('select 
                            lv.id as id,
                            s.name as title,
                            lv.description,
                             (
                                SELECT count(lvc.id) as count
                                FROM library_video_contents AS lvc
                                where lv.id = lvc.library_video_id
                            ) AS count
                            from library_videos as lv
                            left join subjects as s
                                on s.id = lv.subject_id
                            where lv.language = \''.$grade_language.'\''
                                        );
                        foreach($libraries['library_videos'] as $library_video){
                            $library_video->library_document_contents = DB::select('select 
                            lvc.library_video_id as id,                
                            lvc.title,
                            lvc.body as file_path
                        from library_video_contents as lvc
                        where lvc.library_video_id  = '.$library_video->id .'');
                        }

                        $libraries['library_audio'] = DB::select('select 
la.id as id,
s.name as title,
la.description,
(
    SELECT count(lac.id) as count
    FROM library_audio_contents AS lac
    where la.id = lac.library_audio_id
) AS count
from library_audios as la
left join subjects as s
on s.id = la.subject_id  
where la.language = \''.$grade_language.'\''
);
foreach($libraries['library_audio'] as $library_audio){
$library_audio->library_audio_contents = DB::select('select 
lac.library_audio_id as id,                
lac.title,
lac.body as file_path,
lac.file_size
from library_audio_contents as lac
where lac.library_audio_id  = '.$library_audio->id .'');

}

$libraries['library_kit'] = DB::select('select 
lk.id as id,
lk.name as title,
lk.description,
(
    SELECT count(lkc.id) as count
    FROM library_kit_contents AS lkc
    where lk.id = lkc.library_kit_id
) AS count
from library_kits as lk
where lk.language = \''.$grade_language.'\''
);
foreach($libraries['library_kit'] as $library_kit){
$library_kit->library_kit_contents = DB::select('select 
lkc.library_kit_id as id,                
lkc.title,
lkc.body as file_path,
lkc.file_size
from library_kit_contents as lkc
where lkc.library_kit_id  = '.$library_kit->id .'');

}

                                $subjectGroups = [];
                                $grades = DB::select('select 
                                distinct g.id as grade_id,
                                               g.name as grade_name,
                                               CASE
                                                WHEN g.language = "en" THEN "English"
                                                WHEN g.language = "da" THEN "Dari"
                                                ELSE "Pashto"
                                            END AS language,
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
                                                    and sl.type = \'audio\') as audio_count
                                            from users as u
                                               join teachers as t
                                               on u.id = t.user_id
                                               join schools as sh
                                               on sh.id = t.school_id
                                               join grades_in_schools as gis
                                                   on sh.id = gis.school_id
                                               join grades as g
                                               on g.id = gis.grade_id
                                               left join subjects_in_grades as sig
                                                   on g.id = sig.grade_id 
                                               left join subjects as sub
                                                on sub.id = sig.subject_id      
                                           where u.id = '.$user_id .'
                                           and sh.id= '.$school_id.'
                                           and g.language = \''.$grade_language.'\'');

// Initialize an empty array to store grouped data
$groupedData = [];

foreach ($grades as $grade) {
    $subjects = DB::select('SELECT 
        DISTINCT s.id as subject_id,
        s.name as subject_name,
        sig.grade_id as grade_id,
        CASE
            WHEN g.language = "en" THEN "English"
            WHEN g.language = "da" THEN "Dari"
            ELSE "Pashto"
        END AS language,
        CASE
            WHEN s.icon != "" THEN CONCAT("storage/uploads/icon/", s.icon)
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
            and sl.type = \'audio\') as audio_count
        FROM subjects AS s
        LEFT JOIN subjects_in_grades AS sig ON s.id = sig.subject_id
        LEFT JOIN grades AS g ON g.id = sig.grade_id
        left join subjects as sub
            on sub.id = sig.subject_id  
        WHERE g.id = ?', [$grade->grade_id]);

    $gradeData = [
        'grade_id' => $grade->grade_id,
        'grade_name' => $grade->grade_name,
        'language' => $grade->language,
        'video_count' => $grade->video_count,
        'doc_count' => $grade->doc_count,
        'audio_count' => $grade->audio_count,
        'subjects' => []
    ];

    foreach ($subjects as $subject) {
        $subjectData = [
            'subject_id' => $subject->subject_id,
            'subject_name' => $subject->subject_name,
            'grade_id' => $subject->grade_id,
            'language' => $subject->language,
            'subject_icon' => $subject->subject_icon,
            'video_count' => $subject->video_count,
            'doc_count' => $subject->doc_count,
            'audio_count' => $subject->audio_count,
            'chapters' => []
        ];

        // Fetch chapters for the subject
        $chapters = DB::select('SELECT
            c.id AS chapter_id,
            c.name AS chapter_name,
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
            FROM chapters AS c
            WHERE c.subject_id = ?
            AND c.grade_id = ?', [$subject->subject_id, $grade->grade_id]);

        foreach ($chapters as $chapter) {
            // Fetch chapter contents for each chapter
            $chapterContents = DB::select('SELECT
                sl.title as content_title,
                sl.type as content_type, 
                sl.body as chapter_content_path,
                sl.file_size
                FROM subject_lessons AS sl
                WHERE sl.chapter_id = ?', [$chapter->chapter_id]);

            $chapter->contents = $chapterContents;
        }

        $subjectData['chapters'] = $chapters;

        // Add the subject data to the grade data
        $gradeData['subjects'][] = $subjectData;
    }

    // Add the grade data to the grouped data
    $groupedData[] = $gradeData;

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
                        foreach($courses['courses'] as  $course){
                            $course->course_contents = DB::select('
                            select
                                cc.title as content_title,
                                cc.type as content_type, 
                                cc.body as course_content_path,
                                cc.file_size
                            from course_contents as cc
                            where cc.course_id = '.$course->id .'');
                        }
                       
}

$province_id = Teacher::select('province_id')->where('user_id', $user_id)->get();
$province_id = $province_id && $province_id[0] ? $province_id[0]->province_id : NULL;
if($user == NULL || $province_id == NULL){
    return response(['message' => 'The user is not registered'], 400)
        ->header('Content-Type', 'text/json');
}
$studentGroups = [];

// $number_of_students = DB::select('SELECT count(s.id) as number_of_student
//FROM students as s
//JOIN teachers as t ON t.province_id = s.province_id
//WHERE t.province_id = ' . $province_id);
//$studentGroups[0]['number_of_student'] = $number_of_students[0]//->number_of_student;
$students = DB::select('SELECT 
    u.name as student_name,
    g.name as grade_name,
    g.id as grade_id,
    u.id as student_user_id,
    s.language,
    s.user_id,
    p.name as province_name
FROM users as u
JOIN students as s ON u.id = s.user_id
JOIN grades as g ON g.id = s.grade_id
JOIN teachers as t ON t.province_id = s.province_id
JOIN provinces as p ON t.province_id = p.id
WHERE t.province_id = ' . $province_id);
foreach ($students as $student) {

    if (!isset($studentGroups[$student->student_user_id])) {
        $studentGroups[$student->student_user_id] = [
            'student_name' => $student->student_name,
            'grade_name' => $student->grade_name,
            'student_user_id' => $student->student_user_id,
            'language' => $student->language,
            'province_name' => $student->province_name,
            'subjects' => [],
            'progress' => [], // Initialize the subjects array
        ];
    }

    // Retrieve the student's progress data for each subject
    $progressData = [
        'total_chapters' => 0,
        'learned_chapters' => 0,
        // 'learned_chapters_per_month' => [],
    ];

    // Retrieve the total and learned chapters for the student's grade
    $total_chapters = DB::select('SELECT COUNT(c.id) AS total_chapters
        FROM chapters AS c
        WHERE c.grade_id =' . $student->grade_id)[0]->total_chapters;

$last_sync_datetime = DB::select('SELECT sync_datetime AS last_sync_datetime
FROM users AS u
WHERE u.id =' . $student->user_id);

$last_sync_datetime = $last_sync_datetime && $last_sync_datetime[0] ? $last_sync_datetime[0]->last_sync_datetime : NULL;

    $learned_chapters = DB::select('SELECT COUNT(c.id) AS learned_chapters
        FROM chapters AS c
        WHERE c.state = "1" and c.grade_id =' . $student->grade_id)[0]->learned_chapters;

    // Retrieve the learned chapters per month for the student
    $learned_chapters_per_month = DB::select('
        SELECT COUNT(chapter_id) AS number_of_learned_chapter_per_month,
        DATE_FORMAT(chapter_start_date, \'%M\') AS month_name
        FROM student_tracking_chapters
        WHERE chapter_end_date IS NOT NULL
        AND student_id = ' . $student->student_user_id . '
        GROUP BY month_name
        ORDER BY MIN(chapter_start_date);
    ');

    $progressData['total_chapters'] = $total_chapters;
    $progressData['learned_chapters'] = $learned_chapters;
    $progressData['last_sync_datetime'] = $last_sync_datetime;
    // $progressData['learned_chapters_per_month'] = $learned_chapters_per_month;

    // Retrieve the subjects for the student's grade
    $subjects = DB::select('SELECT
        s.name as subject_name,
        s.id as subject_id
     FROM subjects as s
     LEFT JOIN subjects_in_grades as sig ON s.id = sig.subject_id
     LEFT JOIN grades as g ON g.id = sig.grade_id
     WHERE g.id = ' . $student->grade_id);

    foreach ($subjects as $subject) {
        $subjectData = [
            'subject_name' => $subject->subject_name,
            'quizzes' => [], // Initialize the quizzes array
        ];

        // Retrieve the total quizzes for the subject
        $totalQuizzes = DB::select('SELECT COUNT(DISTINCT q.chapter_id) AS total_quizzes
            FROM quizes AS q
            JOIN chapters AS c ON c.id = q.chapter_id
            JOIN subjects AS s ON s.id = c.subject_id
            WHERE s.id = ' . $subject->subject_id);

        // Retrieve the attempted quizzes for the subject and student
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
            WHERE s.id = ' . $subject->subject_id . '
            AND qr.student_id = ' . $student->student_user_id);

    // Retrieve the student's quiz history for the subject
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
        WHERE sub.id = ' . $subject->subject_id . '
        AND u.id = ' . $student->student_user_id);


        // Add the data to the subject's quizzes array
        $subjectData['quizzes'][] = [
            'total_quizzes' => $totalQuizzes[0]->total_quizzes,
            'attempted_quizzes' => $attemptedQuizzes[0]->number_attempted_quizzes,
            // 'percentage_mark' => $attemptedQuizzes[0]->percentage_mark,
            // 'student_result' => $attemptedQuizzes[0]->student_result,
            // 'quiz_history' => $studentQuizHistory,
        ];

        // Add the subject data to the student's subjects array
        $studentGroups[$student->student_user_id]['subjects'][] = $subjectData;
    }

    
}


// Add the progress data to the student's progress array
    $studentGroups[$student->student_user_id]['progress'][] = $progressData;
// Convert the associative array to a sequential array
$groupedSubjects = array_values($studentGroups);


// Return the grouped data including grades, subjects, and chapters
return response()->json(['lessons' => $groupedData, 'courses' => $courses, 'libraries' => $libraries, 'teacher_analysis' => $groupedSubjects], 200);

                                   }
                                           


                            }elseif($user->role === 'parent'){

                                $studentGroups = [];
                                $number_of_students = DB::select('SELECT count(sip.id) as number_of_student
                                    FROM student_in_parents as sip
                                    JOIN students as s ON s.id = sip.student_id
                                    JOIN student_parents as sp ON sp.id = sip.student_parent_id
                                    WHERE sp.user_id = ' . $user_id);
                                        $students = DB::select('SELECT 
                                            u.name as student_name,
                                            g.name as grade_name,
                                            g.id as grade_id,
                                            s.user_id,
                                            u.id as student_user_id,
                                            s.language
                                        FROM users as u
                                        JOIN students as s ON u.id = s.user_id
                                        JOIN student_in_parents as sip ON s.id = sip.student_id
                                        JOIN student_parents as sp ON sp.id = sip.student_parent_id
                                        JOIN grades as g ON g.id = s.grade_id
                                        WHERE sp.user_id = ' . $user_id);
                                // $studentGroups[0]['number_of_student'] = $number_of_students[0]->number_of_student;
                                        foreach ($students as $student) {
                                            if (!isset($studentGroups[$student->student_user_id])) {
                                                $studentGroups[$student->student_user_id] = [
                                                    'student_name' => $student->student_name,
                                                    'grade_name' => $student->grade_name,
                                                    'student_user_id' => $student->student_user_id,
                                                    'language' => $student->language,
                                                    'subjects' => [],
                                                    'progress' => [], // Initialize the subjects array
                                                ];
                                            }
                                            
                                            $total_chapters = DB::select('SELECT COUNT(c.id) AS total_chapters
                                                FROM chapters AS c
                                                WHERE c.grade_id =' . $student->grade_id)[0]->total_chapters;
                                        $learned_chapters = DB::select('SELECT COUNT(c.id) AS learned_chapters
                                        FROM chapters AS c
                                        WHERE c.state = "1" and c.grade_id =' . $student->grade_id)[0]->learned_chapters;
                            
                                        $last_sync_datetime = DB::select('SELECT sync_datetime AS last_sync_datetime
                                        FROM users AS u
                                        WHERE u.id =' . $student->user_id);
                                $last_sync_datetime = $last_sync_datetime && $last_sync_datetime[0] ? $last_sync_datetime[0]->last_sync_datetime : NULL;
                                    $learned_chapters_per_month = DB::select('
                                    SELECT COUNT(chapter_id) AS number_of_learned_chapter_per_month,
                                    DATE_FORMAT(chapter_start_date, \'%M\') AS month_name
                                    FROM student_tracking_chapters
                                    WHERE chapter_end_date IS NOT NULL
                                    and student_id = '.$student->student_user_id.'
                                    GROUP BY month_name
                                    ORDER BY MIN(chapter_start_date);
                                    ');
                            
                                            $progressData = [
                                                'total_chapters' => $total_chapters,
                                                'learned_chapters' => $learned_chapters,
                                                'last_sync_datetime' => $last_sync_datetime,
                                                'learned_chapters_per_month' => $learned_chapters_per_month,
                                            ];
                                
                                            $subjects = DB::select('SELECT
                                                s.name as subject_name,
                                                s.id as subject_id
                                             FROM subjects as s
                                             LEFT JOIN subjects_in_grades as sig ON s.id = sig.subject_id
                                             LEFT JOIN grades as g ON g.id = sig.grade_id
                                             WHERE g.id = ' . $student->grade_id);
                                
                                            foreach ($subjects as $subject) {
                                                // Add subject_name to the subjects array
                                                $subjectData = [
                                                    'subject_name' => $subject->subject_name,
                                                    'quizzes' => [], // Initialize the quizzes array
                                                ];
                                
                                                $totalQuizzes = DB::select('SELECT COUNT(DISTINCT q.chapter_id) AS total_quizzes
                                                FROM quizes AS q
                                                JOIN chapters AS c ON c.id = q.chapter_id
                                                JOIN subjects AS s ON s.id = c.subject_id
                                                WHERE s.id = ' . $subject->subject_id);
                                
                                                $attemptedQuizzes = DB::select('SELECT COUNT(qr.id) as number_attempted_quizzes,
                                                qr.created_at as completed_datetime,
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
                                                    .' AND qr.student_id = '.$student->student_user_id);
                                
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
                                                    .' AND u.id = '.$student->student_user_id);
                                
                                                $subjectData['quizzes'][] = [
                                                    'total_quizzes' => $totalQuizzes[0]->total_quizzes,
                                                    'number_attempted_quizzes' =>$attemptedQuizzes[0]->number_attempted_quizzes,
                                                    'completed_datetime' =>$attemptedQuizzes[0]->completed_datetime,
                                                    // 'number_unattempted_quizzes' => $totalQuizzes[0]->total_quizzes - $attemptedQuizzes[0]->number_attempted_quizzes,
                                                    // 'percentage_mark' => $attemptedQuizzes[0]->percentage_mark,
                                                    // 'student_result' => $attemptedQuizzes[0]->student_result,
                                                    // 'student_quiz_history' => $studentQuizHistory,
                                                ];
                                
                                                $studentGroups[$student->student_user_id]['subjects'][] = $subjectData;
                                            }
                                
                                            $studentGroups[$student->student_user_id]['progress'][] = $progressData;
                                        }
                                
                                        // Convert the associative array to a sequential array
                                        $groupedSubjects = array_values($studentGroups);
                                
                                        if (empty($groupedSubjects)) {
                                            return response(['message' => 'There are no students found for the parent'], 422)
                                                ->header('Content-Type', 'text/json');
                                        } else {
                                            return response()->json($groupedSubjects, 200);
                                        }

                            }
                        else{
                            return response(['message' => 'The user is not registered'], 422)
                            ->header('Content-Type', 'text/json');
                        }      

    }
    
}