<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use App\Models\School;

class MobileAppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::all();
        return view('pages.setting.grade.index', compact('schools'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {

            $data = Grade::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('grade_status', function ($row) {
                    if ($row->status) {
                        return 'Active';
                    } else {
                        return 'In active';
                    }
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord(' . $row->id . ')" href="javascript.void(0)" data-toggle="modal" data-target="#modal-form">
                    <i class="material-icons">edit</i></i></a> <a onclick="loadRecord(' . $row->id . ')" href="javascript:void(0)" 
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm" 
                    onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i></a>';
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
                if(count($number) != 0){
                    return response(['message' => 'The number is already exist.'], 400)
                        ->header('Content-Type', 'text/json');
                }
                DB::beginTransaction();
                $result = Grade::create($request->input());
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

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $grade = Grade::find($request->id);
            $grade->grade_status = $grade->status ? 'Active' : 'In active';
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
            $number = Grade::where('number', $request->number)->get();
                if(count($number) != 0){
                    return response(['message' => 'The number is already exist.'], 400)
                        ->header('Content-Type', 'text/json');
                }
            $grade = Grade::find($request->id);
            $grade->number = $request->number;
            $grade->name = $request->name;
            $grade->status = $request->status;
            $grade->school_id  = $request->school_id;
            $result = $grade->save();
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
