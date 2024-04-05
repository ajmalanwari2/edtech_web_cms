<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\models\Content;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function list(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
            SELECT
                c.id,
                c.number,
                c.updated_at,
                c.name,
                c.status,
                c.total_quiz_time,
                g.name AS grade_name,
                g.id AS grade_id,
                s.name AS subject_name,
                s.id AS subject_id,
                MAX(q.id) AS quiz_included,
                GROUP_CONCAT(DISTINCT sl.type SEPARATOR ", ") AS lesson_types
            FROM chapters AS c
            JOIN grades AS g ON g.id = c.grade_id
            JOIN subjects AS s ON s.id = c.subject_id
            LEFT JOIN subject_lessons AS sl ON c.id = sl.chapter_id
            LEFT JOIN quizes AS q ON c.id = q.chapter_id
            GROUP BY c.id
            ORDER BY c.updated_at DESC
            ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('chapter_status', function ($row) {
                    return $row->status ? 'Active' : 'Inactive';
                })
                ->addColumn('lesson_types', function ($row) {
                    return $row->lesson_types ?? 'N/A';
                })
                ->addColumn('quiz_included', function ($row) {
                    return $row->quiz_included ? 'Yes' : 'No';
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<div class="dropdown ml-auto">
                    <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                        <i class="material-icons">more_vert</i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#edit-modal-form">
                    <i class="material-icons">edit</i></i> Edit</a>
                    <a class="dropdown-item" onclick="loadRecord('.$row->id.')" href="javascript:void(0)"
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i> View</a>
                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm"
                onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i> Delete</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="'.route('content.show', $row->id).'"><i class="material-icons">add</i></i> Add Content</a>
                        <a class="dropdown-item" href="'.route('quiz.show', $row->id).'"><i class="material-icons">add</i></i> Add Quiz</a>
                    </div>
                </div>';
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
            if ($request->ajax()) {
                DB::beginTransaction();
                $data = $request->input();

                foreach ($data as $item) {
                    if(isset($item['number'])){
                    $item['created_by'] = auth()->user()->id;
                    $result = Chapter::create($item);
                }
                }

                DB::commit();

                return response(['success' => true], 201)
                    ->header('Content-Type', 'text/json');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('chapter.index'))->with('error', $e->getMessage());
        }
    }




    // public function store(Request $request)
    // {

    //     try {
    //         if ($request->ajax())
    //         {
    //             DB::beginTransaction();
    //             $data = $request->input();
    //             $data['created_by'] = auth()->user()->id;
    //             $result = Chapter::create($data);
    //             DB::commit();
    //                 if(!empty($result->id))
    //                 {
    //                     return response(['id' => $result->id], 201)
    //                     ->header('Content-Type', 'text/json');
    //                 }
    //         }
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return redirect(route('subject.index'))->with('error',$e->getMessage());
    //     }
    // }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $chapter = Chapter::find($request->id);
    
            if ($chapter) {
                $chapter->chapter_status = $chapter->status ? 'Active' : 'Inactive';
                $chapter->grade_name = $chapter->grades->name;
                $chapter->subject_name = $chapter->subjects->name;
    
                // Load the related contents for the chapter
                $chapter->loadContents();
    
                return response()->json($chapter);
            }
        }
    
        return response()->json(['data' => null], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chapter $chapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $chapter = Chapter::find($request->id);
    
            // Check if the number has changed in the request
            if ($chapter->number !== $request->number) {
                $existingChapter = Chapter::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existingChapter) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }
            $chapter->number = $request->number;
            $chapter->name = $request->name;
            $chapter->total_quiz_time = $request->total_quiz_time;
            $chapter->status = $request->status;
            $chapter->grade_id = $request->grade_id;
            $chapter->subject_id = $request->subject_id;
            $result = $chapter->save();
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
            $result = Chapter::destroy($request->id);
            $chapterContents = DB::table('subject_lessons')->where('chapter_id', $request->id)->get();
            foreach($chapterContents as $chapterContent){
                Content::destroy($chapterContent->id);
                }
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }
}
