<?php

namespace App\Http\Controllers;

use App\Models\LibraryAudioContent;
use App\Http\Requests\StoreKitContentRequest;
use App\Http\Requests\UpdateKitContentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;

class LibraryAudioContentController extends Controller
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

            $data = LibraryAudioContent::where('library_audio_id', $request->library_audio_id)->orderBy('updated_at', 'desc')->get();           
          
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('Contents', function ($row) {
                $contentBody = '<a href="'.asset($row->body).'" target="_blank">Download Content</a>'; 
                return $contentBody;
          
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
                $data = [
                    'title' => $request->title,
                    'library_audio_id' => $request->library_audio_id,
                    'created_by' => auth()->user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                if ($request->hasFile('file') && $request->file('file') !== 'undefined') {
                    $file = storeAudioFiles($request, ['file'], $request->library_audio_id);
                    $data['body'] = $file['file'];
                } 
                $res = LibraryAudioContent::create($data);
                DB::commit();

                
                if (!empty($res->id)) {
                    return response(['id' => $res->id], 201)
                        ->header('Content-Type', 'text/json');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('library_audio_content.index'))->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $library_audio_id = $request->library_audio_id;
        return view('pages.library.audio.content_index', compact('library_audio_id'));
    }


    public function showLibraryAudioContent(Request $request)
    {
        if ($request->ajax()) {
            $library_audio_content = LibraryAudioContent::find($request->id);
            if(!empty($library_audio_content->id))
            return response($library_audio_content, 200)
                  ->header('Content-Type', 'text/json');
        }else{
            return response(['data' => null], 404)
                  ->header('Content-Type', 'text/json');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $libraryAudioContent = LibraryAudioContent::find($request->id);
            $libraryAudioContent->title  = $request->title;
            if (isset($request->file) && $request->file !== 'undefined') {
                $file = storeAudioFiles($request, ['file'], $request->id);
                $libraryAudioContent->body = $file['file'];
            } 
            $result = $libraryAudioContent->save();
            if (!empty($result))
                return response([$result], 201)
                    ->header('Content-Type', 'text/json');
        }
    }
   

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $result = LibraryAudioContent::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }
}
