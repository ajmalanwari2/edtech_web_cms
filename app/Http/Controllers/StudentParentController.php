<?php

namespace App\Http\Controllers;

use App\Models\StudentParent;
use App\Models\Student;
use App\Models\StudentInParent;
use App\Http\Requests\StoreStudentParentRequest;
use App\Http\Requests\UpdateStudentParentRequest;
use App\Models\Province;
use App\Models\District;
use App\Models\School;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentParentController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        $districts = District::all();
        $schools = School::all();
        $grades = Grade::all();
        return view('pages.parent.index', compact('provinces', 'districts', 'schools', 'grades' ));
    }
    /**
     * Display a listing of the resource as json .
     */
    public function list(Request $request){
        if ($request->ajax()) {
            $data = StudentParent::with('province', 'school', 'user')->latest()->get();   
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
                    $parent = [
                        'phone_no' => $request->phone_no,
                        'user_id' => $user_id,
                        'province_id' => $request->province_id,
                        'district_id' => $request->district_id,
                        'school_id' => $request->school_id,
                        'grade_id' => $request->grade_id,
                    ];
                    StudentParent::create($parent);
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

    public function parentAnalysis(Request $request)
    {
        $grade_id = $request->grade_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
    
        if ($user->role === 'parent') {
    
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
                         'progress' => [ // Initialize the progress array with default values
                        [
                            'total_chapters' => 0,
                            'learned_chapters' => 0,
                            'last_sync_timestamp' => NULL,
                        ]
                    ],
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
                'total_chapters' => $total_chapters ?? 0,
                'learned_chapters' => $learned_chapters ?? 0,
                'last_sync_timestamp' => $last_sync_timestamp ?? NULL,
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
        } else {
            return response(['message' => 'The user is not registered as a parent'], 422)
                ->header('Content-Type', 'text/json');
        }
    }
    
    public function destroy($id)
    {
        $student = StudentInParent::where('student_id', $id)->first();

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();

        return response()->json(['message' => 'Student deleted successfully']);
    }
    
    
        public function addStudent(Request $request)
{
    $user_id = auth()->user()->id;
    $studentParent = StudentParent::where('user_id', $user_id)->first();
    
    if ($request->has('student_ids') && $request->student_ids != null) {
        $studentIds = explode(',', $request->student_ids);
    
        foreach ($studentIds as $studentId) {
            $student = Student::withTrashed()->where('user_id', $studentId)->first();
    
            if ($student) {
                $studentInParent = new StudentInParent();
                $studentInParent->student_parent_id = $studentParent->id;
                $studentInParent->student_id = $student->id;
                $studentInParent->created_by = $user_id;
                $studentInParent->save();
            } else {
                // Handle the case where a student with the given ID is not found
                return response()->json(['error' => 'Student not found with ID: ' . $studentId], 404);
            }
        }
    
        return response()->json(['message' => 'Students added successfully']);
    }
    
    // Return error response if student_ids parameter is missing or empty
    return response()->json(['error' => 'No student IDs provided'], 400);
}
    
}
