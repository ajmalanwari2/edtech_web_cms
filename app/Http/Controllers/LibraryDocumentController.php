<?php

namespace App\Http\Controllers;

use App\Models\LibraryDocument;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Http\Requests\StoreIqraKitRequest;
use App\Http\Requests\UpdateIqraKitRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class LibraryDocumentController extends Controller
{ /**
    * Display a listing of the resource.
    */
   public function index()
   {
    $subjects = Subject::where('status', '1')->get();
       return view('pages.library.document.index', compact('subjects'));
   }

   public function list(Request $request){
       if ($request->ajax()) {

        $data = LibraryDocument::with('subjects')->withCount('libraryDocumentContents')->orderBy('updated_at', 'desc')->get();          
           return Datatables::of($data)
               ->addIndexColumn()
               ->addColumn('subject_name', function($row){

                return $row->subjects->name;
                })
               ->addColumn('library_document_status', function ($row) {
                   if($row->status){
                       return 'Active'; 
                   }else{
                       return 'In active';
                   }
               })
               ->addColumn('libraryDocumentContent_count', function ($row) {
                return $row->libraryDocumentContents->count();
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
                       <a class="dropdown-item" href="'.route('library_document_content.show', $row->id).'"><i class="material-icons">add</i></i> Library Document Content</a>
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
                $res = LibraryDocument::create($data);
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

            $libraryDocument = LibraryDocument::find($request->id);
    
            // Check if the number has changed in the request
            if ($libraryDocument->number !== $request->number) {
                $existinglibraryDocument = LibraryDocument::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existinglibraryDocument) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }
            $libraryDocument->number  = $request->number;
            $libraryDocument->subject_id = $request->subject_id;
            $libraryDocument->status = $request->status;
            $libraryDocument->description = $request->description;
            $libraryDocument->language = $request->language;
            $result = $libraryDocument->save();
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
            $libraryDocument = LibraryDocument::find($request->id);
    
            if ($libraryDocument) {
                $libraryDocument->library_document_status = $libraryDocument->status ? 'Active' : 'In active'; 
                $libraryDocument->subject_name = $libraryDocument->subjects->name; 
                // Load the related contents for the chapter
                $libraryDocument->loadContents();
    
                return response()->json($libraryDocument, 200)
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
            $libraryDocContents = DB::table('library_document_contents')->where('library_document_id', $request->id)->get();
            foreach($libraryDocContents as $libraryDocContent){

$filePath = str_replace('storage/', '', $libraryDocContent->body);

// Check if the file exists in the storage
if (Storage::disk('public')->exists($filePath)) {
    // Delete the file
    Storage::disk('public')->delete($filePath);
    // File deleted successfully
}
libraryDocumentContent::destroy($libraryDocContent->id);

                }
                $result = LibraryDocument::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }


  



    public function libraryDocumentList(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
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
                        ld.id as id,
                        s.name as title,
                        ld.description,
                        (
                            SELECT count(ldc.id) as count
                            FROM library_document_contents AS ldc
                            where ld.id = ldc.library_document_id
                        ) AS count
                    from library_documents as ld
                    left join subjects as s
                        on s.id = ld.subject_id    
                    where ld.language = \''.$grade_language.'\''
                    );

                if($subjects == []){
                    return response(['message' => 'There is not any library document list exist'], 422)
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

    public function libraryDocumentContent(Request $request){
        $library_document_id = $request->library_document_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if($user->role === 'student' || $user->role === 'teacher'){
        // $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
        // $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
        // if($user == NULL || $grade_id == NULL){
        //     return response(['message' => 'The user is not registered'], 400)
        //         ->header('Content-Type', 'text/json');
        // }
    //     $library_documents = [];
    //     $ldCount = DB::select('select 
    //    count(ldc.id) as library_doc_count
    // from library_document_contents as ldc
    // where ldc.library_document_id  = '.$library_document_id .'');
    // $library_documents['library_document_count'] = $ldCount[0]->library_doc_count;
        $library_documents = DB::select('select 
                        ldc.library_document_id as id,                
                        ldc.title,
                        ldc.body as file_path,
                        ldc.file_size
                    from library_document_contents as ldc
                    where ldc.library_document_id  = '.$library_document_id .'');

                if($library_documents == []){
                    return response(['message' => 'There is not any content exist'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($library_documents, 200);
                }

            }
            else{
                return response(['message' => 'The user is not registered as student/teacher'], 422)
                ->header('Content-Type', 'text/json');
            }      

    }


    public function libraryQuranKarim(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

    $libraryQuranKarim = [];
    if($user->role === 'student' || $user->role === 'teacher'){
        $document = DB::select('select 
                        ld.id as id,
                        s.name as title,
                        ld.description
                    from library_documents as ld
                    left join subjects as s
                        on s.id = ld.subject_id
                    where s.name = \'قرآنکریم\''
                    );
                    $documentId = $document && $document[0] ? $document[0]->id : NULL;
                    $library_documents;
                    if($documentId != NULL){
                        $library_documents = DB::select('select 
                        ldc.library_document_id as id,                
                        ldc.title,
                        ldc.body as path,
                        ldc.file_size
                    from library_document_contents as ldc
                    where ldc.library_document_id  = '.$documentId.'');
                    }else{
                        $library_documents = [];
                    }
                   
                $libraryQuranKarim['document_id'] =  $document && $document[0] ? $document[0]->id : NULL;
                $libraryQuranKarim['document_title'] =  $document && $document[0] ? $document[0]->title : NULL;
                $libraryQuranKarim['document_description'] =  $document && $document[0] ? $document[0]->description : NULL;
                $libraryQuranKarim['document_contents'] = $library_documents;

                $video = DB::select('select 
                ld.id as id,
                s.name as title,
                ld.description
            from library_videos as ld
            left join subjects as s
                on s.id = ld.subject_id
            where s.name = \'قرآنکریم\''
            );
            $videoId = $video && $video[0] ? $video[0]->id : NULL;
            $library_videos;
            if($videoId != NULL){
                $library_videos = DB::select('select 
                ldc.library_video_id as id,                
                ldc.title,
                ldc.body as path
            from library_video_contents as ldc
            where ldc.library_video_id  = '.$videoId.'');
            }else{
                $library_videos = [];
            }
            
        $libraryQuranKarim['video_id'] =  $video && $video[0] ? $video[0]->id : NULL;
        $libraryQuranKarim['video_title'] =  $video && $video[0] ? $video[0]->title : NULL;
        $libraryQuranKarim['video_description'] =  $video && $video[0] ? $video[0]->description : NULL;
        $libraryQuranKarim['video_contents'] = $library_videos;

        $audio = DB::select('select 
                        ld.id as id,
                        s.name as title,
                        ld.description
                    from library_audios as ld
                    left join subjects as s
                        on s.id = ld.subject_id
                    where s.name = \'قرآنکریم\''
                    );
                    $audioId = $audio && $audio[0] ? $audio[0]->id : '';
                    $library_audios;
                    if($audioId != NULL){
                        $library_audios = DB::select('select 
                        ldc.library_audio_id as id,                
                        ldc.title,
                        ldc.body as path,
                        ldc.file_size
                    from library_audio_contents as ldc
                    where ldc.library_audio_id  = '.$audioId.'');
                    }else{
                        $library_audios = [];
                    }
                   
                $libraryQuranKarim['audio_id'] =  $audio && $audio[0] ? $audio[0]->id : NULL;
                $libraryQuranKarim['audio_title'] =  $audio && $audio[0] ? $audio[0]->title : NULL;
                $libraryQuranKarim['audio_description'] =  $audio && $audio[0] ? $audio[0]->description : NULL;
                $libraryQuranKarim['audio_contents'] = $library_audios;


                if($libraryQuranKarim == []){
                    return response(['message' => 'There is not any library document list exist'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($libraryQuranKarim, 200);
                }

            }
            else{
                return response(['message' => 'The user is not registered as student/teacher'], 422)
                ->header('Content-Type', 'text/json');
            }      

    }

}
