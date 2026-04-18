<?php

namespace App\Http\Controllers;

use App\Models\CourseContent;
use App\Http\Requests\StoreCourse_ContentRequest;
use App\Http\Requests\UpdateCourse_ContentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
class CourseContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.course.content_index');
    }


    public function list(Request $request){
        if ($request->ajax()) {

            $data = CourseContent::where('course_id', $request->course_id)->latest()->get();           
          
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('Contents', function ($row) {
            if($row->type == 'file'){
                $contentBody = '<a href="'.asset($row->body).'" target="_blank">Download Content</a>'; 
                return $contentBody;
            }elseif($row->type == 'video'){
               $contentBody = '<a href="'.asset($row->body).'" target="_blank">Download Content
               </a>';
               return $contentBody;
            }else{
                return $row->body;
            }
          
        })
        ->addColumn('actions', function ($row) {
            $actionBtn = '<a onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#modal-form">
            <i class="material-icons">edit</i></i></a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm" 
            onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i></a>';

            return $actionBtn;
        })
        ->rawColumns(['actions', 'Contents'])
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
            if ($request->ajax()) {
                DB::beginTransaction();
                 $newString = $request->title;

               if (strpos($newString, 't') !== false) {
                    $newString = str_replace('t', 'ټ', $newString);
                }
                
                if (strpos($newString, 'j') !== false) {
                    $newString = str_replace('j', 'ځ', $newString);
                }
                
                if (strpos($newString, '.') !== false) {
                    $newString = str_replace('.', '-', $newString);
                }
                $data = [
                    'title' => $newString,
                    'type' => $request->type,
                    'course_id' => $request->course_id,
                    'created_by' => auth()->user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                if ($request->type == "file" && isset($request->file)) {
                    $file = storePDFFiles($request, ['file'], $request->chapter_id);

                    $data['body'] = $file['file']['path'];
                    $data['file_size'] = $file['file']['size'];
                } elseif ($request->type == "audio" && isset($request->audio_file)) {
                    $audio_file = storeAudioFiles($request, ['audio_file'], $request->chapter_id);

                    $data['body'] = $audio_file['audio_file']['path'];
                    $data['file_size'] = $audio_file['audio_file']['size'];
                } elseif ($request->type == "picture" && isset($request->picture_file)) {
                    $audio_file = storeFiles($request, ['picture_file'], $request->chapter_id);

                    $data['body'] = $audio_file['picture_file'];
                }
                else{
                    $data['body'] = $request->body;
                }
                $res = CourseContent::create($data);
                DB::commit();

                
                if (!empty($res->id)) {
                    return response(['id' => $res->id], 201)
                        ->header('Content-Type', 'text/json');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('content.index'))->with('error', $e->getMessage());
        }
    }
 /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $courseContent = CourseContent::find($request->id);
            $newString = $request->title;

           if (strpos($newString, 't') !== false) {
                    $newString = str_replace('t', 'ټ', $newString);
                }
                
                if (strpos($newString, 'j') !== false) {
                    $newString = str_replace('j', 'ځ', $newString);
                }
                
                if (strpos($newString, '.') !== false) {
                    $newString = str_replace('.', '-', $newString);
                }

            $courseContent->title  = $newString;
            $courseContent->type = $request->type;

            if ($request->type == "file" && isset($request->file) && $request->file !== 'undefined') {
                $filePath = str_replace('storage/', '', $courseContent->body);

                // Check if the file exists in the storage
                if (Storage::disk('public')->exists($filePath)) {
                    // Delete the file
                    Storage::disk('public')->delete($filePath);
                    // File deleted successfully
                }
                $file = storePDFFiles($request, ['file'], $request->id);
                $courseContent->body = $file['file']['path'];
                $courseContent->file_size = $file['file']['size'];
            } if ($request->type == "audio" && isset($request->audio_file) && $request->audio_file !== 'undefined') {
                $filePath = str_replace('storage/', '', $courseContent->body);

                // Check if the file exists in the storage
                if (Storage::disk('public')->exists($filePath)) {
                    // Delete the file
                    Storage::disk('public')->delete($filePath);
                    // File deleted successfully
                }
                $audio_file = storeAudioFiles($request, ['audio_file'], $request->id);
                $courseContent->body = $audio_file['audio_file']['path'];
                $courseContent->file_size = $audio_file['audio_file']['size'];
            } if ($request->type == "picture" && isset($request->picture_file) && $request->picture_file !== 'undefined') {
                $filePath = str_replace('storage/', '', $courseContent->body);

                // Check if the file exists in the storage
                if (Storage::disk('public')->exists($filePath)) {
                    // Delete the file
                    Storage::disk('public')->delete($filePath);
                    // File deleted successfully
                }
                $picture_file = storeFiles($request, ['picture_file'], $request->id);
                $courseContent->body = $picture_file['picture_file'];
            }else{
                $courseContent->body = $courseContent->body;
            }
            $result = $courseContent->save();
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
        $course_id = $request->course_id;
        return view('pages.course.content_index', compact('course_id'));
    }


    /**
     * Display the specified resource.
     */
    public function showCourseContent(Request $request)
    {
        if ($request->ajax()) {
            $course_Content = CourseContent::find($request->id);
            $course_Content->course_content = $course_Content->body;
            if(!empty($course_Content->id))
            return response($course_Content, 200)
                  ->header('Content-Type', 'text/json');
        }else{
            return response(['data' => null], 404)
                  ->header('Content-Type', 'text/json');
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
            $courseContent = CourseContent::find($request->id);
            $filePath = str_replace('storage/', '', $courseContent->body);

// Check if the file exists in the storage
if (Storage::disk('public')->exists($filePath)) {
    // Delete the file
    Storage::disk('public')->delete($filePath);
    // File deleted successfully
}
            $result = CourseContent::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }
}
