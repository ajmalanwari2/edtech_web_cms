<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\RegionalManagementOffice;
use App\Models\Province;
use App\Models\District;
use App\Models\Grade;
use App\Models\GradeInSchool;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regional_management_offices = RegionalManagementOffice::where('status', '1')->get();
        $provinces = Province::where('status', '1')->get();
        $districts = District::where('status', '1')->get();
        $grades = Grade::where('status', '1')->get();
        return view('pages.setting.school.index', compact('regional_management_offices', 'provinces', 'districts', 'grades'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
    
            $data = School::with('regional_management_offices', 'provinces', 'districts')
                ->withCount('grades_in_schools')
                ->orderBy('updated_at', 'desc')
                ->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('district_name', function ($row) {
                    return $row->districts->name;
                })
                ->addColumn('school_status', function ($row) {
                    if ($row->status) {
                        return 'Active';
                    } else {
                        return 'Inactive';
                    }
                })
                ->addColumn('school_rmo', function ($row) {
                    return $row->regional_management_offices ? $row->regional_management_offices->abbreviation : '';
                })
                ->addColumn('school_province', function ($row) {
                    return $row->provinces ? $row->provinces->name : '';
                })
                ->addColumn('grades', function ($row) {
                    return $row->grades_in_schools_count;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if ($request->ajax()) {
                $number = School::where('number', $request->number)->get();
                if (count($number) != 0) {
                    return response(['message' => 'The number is already exist.'], 400)
                        ->header('Content-Type', 'text/json');
                }
                DB::beginTransaction();
                $data  = $request->input();
                $data['created_by'] = auth()->user()->id;
                $result = School::create($data);
                if ($request->grades != null)
                    foreach ($request->grades as $grade) {
                        $grades = new GradeInSchool();
                        $grades->school_id = $result->id;
                        $grades->grade_id = $grade;
                        $grades->created_at = date("Y-m-d H:i:s");
                        $grades->created_by = auth::user()->id;
                        $grades->save();
                    }

                DB::commit();

                if (!empty($result->id)) {
                    return response(['id' => $result->id], 201)
                        ->header('Content-Type', 'text/json');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('school.index'))->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $school = School::find($request->id);
    
            if (!empty($school)) {
                $school->grades = $school->grades_in_schools()->with('gradeId')->get();    
                $school->district_name = $school->districts->name;
                $school->school_status = $school->status ? 'Active' : 'Inactive';
                $school->school_province = $school->provinces->name;
                $school->school_rmo = $school->regional_management_offices->abbreviation;
    
                return response()->json($school, 200);
            }
        }
    
        return response()->json(['data' => null], 404);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $school = School::find($request->id);
    
            // Check if the number has changed in the request
            if ($school->number !== $request->number) {
                $existingSchool = School::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existingSchool) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }

            DB::beginTransaction();
            $school->number = $request->number;
            $school->name = $request->name;
            $school->status = $request->status;
            $school->district_id  = $request->district_id;
            $school->province_id  = $request->province_id;
            $school->regional_management_office_id  = $request->regional_management_office_id;

            $res = GradeInSchool::where('school_id', $request->id)->delete();

            foreach ($request->grades as $grade) {
                $grades = new GradeInSchool();
                $grades->school_id = $request->id;
                $grades->grade_id = $grade;
                $grades->created_at = date("Y-m-d H:i:s");
                $grades->created_by = auth::user()->id;
                $grades->save();
            }
            $result = $school->save();
            DB::commit();
            if (!empty($result)) {
                return response([$result], 201)
                    ->header('Content-Type', 'text/json');
            } else {
                DB::rollBack();
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $result = School::destroy($request->id);

            $schoolInGrades = DB::table('grades_in_schools')->where('school_id', $request->id)->get();
            foreach($schoolInGrades as $schoolInGrade){
                SubjectInGrade::destroy($schoolInGrade->school_id);
            }
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }

    public function getSchools()
    {
        $schools = School::get();
        return response()->json($schools, 200);
    }
}
