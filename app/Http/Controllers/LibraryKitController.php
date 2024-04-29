<?php

namespace App\Http\Controllers;

use App\Models\LibraryKit;
use App\Models\libraryKitContent;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Http\Requests\StoreIqraKitRequest;
use App\Http\Requests\UpdateIqraKitRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class LibraryKitController extends Controller
{ /**
    * Display a listing of the resource.
    */
   public function index()
   {
    $subjects = Subject::where('status', '1')->get();
       return view('pages.library.kit.index', compact('subjects'));
   }

   public function list(Request $request){
       if ($request->ajax()) {

        $data = LibraryKit::withCount('library_kit_contents')->orderBy('updated_at', 'desc')->get();          
           return Datatables::of($data)
               ->addIndexColumn()
               ->addColumn('library_kit_status', function ($row) {
                   if($row->status){
                       return 'Active'; 
                   }else{
                       return 'In active';
                   }
               })
               ->addColumn('library_kit_content_count', function ($row) {
                return $row->library_kit_contents->count();
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
                       <a class="dropdown-item" href="'.route('library_kit_content.show', $row->id).'"><i class="material-icons">add</i></i> Library kit Content</a>
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
                    'description' => $request->description,
                    'name' => $request->name,
                    'status' => $request->status,
                    'language' => $request->language,
                    'created_by' => auth()->user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                $res = LibraryKit::create($data);
                DB::commit();

                
                if (!empty($res->id)) {
                    return response(['id' => $res->id], 201)
                        ->header('Content-Type', 'text/json');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('library_kit.index'))->with('error', $e->getMessage());
        }
    }
 /**
     * Update the specified resource in storage.
     */


    public function update(Request $request)
    {
        if ($request->ajax()) {

            $libraryKit = LibraryKit::find($request->id);
    
            // Check if the number has changed in the request
            if ($libraryKit->number !== $request->number) {
                $existinglibraryKit = LibraryKit::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existinglibraryKit) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }
            $libraryKit->number  = $request->number;
            $libraryKit->status = $request->status;
            $libraryKit->name  = $request->name;
            $libraryKit->language  = $request->language;
            $libraryKit->description = $request->description;
            $result = $libraryKit->save();
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
            $libraryKit = LibraryKit::find($request->id);
    
            if ($libraryKit) {
                $libraryKit->library_kit_status = $libraryKit->status ? 'Active' : 'In active'; 
                // Load the related contents for the chapter
                $libraryKit->loadContents();
    
                return response()->json($libraryKit, 200)
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
            $librarykitContents = DB::table('library_kit_contents')->where('library_kit_id', $request->id)->get();
            foreach($librarykitContents as $librarykitContent){

$filePath = str_replace('storage/', '', $librarykitContent->body);

// Check if the file exists in the storage
if (Storage::disk('public')->exists($filePath)) {
    // Delete the file
    Storage::disk('public')->delete($filePath);
    // File deleted successfully
}
libraryKitContent::destroy($librarykitContent->id);

                }
                $result = LibraryKit::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }




    public function libraryKitList(){
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
                        lk.id as id,
                        lk.name as title,
                        lk.description,
                        (
                            SELECT count(lkc.id) as count
                            FROM library_kit_contents AS lkc
                            where lk.id = lkc.library_kit_id
                        ) AS count
                    from library_kits as lk
                    where lk.language = \''.$grade_language.'\''
                    );

                    if($subjects == []){
                    return response(['message' => 'There is not any library kit list exist'], 422)
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

    public function libraryKitContent(Request $request){
        $library_kit_id = $request->library_kit_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if($user->role === 'student' || $user->role === 'teacher'){
        // $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
        // $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
        // if($user == NULL || $grade_id == NULL){
        //     return response(['message' => 'The user is not registered'], 400)
        //         ->header('Content-Type', 'text/json');
        // }
    //     $library_kits = [];
    //     $ldCount = DB::select('select 
    //    count(ldc.id) as library_kit_count
    // from library_kit_contents as ldc
    // where ldc.library_kit_id  = '.$library_kit_id .'');
    // $library_kits['library_kits_count'] = $ldCount[0]->library_kit_count;
        $library_kits = DB::select('select 
                    lkc.library_kit_id as id,                
                    lkc.title,
                    lkc.body as file_path,
                    lkc.file_size
                    from library_kit_contents as lkc
                    where lkc.library_kit_id  = '.$library_kit_id .'');

                if($library_kits == []){
                    return response(['message' => 'There is not any Content exist'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($library_kits, 200);
                }

            }
            else{
                return response(['message' => 'The user is not registered as student/teacher'], 422)
                ->header('Content-Type', 'text/json');
            }      

    }
}
