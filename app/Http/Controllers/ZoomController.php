<?php

namespace App\Http\Controllers;
use App\Http\Traits\MeetingZoomTrait;
use Illuminate\Http\Request;
use App\Models\ZoomMeeting;
use App\Models\UserMeetingList;
use MacsiDigital\Zoom\Facades\Zoom;
use Illuminate\Support\Facades\DB;
class ZoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     use MeetingZoomTrait;
    public function index()
    {
        return view('pages.setting.zoom.index');
    }


    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = ZoomMeeting::query()->orderBy('updated_at', 'desc')->get();
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
       $meeting = $this->createMeeting($request);
      

       DB::beginTransaction();
       $result =  ZoomMeeting::create([
                    'user_id' => auth()->user()->id,
                    'meeting_id' => $meeting->id,
                    'topic' => $request->topic,
                    'start_at' => $request->start_at,
                    'duration' => $meeting->duration,
                    'password' => $meeting->password,
                    'start_url' => $meeting->start_url,
                    'join_url' => $meeting->join_url,
            ]);
       DB::commit();  
           if(!empty($result->id))
           {
            $response = [
                'meeting_info' => [
                    'topic'=> $result->topic,
                    'duration'=> $result->duration,
                    'start_date_time' => $result->start_at,
                    'meeting_url' => $result->join_url,
                    'meeting_password' => $result->password,
                    // Add other desired user details
                ],
            ];
               return response($response)
               ->header('Content-Type', 'text/json');
           }

    } catch (Exception $e) {
        DB::rollBack();
        return redirect(route('zoom_meeting.index'))->with('error',$e->getMessage());
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    
     public function shareMeeting(Request $request)
{
    $created_user_id = auth()->user()->id;
    
    
    if ($request->has('user_ids') && $request->user_ids != null) {
        $userIds = explode(',', $request->user_ids);
    
        foreach ($userIds as $userId) {
          
                $userShareMeeting = new UserMeetingList();
                $userShareMeeting->user_id = $userId;
                $userShareMeeting->topic = $request->topic;
                $userShareMeeting->start_at = $request->start_at;
                $userShareMeeting->duration = $request->duration;
                $userShareMeeting->meeting_password = $request->meeting_password;
                $userShareMeeting->meeting_url = $request->meeting_url;
                $userShareMeeting->state = '1';
                $userShareMeeting->created_by = $created_user_id;
                $userShareMeeting->save();
        }
    
        return response()->json(['message' => 'Meeting Link Successfully shared']);
    }
    
    // Return error response if student_ids parameter is missing or empty
    return response()->json(['error' => 'Meeting link is not shared'], 400);
}


public function ListOfAvailableMeetings(Request $request){
    $user_id = auth()->user()->id;

    $listOfMeetings = DB::select('select 
                    uml.topic,                
                    uml.start_at,
                    uml.duration,
                    uml.meeting_url,
                    uml.meeting_password
                from user_meeting_lists as uml
                where uml.user_id  = '.$user_id.'');

            if($listOfMeetings == []){
                return response(['message' => 'There is not any meeting available'], 422)
                    ->header('Content-Type', 'text/json');
            }else{
                return response()->json($listOfMeetings, 200);
            }   

}

public function ListOfCreateMeetingUsers(Request $request){
    $user_id = auth()->user()->id;

    $listOfMeetings = DB::select('select 
                    zm.topic,                
                    zm.start_at,
                    zm.duration,
                    zm.join_url as meeting_url,
                    zm.password as meeting_password
                from zoom_meetings as zm
                where zm.user_id  = '.$user_id.'');

            if($listOfMeetings == []){
                return response(['message' => 'No meeting is created by this user'], 422)
                    ->header('Content-Type', 'text/json');
            }else{
                return response()->json($listOfMeetings, 200);
            }   

}
}
