<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use App\Models\SubjectInGrade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class SubjectController extends Controller
{
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();
        return view('pages.setting.subject.index', compact('grades'));
    }

    public function list(Request $request){
        if ($request->ajax()) {

            $data = Subject::withCount('chapters')->orderBy('updated_at', 'desc')->get();     
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('subject_status', function ($row) {
                    if($row->status){
                        return 'Active'; 
                    }else{
                        return 'In active';
                    }
                  
                })
                ->addColumn('chapter_count', function ($row) {
                    return $row->chapters_count;
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#modal-form">
                    <i class="material-icons">edit</i></i></a> <a onclick="loadRecord('.$row->id.')" href="javascript:void(0)" 
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm" 
                    onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i></a>
                    <a href="'.route('subject.content_index', $row->id).'"><i class="material-icons">add</i></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
               
        }
    }
    public function content_list(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
            SELECT
                c.id,
                c.number,
                c.updated_at,
                c.name,
                c.status,
                c.total_quiz_time,
                g.name AS grade_name,
                g.id AS grade_id,
                s.name AS subject_name,
                s.id AS subject_id,
                MAX(q.id) AS quiz_included,
                GROUP_CONCAT(DISTINCT sl.type SEPARATOR ", ") AS lesson_types
            FROM chapters AS c
            JOIN grades AS g ON g.id = c.grade_id
            JOIN subjects AS s ON s.id = c.subject_id
            LEFT JOIN subject_lessons AS sl ON c.id = sl.chapter_id
            LEFT JOIN quizes AS q ON c.id = q.chapter_id
            where c.subject_id = '.$request->subject_id.'
            GROUP BY c.id
            ORDER BY c.updated_at DESC
            ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('chapter_status', function ($row) {
                    return $row->status ? 'Active' : 'Inactive';
                })
                ->addColumn('lesson_types', function ($row) {
                    return $row->lesson_types ?? 'N/A';
                })
                ->addColumn('quiz_included', function ($row) {
                    return $row->quiz_included ? 'Yes' : 'No';
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<div class="dropdown ml-auto">
                    <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                        <i class="material-icons">more_vert</i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#edit-modal-form">
                    <i class="material-icons">edit</i></i> Edit</a>
                    <a class="dropdown-item" onclick="loadRecord('.$row->id.')" href="javascript:void(0)"
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i> View</a>
                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm"
                onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i> Delete</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="'.route('content.show', $row->id).'"><i class="material-icons">add</i></i> Add Content</a>
                        <a class="dropdown-item" href="'.route('quiz.show', $row->id).'"><i class="material-icons">add</i></i> Add Quiz</a>
                    </div>
                </div>';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);

        }
    }

    public function contentIndex(Request $request)
    {

        $grades = Grade::where('status', '1')->get();
        $subjects = Subject::where('status', '1')->get();
        $subject_id = $request->subject_id;
        $grade = SubjectInGrade::select('grade_id')->where('subject_id', $request->subject_id)->first();
        $grade_id = null;

            if (!empty($grade)) {
                $grade_id = $grade->grade_id;
            }
        return view('pages.setting.subject.content_index', compact('subject_id', 'grade_id', 'grades'));
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        try {
            if ($request->ajax()) 
            {
                DB::beginTransaction();
             
                $data = $request->input();
                $data['created_by'] = auth()->user()->id;
                $data['icon'] = 'N/A';
                $result = Subject::create($data);
                $subject = [
                    'grade_id' => $request->grade_id,
                    'subject_id' => $result->id,
                    'created_by' => auth::user()->id,
                ];
                SubjectInGrade::create($subject);

                DB::commit(); 
                $rec = Subject::find($result->id);
                if (isset($request->icon) && $request->icon != 'undefined') {
                    $file1 = storeFiles($request, ['icon'], $request->grade_id . '-icon');

                    $file_name = explode('/', $file1['icon']);

                    if (empty($file1)) {
                        throw new \Exception('icon for subject could not be uploaded');
                    } else {

                        //we will delete old file

                        $res = File::delete(base_path() .'/storage/app/public/uploads/icon/' .$rec->icon);
                        $rec->icon = end($file_name);
                    }
                } 
                $r = $rec->save();
                    if(!empty($result->id))
                    {
                        return response(['id' => $result->id], 201)
                        ->header('Content-Type', 'text/json');
                    }
            }         
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('subject.index'))->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $subject = Subject::with('lessons')->find($request->id);
            $subject->subject_status = $subject->status ? 'Active' : 'In active'; 
            if(!empty($subject->id))
            return response($subject, 200)
                  ->header('Content-Type', 'text/json');
        }else{
            return response(['data' => null], 404)
                  ->header('Content-Type', 'text/json');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $subject = Subject::find($request->id);
    
            // Check if the number has changed in the request
            if ($subject->number !== $request->number) {
                $existingSubject = Subject::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existingSubject) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }
            $subject->number = $request->number;
            $subject->name = $request->name;
            $subject->status = $request->status;
            if (isset($request->icon) && $request->icon != 'undefined') {
                $file1 = storeFiles($request, ['icon'], $request->id . '-icon');

                $file_name = explode('/', $file1['icon']);

                if (empty($file1)) {
                    throw new \Exception('icon for subject could not be uploaded');
                } else {

                    //we will delete old file

                    $res = File::delete(base_path() .'/storage/app/public/uploads/icon/' .$subject->icon);
                    $subject->icon = end($file_name);
                }
            }
            $result = $subject->save();
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
            $result = Subject::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }

   


    public function getSubjectsThroughGrade(Request $request){
        $grade_id = $request->post('grade_id');
        $subjects = DB::select('
            select
                s.id,
                s.name
            from subjects as s
            left join subjects_in_grades as sg
            on s.id = sg.subject_id
            left join grades as g
            on g.id = sg.grade_id
            where sg.grade_id = '.$grade_id.'    
        ');
        $html = '<option value="">Select</option>';
        foreach($subjects as $subject){
            $html.='<option value="'.$subject->id.'">'.$subject->number.'-'.$subject->name.'</option>';
        }
        return $html;
    }
}
