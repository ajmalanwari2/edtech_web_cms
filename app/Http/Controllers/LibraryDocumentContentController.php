<?php

namespace App\Http\Controllers;

use App\Models\LibraryDocumentContent;
use App\Http\Requests\StoreKitContentRequest;
use App\Http\Requests\UpdateKitContentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
class LibraryDocumentContentController extends Controller
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

            $data = LibraryDocumentContent::where('library_document_id', $request->library_document_id)->orderBy('updated_at', 'desc')->get();           
          
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('Contents', function ($row) {
                $contentBody = '<a href="'.asset($row->body).'" target="_blank">Download Content</a>'; 
                return $contentBody;
          
        })
        ->addColumn('library_content_is_main', function ($row) {
            if($row->is_main){
                return 'Yes'; 
            }else{
                return 'No';
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

                if (strpos($newString, 'ت') !== false) {
                    $newString = str_replace('ت', 'ټ', $newString);
                }
                
                if (strpos($newString, 'خ') !== false) {
                    $newString = str_replace('خ', 'ځ', $newString);
                }
                
                if (strpos($newString, '.') !== false) {
                    $newString = str_replace('.', '-', $newString);
                }
                $data = [
                    'title' => $newString,
                    'is_main' => $request->is_main,
                    'library_document_id' => $request->library_document_id,
                    'created_by' => auth()->user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                if ($request->hasFile('file')) {
                    $file = storePDFFiles($request, ['file'], $request->library_document_id);
                    $data['body'] = $file['file']['path']; // Store the file path
    
                    // You can also store the file size
                    $data['file_size'] = $file['file']['size'];
                } 
                $res = LibraryDocumentContent::create($data);
                DB::commit();

                
                if (!empty($res->id)) {
                    return response(['id' => $res->id], 201)
                        ->header('Content-Type', 'text/json');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('library_document_content.index'))->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $library_document_id = $request->library_document_id;
        return view('pages.library.document.content_index', compact('library_document_id'));
    }


    public function showLibraryDocumentContent(Request $request)
    {
        if ($request->ajax()) {
            $library_document_content = LibraryDocumentContent::find($request->id);
            
            if(!empty($library_document_content->id))
            $library_document_content->library_document_content_is_main = $library_document_content->is_main ? 'Yes' : 'No'; 
            return response($library_document_content, 200)
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
            $libraryDocumentContent = LibraryDocumentContent::find($request->id);
            $newString = $request->title;

            if (strpos($newString, 'ت') !== false) {
                $newString = str_replace('ت', 'ټ', $newString);
            }
            
            if (strpos($newString, 'خ') !== false) {
                $newString = str_replace('خ', 'ځ', $newString);
            }
            
            if (strpos($newString, '.') !== false) {
                $newString = str_replace('.', '-', $newString);
            }
            $libraryDocumentContent->title  = $newString;
            $libraryDocumentContent->is_main  = $request->is_main;
            if (isset($request->file) && $request->file !== 'undefined') {
                $filePath = str_replace('storage/', '', $libraryDocumentContent->body);

                // Check if the file exists in the storage
                if (Storage::disk('public')->exists($filePath)) {
                    // Delete the file
                    Storage::disk('public')->delete($filePath);
                    // File deleted successfully
                }
                $file = storePDFFiles($request, ['file'], $request->id);
                $libraryDocumentContent->body = $file['file']['path'];
                $libraryDocumentContent->file_size = $file['file']['size'];
            } 
            $result = $libraryDocumentContent->save();
            if (!empty($result))
                return response([$result], 201)
                    ->header('Content-Type', 'text/json');
        }
    }
   

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $libraryKitContent = LibraryDocumentContent::find($request->id);
            $filePath = str_replace('storage/', '', $libraryKitContent->body);

// Check if the file exists in the storage
if (Storage::disk('public')->exists($filePath)) {
    // Delete the file
    Storage::disk('public')->delete($filePath);
    // File deleted successfully
}
            $result = LibraryDocumentContent::destroy($request->id);
            if (!empty($result))
                return response([$result], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$result], 400)
                    ->header('Content-Type', 'text/json');
        }
    }
}
