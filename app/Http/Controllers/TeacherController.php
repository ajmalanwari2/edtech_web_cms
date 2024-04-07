<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Province;
use App\Models\District;
use App\Models\School;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        $districts = District::all();
        $schools = School::all();
        $grades = Grade::all();
        return view('pages.teacher.index', compact('provinces', 'districts', 'schools', 'grades' ));
    }
    /**
     * Display a listing of the resource as json .
     */
    public function list(Request $request){
        if ($request->ajax()) {
            $data = Teacher::with('province', 'school', 'user')->latest()->get();   
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
                        'province_id' => $request->province_id,
                        'district_id' => $request->district_id,
                        'school_id' => $request->school_id,
                        'grade_id' => $request->grade_id,
                    ];
                    Teacher::create($student);
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
                return redirect(route('teacher.index'))->with('error',$e->getMessage());
            }
    }


    public function teacherGradeList(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        if ($user->last_seen === null) {
            $user->update(['last_seen' => date("Y-m-d H:i:s")]);
        } else {
            $user->update(['last_seen' => date("Y-m-d H:i:s")]);
        }


        if($user->role === 'teacher'){
            $language = Teacher::select('language')->where('user_id', $user_id)->get();
            $grade_language = $language && $language[0] ? $language[0]->language : NULL;
            if($user == NULL || $language == NULL){
                return response(['message' => 'The user is not registered'], 400)
                    ->header('Content-Type', 'text/json');
            }
        }



        if($user->role === 'teacher'){
        $teacher = Teacher::select('school_id', 'language')->where('user_id', $user_id)->get();
        $school_id = $teacher && $teacher[0] ? $teacher[0]->school_id : NULL;
        $grade_language = $teacher && $teacher[0] ? $teacher[0]->language : NULL;
        if($user == NULL || $school_id == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
        $subjects = DB::select('select 
        distinct g.id as grade_id,
                       g.name as grade_name
                    from users as u
                       left join teachers as t
                       on u.id = t.user_id
                       left join schools as sh
                       on sh.id = t.school_id
                       left join grades_in_schools as gis
                           on sh.id = gis.school_id
                       left join grades as g
                       on g.id = gis.grade_id
                       left join subjects_in_grades as sig
                           on g.id = sig.grade_id
                   where u.id = '.$user_id .'
                   and sh.id= '.$school_id.'
                   and g.language = \''.$grade_language.'\'');

                if($subjects == []){
                    return response(['message' => 'The teacher is not registered'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($subjects, 200);
                }

            }
            else{
                return response(['message' => 'The teacher is not registered as student'], 422)
                ->header('Content-Type', 'text/json');
            }      

    }


    public function gradeSubjectList(Request $request)
    {
        $grade_id = $request->grade_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
    
        if ($user->role === 'teacher') {
            $school_id = Teacher::select('school_id')->where('user_id', $user_id)->get();
            $school_id = $school_id && $school_id[0] ? $school_id[0]->school_id : NULL;
    
            if ($user == NULL || $school_id == NULL) {
                return response(['message' => 'The user is not registered'], 400)
                    ->header('Content-Type', 'text/json');
            }
    
            $subjectGroups = [];
    
            $subjects = DB::select('SELECT 
                DISTINCT s.id as subject_id,
                s.name as subject_name,
                sig.grade_id as grade_id
            FROM subjects AS s
            LEFT JOIN subjects_in_grades AS sig ON s.id = sig.subject_id
            WHERE sig.grade_id = ' . $grade_id);
    
            foreach ($subjects as $subject) {
                if (!isset($subjectGroups[$subject->subject_id])) {
                    $subjectGroups[$subject->subject_id] = [
                        'subject_id' => $subject->subject_id,
                        'grade_id' => $subject->grade_id,
                        'subject' => $subject->subject_name,
                        'chapters' => [],
                    ];
                }
    
                $chapters = DB::select('SELECT
                    c.id AS chapter_id,
                    c.name AS chapter_name
                FROM chapters AS c
                WHERE c.subject_id = ' . $subject->subject_id . ' 
                AND c.grade_id = ' . $grade_id);
    
                foreach ($chapters as $chapter) {
                    $chapterContents = DB::select('SELECT
                         sl.title as content_title,
                            sl.type as content_type, 
                            sl.body as chapter_content_path
                    FROM subject_lessons AS sl
                    WHERE sl.chapter_id = ' . $chapter->chapter_id);
    
                    $chapter->contents = $chapterContents;
                }
    
                if ($chapters) {
                    $subjectGroups[$subject->subject_id]['chapters'] = $chapters;
                }
            }
    
            // Convert the associative array to a sequential array
            $groupedSubjects = array_values($subjectGroups);
    
            if ($groupedSubjects == []) {
                return response(['message' => 'The student is not registered'], 422)
                    ->header('Content-Type', 'text/json');
            } else {
                return response()->json($groupedSubjects, 200);
            }
        } else {
            return response(['message' => 'The teacher is not registered as a student'], 422)
                ->header('Content-Type', 'text/json');
        }
    }


    public function teacherAnalysis_old(Request $request)
    {
        $grade_id = $request->grade_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
    
        if ($user->role === 'teacher') {
    
            $gradeGroups = [];
    
            $grades = DB::select('select
            g.id as grade_id,
            g.name as grade_name
        from grades as g
        left join grades_in_schools as gis
            on g.id = gis.grade_id
        left join schools as s
            on s.id = gis.school_id
        left join teachers as t
            on s.id = t.school_id
        where t.user_id = ' . $user_id);
    
            foreach ($grades as $grade) {
                if (!isset($gradeGroups[$grade->grade_id])) {
                    $gradeGroups[$grade->grade_id] = [
                        'grade_id' => $grade->grade_id,
                        'grade_name' => $grade->grade_name,
                        'subjects' => [], // Initialize the subjects array
                    ];
                }
    
                $subjects = DB::select('SELECT
                    s.name as subject_name,
                    s.id as subject_id
                 FROM subjects as s
                 LEFT JOIN subjects_in_grades as sig ON s.id = sig.subject_id
                 LEFT JOIN grades as g ON g.id = sig.grade_id
                 WHERE g.id = ' . $grade->grade_id);
    
                foreach ($subjects as $subject) {
                    // Add subject_name to the subjects array
                    $subjectData = [
                        'subject_name' => $subject->subject_name,
                        'chapters' => [], // Initialize the quizzes array
                    ];
    
                    $totalChapters = DB::select('SELECT COUNT(c.id) as total_chapters
                        FROM chapters AS c
                        JOIN subjects AS s ON s.id = c.subject_id
                        WHERE s.id = ' . $subject->subject_id);
    
                    $learnedChapters = DB::select('SELECT COUNT(c.id) as learned_chapters
                    FROM chapters AS c
                    JOIN subjects AS s ON s.id = c.subject_id
                    WHERE c.state = 1 
                    and s.id = ' . $subject->subject_id);
    
                    $subjectData['chapters'][] = [
                        'total_chapters' => $totalChapters[0]->total_chapters,
                        'learned_chapters' => $learnedChapters[0]->learned_chapters,
                    ];
    
                    $gradeGroups[$grade->grade_id]['subjects'][] = $subjectData;
                }
            }
    
            // Convert the associative array to a sequential array
            $groupedSubjects = array_values($gradeGroups);
    
            if (empty($groupedSubjects)) {
                return response(['message' => 'there is not any subject assigned for the teacher'], 422)
                    ->header('Content-Type', 'text/json');
            } else {
                return response()->json($groupedSubjects, 200);
            }
        } else {
            return response(['message' => 'The user is not registered as a teacher'], 422)
                ->header('Content-Type', 'text/json');
        }
    }


    public function teacherAnalysis(Request $request)
{
    $user_id = auth()->user()->id;
    $user = User::find($user_id);

    if ($user->role === 'teacher') {
        $studentGroups = [];

        $students = DB::select('SELECT 
            u.name as student_name,
            g.name as grade_name,
            g.id as grade_id,
            u.id as student_user_id
        FROM users as u
        JOIN students as s ON u.id = s.user_id
        JOIN grades as g ON g.id = s.grade_id
        JOIN teachers as t ON g.id = t.grade_id
        WHERE t.user_id = ' . $user_id);

        foreach ($students as $student) {

            if (!isset($studentGroups[$student->student_user_id])) {
                $studentGroups[$student->student_user_id] = [
                    'student_name' => $student->student_name,
                    'grade_name' => $student->grade_name,
                    'student_user_id' => $student->student_user_id,
                    'subjects' => [],
                    'progress' => [], // Initialize the subjects array
                ];
            }

            // Retrieve the student's progress data for each subject
            $progressData = [
                'total_chapters' => 0,
                'learned_chapters' => 0,
                'learned_chapters_per_month' => [],
            ];

            // Retrieve the total and learned chapters for the student's grade
            $total_chapters = DB::select('SELECT COUNT(c.id) AS total_chapters
                FROM chapters AS c
                WHERE c.grade_id =' . $student->grade_id)[0]->total_chapters;
            $learned_chapters = DB::select('SELECT COUNT(c.id) AS learned_chapters
                FROM chapters AS c
                WHERE c.state = 1 and c.grade_id =' . $student->grade_id)[0]->learned_chapters;

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
            $progressData['learned_chapters_per_month'] = $learned_chapters_per_month;

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
                    'percentage_mark' => $attemptedQuizzes[0]->percentage_mark,
                    'student_result' => $attemptedQuizzes[0]->student_result,
                    'quiz_history' => $studentQuizHistory,
                ];

                // Add the subject data to the student's subjects array
                $studentGroups[$student->student_user_id]['subjects'][] = $subjectData;
            }

            // Add the progress data to the student's progress array
            $studentGroups[$student->student_user_id]['progress'][] = $progressData;
        }

        // Convert the associative array to a sequential array
        $groupedSubjects = array_values($studentGroups);

        if (empty($groupedSubjects)) {
            return response(['message' => 'There are no students found for the teacher'], 422)
                ->header('Content-Type', 'text/json');
        } else {
            return response()->json($groupedSubjects, 200);
        }
    } else {
        return response(['message' => 'The user is not registered as a teacher'], 422)
            ->header('Content-Type', 'text/json');
    }
}

}
