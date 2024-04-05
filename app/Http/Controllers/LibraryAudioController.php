<?php

namespace App\Http\Controllers;

use App\Models\LibraryAudio;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Http\Requests\StoreIqraKitRequest;
use App\Http\Requests\UpdateIqraKitRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;

class LibraryAudioController extends Controller
{ /**
    * Display a listing of the resource.
    */
   public function index()
   {
    $subjects = Subject::where('status', '1')->get();
       return view('pages.library.audio.index', compact('subjects'));
   }

   public function list(Request $request){
       if ($request->ajax()) {

        $data = LibraryAudio::with('subjects')->withCount('library_audio_contents')->orderBy('updated_at', 'desc')->get();          
           return Datatables::of($data)
               ->addIndexColumn()
               ->addColumn('subject_name', function($row){

                return $row->subjects->name;
                })
               ->addColumn('library_audio_status', function ($row) {
                   if($row->status){
                       return 'Active'; 
                   }else{
                       return 'In active';
                   }
               })
               ->addColumn('library_audio_content_count', function ($row) {
                return $row->library_audio_contents->count();
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
                       <a class="dropdown-item" href="'.route('library_audio_content.show', $row->id).'"><i class="material-icons">add</i></i> Library Audio Content</a>
                   </div>
               </div>';
                   return $actionBtn;
               })
               ->rawColumns(['actions', 'kit_content'])
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
                $res = LibraryAudio::create($data);
                DB::commit();

                
                if (!empty($res->id)) {
                    return response(['id' => $res->id], 201)
                        ->header('Content-Type', 'text/json');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('iqrakit.index'))->with('error', $e->getMessage());
        }
    }
 /**
     * Update the specified resource in storage.
     */


    public function update(Request $request)
    {
        if ($request->ajax()) {

            $libraryAudio = LibraryAudio::find($request->id);
    
            // Check if the number has changed in the request
            if ($libraryAudio->number !== $request->number) {
                $existinglibraryAudio = LibraryAudio::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existinglibraryAudio) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }
            $libraryAudio->number  = $request->number;
            $libraryAudio->subject_id = $request->subject_id;
            $libraryAudio->status = $request->status;
            $libraryAudio->language = $request->language;
            $libraryAudio->description = $request->description;
            $result = $libraryAudio->save();
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
            $libraryAudio = LibraryAudio::find($request->id);
    
            if ($libraryAudio) {
                $libraryAudio->library_audio_status = $libraryAudio->status ? 'Active' : 'In active'; 
                $libraryAudio->subject_name = $libraryAudio->subjects->name; 
                // Load the related contents for the chapter
                $libraryAudio->loadContents();
    
                return response()->json($libraryAudio, 200)
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
            $result = LibraryAudio::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }



    public function libraryAudioList(){
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
                        la.id as id,
                        s.name as title,
                        la.description,
                        count(lac.id) as audio_content_count
                    from library_audios as la
                    left join subjects as s
                        on s.id = la.subject_id
                    left join library_audio_contents as lac
                        on la.id = lac.library_audio_id    
                    where la.language = \''.$grade_language.'\''
                    );

                if($subjects == []){
                    return response(['message' => 'There is not any library audio list exist'], 422)
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

    public function libraryAudioContent(Request $request){
        $library_audio_id = $request->library_audio_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if($user->role === 'student' || $user->role === 'teacher'){
        // $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
        // $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
        // if($user == NULL || $grade_id == NULL){
        //     return response(['message' => 'The user is not registered'], 400)
        //         ->header('Content-Type', 'text/json');
        // }
    //     $library_audio = [];
    //     $lvcCount = DB::select('select 
    //    count(lvc.id) as library_audio_count
    // from library_audio_contents as lvc
    // where lvc.library_audio_id  = '.$library_audio_id .'');
    // $library_audio['library_audio_count'] = $lvcCount[0]->library_audio_count;
        $library_audio = DB::select('select 
                    lac.library_audio_id as id,                
                    lac.title,
                    lac.body as file_path
                    from library_audio_contents as lac
                    where lac.library_audio_id  = '.$library_audio_id .'');

                if($library_audio == []){
                    return response(['message' => 'There is not any Content exist'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($library_audio, 200);
                }

            }
            else{
                return response(['message' => 'The user is not registered as student/teacher'], 422)
                ->header('Content-Type', 'text/json');
            }      

    }
}
