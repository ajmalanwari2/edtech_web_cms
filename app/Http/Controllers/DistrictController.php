<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use App\Models\Province;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use App\Models\School;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Province::all();
        return view('pages.setting.district.index', compact('provinces'));
    }

    public function list(Request $request){
        if ($request->ajax()) {

            $data = District::with('provinces')->orderBy('updated_at', 'desc')->get();   
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('province_name', function($row){
                    return $row->provinces->name;
                })
                ->addColumn('district_status', function ($row) {
                    if($row->status){
                        return 'Active'; 
                    }else{
                        return 'In active';
                    }
                  
                })
                ->addColumn('district_center', function ($row) {
                    if($row->is_center){
                        return 'Capital'; 
                    }else{
                        return 'Not Capital';
                    }
                  
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#modal-form">
                    <i class="material-icons">edit</i></i></a> <a onclick="loadRecord('.$row->id.')" href="javascript:void(0)" 
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm" 
                    onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
               
        }
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        try {
            if ($request->ajax()) 
            {
                $number = District::where('number', $request->number)->get();
                if(count($number) != 0){
                    return response(['message' => 'The number is already exist.'], 400)
                        ->header('Content-Type', 'text/json');
                }
                DB::beginTransaction();
                $result = District::create($request->input());
                DB::commit();  
                    if(!empty($result->id))
                    {
                        return response(['id' => $result->id], 201)
                        ->header('Content-Type', 'text/json');
                    }
            }         
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('rmo.index'))->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $district = District::find($request->id);
            $district->province_name = $district->provinces->name; 
            $district->district_status = $district->status ? 'Active' : 'In active'; 
            $district->district_created_at = date("Y-m-d ", strtotime($district->created_at)); 
            $district->district_updated_at = date("Y-m-d ", strtotime($district->updated_at)); 
            $district->loadContents();
            if(!empty($district->id))
            return response($district, 200)
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
             $district = District::find($request->id);
     
             // Check if the number has changed in the request
             if ($district->number !== $request->number) {
                 $existingDistrict = District::where('number', $request->number)->first();
     
                 // If a province with the same number already exists, return an error response
                 if ($existingDistrict) {
                     return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                 }
             }
             $district->number = $request->number;
             $district->name = $request->name;
             $district->status = $request->status;
             $district->is_center = $request->is_center;
             $district->province_id = $request->province_id;
             $result = $district->save();
     
     
             if ($result) {
                 return response([$result], 201)->header('Content-Type', 'text/json');
             }
         }
     }


    /**
     * Remove the specified resource from storage.
     */
    
     public function destroy(Request $request)
     {
         if ($request->ajax()) {
             $rmo = District::findOrFail($request->id);
             
             // Check if the RMO has child provinces
             if ($rmo->schools()->exists()) {
                 return response()->json(['message' => 'Cannot delete parent object. Please delete the child schools first.'], 400);
             }
             
             $result = $rmo->delete();
             
             if ($result) {
                 return response()->json(['message' => 'District deleted successfully.'], 200);
             } else {
                 return response()->json(['message' => 'Failed to delete RMO.'], 400);
             }
         }
     }
    // public function destroy(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $result = District::destroy($request->id);

    //         $schools = DB::table('schools')->where('district_id', $request->id)->get();
    //         foreach($schools as $school){
    //             School::destroy($school->id);
    //         }
    //         if (!empty($result))
    //             return response([$result], 200)
    //                 ->header('Content-Type', 'text/json');
    //         else
    //             return response([$result], 400)
    //                 ->header('Content-Type', 'text/json');
    //     }
    // }

    public function getDistrictsThroughProvince(Request $request){
        $pro_id = $request->post('pro_id');
        $districts = DB::table('districts')->where('province_id', $pro_id)->get();
        $html = '<option value="">Select</option>';
        foreach($districts as $district){
            $html.='<option value="'.$district->id.'">'.$district->number. '-' .$district->name.'</option>';
        }
        return $html;
    }


    public function getDistrictsThroughProvinceMobile(Request $request){
        
        $pro_id = intval($request->province_id);
    $districts = District::where('province_id', $pro_id)->get();
    return response()->json($districts, 200);

    }

    public function getGradesThroughLanguageMobile(Request $request){
        
        $language = $request->language;
        $grades = DB::table('grades')->where('language', $language)
         ->where('status', '1')->get();
        return response()->json($grades, 200);

    }

    public function getProvinceThroughRMOMobile(Request $request){
        
        $rmo_id = $request->rmo_id;
        $districts = DB::table('provinces')->where('regional_management_office_id', $rmo_id)->get();
        return response()->json($districts, 200);

    }

        public function getSchoolThroughDistrictMobile(Request $request){
        
        $district_id = $request->district_id;
        // $school = DB::table('schools')->where('district_id', $district_id)->get();
        $school = School::first();
        return response()->json($school, 200);

    }

    public function getGradeThroughSchoolMobile(Request $request){
        $school_id = $request->school_id;
     $grades = [];
        $grades = DB::select('
        select 
            g.id,
            g.name,
            g.status
        from grades as g
            left join grades_in_schools as gs
            on g.id = gs.grade_id
            left join schools as s
            on s.id = gs.school_id
        where gs.school_id = '.$school_id.'
         and g.status = \'1\'
        ');
//$data = $grades ? $grades[0] : []; 
        return response()->json($grades, 200);

    }

    public function getDistricts(){
        $districts = District::get();
        return response()->json($districts, 200);
    }
    
}
