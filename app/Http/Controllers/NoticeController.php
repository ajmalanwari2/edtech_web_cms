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
use App\Models\Notice;
use App\Models\ReadNotice;
use Illuminate\Http\Request;
use Validator;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.setting.notice.index');
    }


    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Notice::query()->orderBy('updated_at', 'desc')->get();
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

                $number = Notice::where('number', $request->number)->get();
                if(count($number) != 0){
                    return response(['message' => 'The number is already exist.'], 400)
                        ->header('Content-Type', 'text/json');
                }

                DB::beginTransaction();
                $result = Notice::create($request->input());
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
            $notice = Notice::find($request->id);
            $notice->notice_status = $notice->status ? 'Active' : 'In active'; 
            if(!empty($notice->id))
            return response($notice, 200)
                  ->header('Content-Type', 'text/json');
        }else{
            return response(['data' => null], 404)
                  ->header('Content-Type', 'text/json');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $notice = Notice::find($request->id);
    
            // Check if the number has changed in the request
            if ($notice->number !== $request->number) {
                $existingNotice = Notice::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existingNotice) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }

            $notice->number = $request->number;
            $notice->title = $request->title;
            $notice->description = $request->description;
            $notice->status = $request->status;
            $notice->role = $request->role;
           
            $result = $notice->save();
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
             $notice = Notice::findOrFail($request->id);
             
             
             $result = $notice->delete();
             
             if ($result) {
                 return response()->json(['message' => 'Notice deleted successfully.'], 200);
             } else {
                 return response()->json(['message' => 'Failed to delete Notice.'], 400);
             }
         }
     }

     public function noticeList(){
        $user_id = auth()->user()->id;
       
        $user = User::find($user_id);
        if($user->role === 'student'){
        $notices = DB::select('SELECT
        n.id AS notice_id, n.number, n.title, n.description, n.role, n.created_at as notice_created_datetime, 
        IF(rn.notice_read_datetime IS NOT NULL, \'true\', \'false\') AS read_state
    FROM
        notices AS n
    LEFT JOIN
        read_notices AS rn ON n.id = rn.notice_id AND rn.user_id = '.$user_id.'
    WHERE
        n.role = \'student\'');

                if($notices == []){
                    return response(['message' => 'No notice available for student'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($notices, 200);
                }

            }elseif($user->role === 'teacher'){
                $notices = [];
                $unread_notices = DB::select('SELECT
                n.id AS notice_id, n.number, n.title, n.description, n.role, 
                IF(rn.notice_read_datetime IS NOT NULL, \'true\', \'false\') AS read_state
            FROM
                notices AS n
            LEFT JOIN
                read_notices AS rn ON n.id = rn.notice_id AND rn.user_id = '.$user_id.'
            WHERE
                n.role = \'teacher\'');
        
                        if($notices == []){
                            return response(['message' => 'No notice available for teacher'], 422)
                                ->header('Content-Type', 'text/json');
                        }else{
                            return response()->json($notices, 200);
                        }
        
                    }elseif($user->role === 'parent'){
                        $notices = [];
                        $unread_notices = DB::select('SELECT
                        n.id AS notice_id, n.number, n.title, n.description, n.role, 
                        IF(rn.notice_read_datetime IS NOT NULL, \'true\', \'false\') AS read_state
                    FROM
                        notices AS n
                    LEFT JOIN
                        read_notices AS rn ON n.id = rn.notice_id AND rn.user_id = '.$user_id.'
                    WHERE
                        n.role = \'parent\'');
        // $read_notices = DB::select('SELECT
        // n.id as notice_id, n.number, n.title,n.description, n.role
        //  from notices as n
        //  where n.role = \'teacher\'
        // and n.id IN (SELECT notice_id FROM read_notices where user_id= '.$user_id.')');
                                if($notices == []){
                                    return response(['message' => 'No notice available for parent'], 422)
                                        ->header('Content-Type', 'text/json');
                                }else{
                                    return response()->json($notices, 200);
                                }
                
        }else{
                return response(['message' => 'There is no notice'], 422)
                ->header('Content-Type', 'text/json');
            }      

    }

     
    public function readNotice(Request $request)
    {
       
        try {
            DB::beginTransaction();
    
            $user_id = auth()->user()->id;
            $readNotice = ReadNotice::where('notice_id', $request->notice_id)->where('user_id',  $user_id)->first();
            // Validate the user input
            $validator = Validator::make($request->all(), [
                'notice_id' => 'required|integer',
                'notice_read_datetime' => 'required|date_format:Y-m-d H:i:s',
            ]);
    
            if ($validator->fails()) {
                // Return error response with validation errors
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $validator->errors()
                ], 422);
            }
           if(!empty($readNotice)){
           
            $readNotice->notice_read_datetime = $request->notice_read_datetime;
            $readNotice->save();
           }else{
            $read_notice = [
                'notice_id' =>  $request->notice_id,
                'user_id' =>  $user_id,
                'notice_read_datetime' => $request->notice_read_datetime,
            ];
            ReadNotice::create($read_notice);
           }
      

           
    
            DB::commit();
    
            return response()->json(['message' => 'success'], 200);
    
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


  
}