<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Chapter;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Storage;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::where('status', '1')->get();
        $subjects = Subject::where('status', '1')->get();
        return view('pages.setting.content.index', compact('grades', 'subjects'));
    }


    public function list(Request $request){
        if ($request->ajax()) {
            $data = Content::where('chapter_id', $request->chapter_id)->latest()->get();
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
            <i class="material-icons">edit</i></i></a><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm"
            onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i></a>';

            return $actionBtn;
        })
        ->rawColumns(['actions', 'Contents'])
        ->make(true);

        }
    }

    // public function list(Request $request)
    // {
    //     if ($request->ajax()) {

    //         $data = DB::select('
    //         select
    //         school.id as school_id,
    //         school.name as school_name,
    //         grade.id as grade_id,
    //         grade.name as grade_name,
    //         subject.id as subject_id,
    //         subject.name as subject_name

    //         from
    //         schools AS school
    //         join grades_in_schools as grade_in_school on grade_in_school.school_id=school.id
    //         JOIN grades AS grade ON grade.id = grade_in_school.grade_id
    //         join subjects_in_grades as subject_in_grade on subject_in_grade.grade_id = grade.id
    //         join subjects as subject on subject.id = subject_in_grade.subject_id
    //     ');
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('actions', function ($row) {
    //                 $actionBtn = '<a  onclick="loadRecord(' . $row->school_id . ',' . $row->grade_id . ',' . $row->subject_id . ')" href="javascript:void(0)"
    //                 data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>
    //                 <a onclick="setHiddenIDs(' . $row->school_id . ',' . $row->grade_id . ',' . $row->subject_id . ')" href="javascript:void(0)" data-toggle="modal" data-target="#modal-form" > <i class="material-icons" style="color:darkgreen">add</i></a>';

    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['actions'])
    //             ->make(true);
    //     }
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if ($request->ajax()) {
                DB::beginTransaction();
                $data = [
                    'title' => $request->title,
                    'type' => $request->type,
                    'chapter_id' => $request->chapter_id,
                    'created_by' => auth()->user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                if ($request->type == "file" && isset($request->file)) {
                    $file = storePDFFiles($request, ['file'], $request->chapter_id);

                    $data['body'] = $file['file']['path']; // Store the file path
    
                    // You can also store the file size
                    $data['file_size'] = $file['file']['size'];
                } elseif ($request->type == "audio" && isset($request->audio_file)) {
                    $audio_file = storeAudioFiles($request, ['audio_file'], $request->chapter_id);

                    $data['body'] = $audio_file['audio_file']['path']; // Store the file path
    
                    // You can also store the file size
                    $data['file_size'] = $audio_file['audio_file']['size'];
                } elseif ($request->type == "picture" && isset($request->picture_file)) {
                    $picture_file = storeFiles($request, ['picture_file'], $request->chapter_id);

                    $data['body'] = $picture_file['picture_file'];
                }
                else{
                    $data['body'] = $request->body;
                }
                $res = Content::create($data);
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

     public function show(Request $request)
     {
        $subject_id = $request->subject_id;
         $chapter_id = $request->chapter_id;
         return view('pages.setting.content.content_index', compact('subject_id', 'chapter_id'));
     }

     public function showContent(Request $request)
     {
         if ($request->ajax()) {
             $chapter_Content = Content::find($request->id);
             $chapter_Content->chapter_content = $chapter_Content->body;
             if(!empty($chapter_Content->id))
             return response($chapter_Content, 200)
                   ->header('Content-Type', 'text/json');
         }else{
             return response(['data' => null], 404)
                   ->header('Content-Type', 'text/json');
         }
     }

    public function download($filename)
    {

        $path = storage_path('app/public/' . $filename);

        if (!Storage::disk('public')->exists($filename)) {
            abort(404);
        }

        return response()->download($path);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $chapterContent = Content::find($request->id);
            $chapterContent->title  = $request->title;
            $chapterContent->type = $request->type;
            if ($request->type == "file" && isset($request->file) && $request->file !== 'undefined') {
                $file = storePDFFiles($request, ['file'], $request->id);
                $chapterContent->body = $file['file']['path'];
                $chapterContent->file_size = $file['file']['size'];
            } if ($request->type == "audio" && isset($request->audio_file) && $request->audio_file !== 'undefined') {
                $audio_file = storeAudioFiles($request, ['audio_file'], $request->id);
                $chapterContent->body = $audio_file['audio_file']['path'];
                $chapterContent->file_size = $audio_file['audio_file']['size'];
            } if ($request->type == "picture" && isset($request->picture_file) && $request->picture_file !== 'undefined') {
                $picture_file = storeFiles($request, ['picture_file'], $request->id);
                $chapterContent->body = $picture_file['picture_file'];
            }
             else{
                $chapterContent->body = $request->body;
            }
            $result = $chapterContent->save();
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
            $result = Content::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }
}
