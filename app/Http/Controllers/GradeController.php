<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use App\Models\SubjectInGrade;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('pages.setting.grade.index', compact('subjects'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Grade::withCount('subjects_in_grades')->orderBy('updated_at', 'desc')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('grade_status', function ($row) {
                    return $row->status ? 'Active' : 'Inactive';
                })
                ->addColumn('subjects_count', function ($row) {
                    return $row->subjects_in_grades_count;
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord(' . $row->id . ')" href="javascript:void(0)" data-toggle="modal" data-target="#modal-form">
                    <i class="material-icons">edit</i></a> <a onclick="loadRecord(' . $row->id . ')" href="javascript:void(0)" 
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons" style="color:SlateBlue">visibility</i></a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm" 
                    onclick="deleteRecordID=' . $row->id . ';"><i class="material-icons" style="color:darkorange">delete</i></a>
                    <a href="'.route('grade.subject_index', $row->id).'"><i class="material-icons">add</i></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function subject_list(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
            SELECT
                s.id,
                s.number,
                s.name,
                s.status,
                s.updated_at
            FROM subjects AS s
            JOIN subjects_in_grades AS sig 
            ON s.id = sig.subject_id
            where sig.grade_id = '.$request->grade_id.'
            ORDER BY s.updated_at DESC
            ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('subject_status', function ($row) {
                    return $row->status ? 'Active' : 'Inactive';
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord(' . $row->id . ')" href="javascript:void(0)" data-toggle="modal" data-target="#modal-form">
                    <i class="material-icons">edit</i></a> <a onclick="loadRecord(' . $row->id . ')" href="javascript:void(0)" 
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons" style="color:SlateBlue">visibility</i></a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm" 
                    onclick="deleteRecordID=' . $row->id . ';"><i class="material-icons" style="color:darkorange">delete</i></a>
                    <a href="'.route('subject.content_index', $row->id).'"><i class="material-icons">add</i></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }
    // public function getGrades(Request $request)
    // {
    //     // dd($request->term['term']);
    //     $data['results'] = Grade::latest()->where('name','like','%'.$request->term['term'].'%')->where('status','=','1')->get();
    //     // $data['length'] = 3;
    //     return response()->json($data,200);

    // }
    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        try {
            if ($request->ajax()) {
                $number = Grade::where('number', $request->number)->get();
                if (count($number) != 0) {
                    return response(['message' => 'The number already exists.'], 400)
                        ->header('Content-Type', 'text/json');
                }
                DB::beginTransaction();
                $data = $request->input();
                $data['created_by'] = auth()->user()->id;
                $result = Grade::create($data);

                // if ($request->subjects != null)
                //     foreach ($request->subjects as $subject) {
                //         $subjects = new SubjectInGrade();
                //         $subjects->grade_id = $result->id;
                //         $subjects->subject_id = $subject;
                //         $subjects->created_by = auth::user()->id;
                //         $subjects->save();
                //     }

                DB::commit();

                if (!empty($result->id)) {
                    return response(['id' => $result->id], 201)
                        ->header('Content-Type', 'text/json');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('grade.index'))->with('error', $e->getMessage());
        }
    }

    public function subjectIndex(Request $request)
    {

        $grade_id = $request->grade_id;
        return view('pages.setting.grade.subject_index', compact('grade_id'));
    }

    /**
     * Display the specified resource.
     */
  public function show(Request $request)
{
    if ($request->ajax()) {
        $grade = Grade::find($request->id);
        $grade->grade_status = $grade->status ? 'Active' : 'Inactive';
        $grade->subjects = $grade->subjects_in_grades()->with('subjectId')->get();

        if (!empty($grade->id))
            return response($grade, 200)
                ->header('Content-Type', 'text/json');
    } else {
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
             $grade = Grade::find($request->id);
     
             // Check if the number has changed in the request
             if ($grade->number !== $request->number) {
                 $existingGrade = Grade::where('number', $request->number)->first();
     
                 // If a province with the same number already exists, return an error response
                 if ($existingGrade) {
                     return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                 }
             }
            $grade->number = $request->number;
            $grade->name = $request->name;
            $grade->status = $request->status;
            $grade->language = $request->language;
            $result = $grade->save();

            // $res = SubjectInGrade::where('grade_id', $request->id)->delete();

            // foreach ($request->subjects as $subject) {

            //     $subjects = new SubjectInGrade();
            //     $subjects->subject_id = $subject;
            //     $subjects->grade_id = $request->id;
            //     $subjects->created_at = date("Y-m-d H:i:s");
            //     $subjects->created_by = auth::user()->id;
            //     $subjects->save();
            // }

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
            $result = Grade::find($request->id);
            $result->delete();
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }
}
