<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Http\Requests\StoreProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
use App\Models\RegionalManagementOffice;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\School;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regional_management_offices = RegionalManagementOffice::where('status', '1')->get();
        return view('pages.setting.province.index', compact('regional_management_offices'));
    }


    public function list(Request $request){
        if ($request->ajax()) {

            $data = Province::with('regional_management_offices')->orderBy('updated_at', 'desc')->get();           
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('rmo_name', function($row){
                    return $row->regional_management_offices->name;
                })
                ->addColumn('province_status', function ($row) {
                    if($row->status){
                        return 'Active'; 
                    }else{
                        return 'In active';
                    }
                  
                })
                ->addColumn('created_at', function ($row) {
                    if($row->created_at){
                        return date("Y-m-d ", strtotime($row->created_at));
                    }else{
                        return '';
                    }
                })
                ->addColumn('updated_at', function ($row) {
                    if($row->updated_at){
                        return date("Y-m-d ", strtotime($row->updated_at));
                    }else{
                        return '';
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
                $number = Province::where('number', $request->number)->get();
                if(count($number) != 0){
                    return response(['message' => 'The number is already exist.'], 400)
                        ->header('Content-Type', 'text/json');
                }
                DB::beginTransaction();
                $result = Province::create($request->input());
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
            $regionalManagementOffice = Province::find($request->id);
            $regionalManagementOffice->rmo_name = $regionalManagementOffice->regional_management_offices->name; 
            $regionalManagementOffice->province_status = $regionalManagementOffice->status ? 'Active' : 'In active'; 
            $regionalManagementOffice->province_created_at = date("Y-m-d ", strtotime($regionalManagementOffice->created_at)); 
            $regionalManagementOffice->province_updated_at = date("Y-m-d ", strtotime($regionalManagementOffice->updated_at)); 
            $regionalManagementOffice->loadContents();
            if(!empty($regionalManagementOffice->id))
            return response($regionalManagementOffice, 200)
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
            $province = Province::find($request->id);
    
            // Check if the number has changed in the request
            if ($province->number !== $request->number) {
                $existingProvince = Province::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existingProvince) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }
            $province->number = $request->number;
            $province->name = $request->name;
            $province->status = $request->status;
            $province->regional_management_office_id = $request->regional_management_office_id;
    
            $result = $province->save();
    
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
             $rmo = Province::findOrFail($request->id);
             
             // Check if the RMO has child provinces
             if ($rmo->districts()->exists()) {
                 return response()->json(['message' => 'Cannot delete parent object. Please delete the child districts first.'], 400);
             }
             
             $result = $rmo->delete();
             
             if ($result) {
                 return response()->json(['message' => 'Province deleted successfully.'], 200);
             } else {
                 return response()->json(['message' => 'Failed to delete RMO.'], 400);
             }
         }
     }
    // public function destroy(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $result = Province::destroy($request->id);

    //         $districts = DB::table('districts')->where('province_id', $request->id)->get();
    //         foreach($districts as $district){
    //             District::destroy($district->id);
    //             $schools = DB::table('schools')->where('district_id', $district->id)->get();
    //             foreach($schools as $school){
    //                 School::destroy($school->id);
    //             }
    //         }
    //         if (!empty($result))
    //             return response([$result], 200)
    //                 ->header('Content-Type', 'text/json');
    //         else
    //             return response([$result], 400)
    //                 ->header('Content-Type', 'text/json');
    //     }
    // }

    public function getProvincesThroughRMO(Request $request){
        $rmo_id = $request->post('rmo_id');
        $provinces = DB::table('provinces')->where('regional_management_office_id', $rmo_id)->get();
        $html = '<option value="">Select</option>';
        foreach($provinces as $province){
            $html.='<option value="'.$province->id.'">'.$province->number. '-'.$province->name.'</option>';
        }
        return $html;
    }

public function getProvinces(){
    $provinces = Province::where('status', '1')->get();
    return response()->json($provinces, 200);
}
}
