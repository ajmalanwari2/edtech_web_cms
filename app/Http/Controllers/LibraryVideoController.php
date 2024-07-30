<?php

namespace App\Http\Controllers;

use App\Models\LibraryVideo;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Http\Requests\StoreIqraKitRequest;
use App\Http\Requests\UpdateIqraKitRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;

class LibraryVideoController extends Controller
{ /**
    * Display a listing of the resource.
    */
   public function index()
   {
    $subjects = Subject::where('status', '1')->get();
       return view('pages.library.video.index', compact('subjects'));
   }

   public function list(Request $request){
       if ($request->ajax()) {

        $data = LibraryVideo::with('subjects')->withCount('library_video_contents')->orderBy('updated_at', 'desc')->get();          
           return Datatables::of($data)
               ->addIndexColumn()
               ->addColumn('subject_name', function($row){

                return $row->subjects->name;
                })
               ->addColumn('library_video_status', function ($row) {
                   if($row->status){
                       return 'Active'; 
                   }else{
                       return 'In active';
                   }
               })
               ->addColumn('library_video_content_count', function ($row) {
                return $row->library_video_contents->count();
                })
               ->addColumn('actions', function ($row) {
                   $actionBtn = '<div class="dropdown ml-auto">
                   <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                       <i class="material-icons">more_vert</i>
                   </a>
                   <div class="dropdown-menu dropdown-menu-right">
                   <a class="dropdown-item" onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#modal-form">
                   <i class="material-icons">edit</i></i> Edit</a>
                   <a class="dropdown-item" onclick="loadRecord('.$row->id.')" href="javascript:void(0)" 
                   data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i> View</a>
                   <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm" 
               onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i> Delete</a>
                       <div class="dropdown-divider"></div>
                       <a class="dropdown-item" href="'.route('library_video_content.show', $row->id).'"><i class="material-icons">add</i></i> Library Video Content</a>
                   </div>
               </div>';
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
                $data = [
                    'number' => $request->number,
                    'subject_id' => $request->subject_id,
                    'description' => $request->description,
                    'status' => $request->status,
                    'language' => $request->language,
                    'created_by' => auth()->user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                $res = LibraryVideo::create($data);
                DB::commit();

                
                if (!empty($res->id)) {
                    return response(['id' => $res->id], 201)
                        ->header('Content-Type', 'text/json');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('library_video.index'))->with('error', $e->getMessage());
        }
    }
 /**
     * Update the specified resource in storage.
     */


    public function update(Request $request)
    {
        if ($request->ajax()) {

            $libraryVideo = LibraryVideo::find($request->id);
    
            // Check if the number has changed in the request
            if ($libraryVideo->number !== $request->number) {
                $existinglibraryVideo = LibraryVideo::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existinglibraryVideo) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }
            $libraryVideo->number  = $request->number;
            $libraryVideo->subject_id = $request->subject_id;
            $libraryVideo->status = $request->status;
            $libraryVideo->description = $request->description;
            $libraryVideo->language = $request->language;
            $result = $libraryVideo->save();
            if (!empty($result))
                return response([$result], 201)
                    ->header('Content-Type', 'text/json');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        if ($request->ajax()) {
            $libraryVideo = LibraryVideo::find($request->id);
    
            if ($libraryVideo) {
                $libraryVideo->library_video_status = $libraryVideo->status ? 'Active' : 'In active'; 
                $libraryVideo->subject_name = $libraryVideo->subjects->name; 
                // Load the related contents for the chapter
                $libraryVideo->loadContents();
    
                return response()->json($libraryVideo, 200)
                ->header('Content-Type', 'text/json');
            }else{
                return response(['data' => null], 404)
                      ->header('Content-Type', 'text/json');
            }
    }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course_Content $course_Content)
    {
        //
    }

   

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $result = libraryVideo::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }



    public function libraryVideoList(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if ($user->last_seen === null) {
            $user->update(['last_seen' => date("Y-m-d H:i:s")]);
        } else {
            $user->update(['last_seen' => date("Y-m-d H:i:s")]);
        }
        $grade_language = NULL;
        if($user->role === 'student'){
        $language = Student::select('language')->where('user_id', $user_id)->get();
        $grade_language = $language && $language[0] ? $language[0]->language : NULL;
        if($user == NULL || $language == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
    }
    if($user->role === 'teacher'){
        $language = Teacher::select('language')->where('user_id', $user_id)->get();
        $grade_language = $language && $language[0] ? $language[0]->language : NULL;
        if($user == NULL || $language == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
    }
    if($grade_language && ($user->role === 'student' || $user->role === 'teacher')){
        $subjects = DB::select('select 
        lv.id as id,
        s.name as title,
        lv.description,
         (
            SELECT count(lvc.id) as count
            FROM library_video_contents AS lvc
            where lv.id = lvc.library_video_id
        ) AS count
        from library_videos as lv
        left join subjects as s
            on s.id = lv.subject_id
        where lv.language = \''.$grade_language.'\''
                    );

                    if($subjects == []){
                    return response(['message' => 'There is not any library video list exist'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($subjects, 200);
                }

            }
            else{
                return response(['message' => 'The user is not registered as student/teacher'], 422)
                ->header('Content-Type', 'text/json');
            }      

    }

    public function libraryVideoContent(Request $request){
        $library_video_id = $request->library_video_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if($user->role === 'student' || $user->role === 'teacher'){
        // $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
        // $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
        // if($user == NULL || $grade_id == NULL){
        //     return response(['message' => 'The user is not registered'], 400)
        //         ->header('Content-Type', 'text/json');
        // }
    //     $library_videos = [];
    //     $lvcCount = DB::select('select 
    //    count(lvc.id) as library_video_count
    // from library_video_contents as lvc
    // where lvc.library_video_id  = '.$library_video_id .'');
    // $library_videos['library_video_count'] = $lvcCount[0]->library_video_count;
        $library_videos = DB::select('select 
                        lvc.library_video_id as id,                
                        lvc.title,
                        lvc.body as file_path
                    from library_video_contents as lvc
                    where lvc.library_video_id  = '.$library_video_id .'');

                if($library_videos == []){
                    return response(['message' => 'There is not any content exist'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($library_videos, 200);
                }

            }
            else{
                return response(['message' => 'The user is not registered as student/teacher'], 422)
                ->header('Content-Type', 'text/json');
            }      

    }
}
