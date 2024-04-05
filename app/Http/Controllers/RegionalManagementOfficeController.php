<?php

namespace App\Http\Controllers;

use App\Models\RegionalManagementOffice;
use App\Models\Province;
use App\Models\District;
use App\Http\Requests\StoreRegionalManagementOfficeRequest;
use App\Http\Requests\UpdateRegionalManagementOfficeRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;

class RegionalManagementOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.setting.RMO.index');
    }


    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = RegionalManagementOffice::query()->orderBy('updated_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status_name', function ($row) {
                    if ($row->status) {
                        return 'Active';
                    } else {
                        return 'Inactive';
                    }
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord(' . $row->id . ')" href="javascript:void(0)" data-toggle="modal" data-target="#modal-form">
                    <i class="material-icons">edit</i></a> <a onclick="loadRecord(' . $row->id . ')" href="javascript:void(0)" 
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons" style="color:SlateBlue">visibility</i></a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm" 
                    onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons" style="color:darkorange">delete</i></a>';
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
            if ($request->ajax()) 
            {

                $number = RegionalManagementOffice::where('number', $request->number)->get();
                if(count($number) != 0){
                    return response(['message' => 'The number is already exist.'], 400)
                        ->header('Content-Type', 'text/json');
                }

                DB::beginTransaction();
                \Log::info($request->input());
                $result = RegionalManagementOffice::create($request->input());
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
            $regionalManagementOffice = RegionalManagementOffice::find($request->id);
            $regionalManagementOffice->rmo_status = $regionalManagementOffice->status ? 'Active' : 'In active'; 
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
     * Show the form for editing the specified resource.
     */
    public function edit(RegionalManagementOffice $regionalManagementOffice)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $regionalManagementOffice = RegionalManagementOffice::find($request->id);
    
            // Check if the number has changed in the request
            if ($regionalManagementOffice->number !== $request->number) {
                $existingRMO = RegionalManagementOffice::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existingRMO) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }

            $regionalManagementOffice->number = $request->number;
            $regionalManagementOffice->name = $request->name;
            $regionalManagementOffice->abbreviation = $request->abbreviation;
            $regionalManagementOffice->status = $request->status;
            $regionalManagementOffice->contact_name = $request->contact_name;
            $regionalManagementOffice->phone = $request->phone;
            $regionalManagementOffice->email = $request->email;
            $regionalManagementOffice->gps = $request->gps;
            if(isset($request->status) && $request->status == '0'){
                Province::where('regional_management_office_id', $request->id)->update(['status' => '0']);
                $provinces = Province::where('regional_management_office_id', $request->id)->get();
                foreach($provinces as $province){
                    District::where('province_id', $province->id)->update(['status' => '0']);
                    $districts = District::where('province_id', $province->id)->get();
                    foreach($districts as $district){
                        School::where('district_id', $district->id)->update(['status' => '0']);
                    }
                }
            }
            $result = $regionalManagementOffice->save();
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
             $rmo = RegionalManagementOffice::findOrFail($request->id);
             
             // Check if the RMO has child provinces
             if ($rmo->provinces()->exists()) {
                 return response()->json(['message' => 'Cannot delete parent object. Please delete the child provinces first.'], 400);
             }
             
             $result = $rmo->delete();
             
             if ($result) {
                 return response()->json(['message' => 'RMO deleted successfully.'], 200);
             } else {
                 return response()->json(['message' => 'Failed to delete RMO.'], 400);
             }
         }
     }
    // public function destroy(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $rmo = RegionalManagementOffice::findOrFail($request->id);
    //         $result = $rmo->delete();
    
    //         $provinces = DB::table('provinces')->where('regional_management_office_id', $request->id)->get();
    //         foreach($provinces as $province){
    //             Province::where('id', $province->id)->delete();
    //             $districts = DB::table('districts')->where('province_id', $province->id)->get();
    //             foreach($districts as $district){
    //                 $schools = DB::table('schools')->where('school_id', $district->id)->get();
    //                 District::where('id', $district->id)->delete();
    //                 foreach($schools as $school){
    //                     School::where('id', $school->id)->delete();
    //                 }
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


    public function getRMOThroughProvince(Request $request)
    {
        $province_id = $request->province_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
    
        if ($user->role === 'student') {
            $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
            $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
    
            if ($user == NULL || $grade_id == NULL) {
                return response(['message' => 'The user is not registered'], 400)
                    ->header('Content-Type', 'text/json');
            }
    
            $rmo = DB::select('SELECT 
                    r.name AS center_name,
                    r.contact_name,
                    r.phone,
                    r.email,
                    r.gps
                FROM regional_management_offices AS r
                LEFT JOIN provinces AS p ON r.id = p.regional_management_office_id
                WHERE p.id = '.$province_id.'
                LIMIT 1');
    
            if (empty($rmo)) {
                return response(['message' => 'There is no center for this province'], 422)
                    ->header('Content-Type', 'text/json');
            } else {
                return response()->json($rmo[0], 200);
            }
        } else {
            return response(['message' => 'The user is not registered as a student'], 422)
                ->header('Content-Type', 'text/json');
        }
    }
}