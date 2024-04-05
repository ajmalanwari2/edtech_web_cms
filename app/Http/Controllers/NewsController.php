<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\District;
use App\Http\Requests\StoreRegionalManagementOfficeRequest;
use App\Http\Requests\UpdateRegionalManagementOfficeRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\User;
use App\Models\News;
use App\Models\ReadNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.setting.news.index');
    }


    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = News::query()->orderBy('updated_at', 'desc')->get();
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        try {
            if ($request->ajax()) 
            {

                $number = News::where('number', $request->number)->get();
                if(count($number) != 0){
                    return response(['message' => 'The number is already exist.'], 400)
                        ->header('Content-Type', 'text/json');
                }

                DB::beginTransaction();
                $result = News::create($request->input());
                DB::commit();  

                $rec = News::find($result->id);
                if (isset($request->photo) && $request->photo != 'undefined') {
                    $file1 = storeFiles($request, ['photo'], $result->id . '-photo');

                    $file_name = explode('/', $file1['photo']);

                    if (empty($file1)) {
                        throw new \Exception('photo for news could not be uploaded');
                    } else {

                        //we will delete old file

                        $res = File::delete(base_path() .'/storage/app/public/uploads/photo/' .$rec->icon);
                        $rec->photo = end($file_name);
                    }
                } 
                $r = $rec->save();
                    if(!empty($result->id))
                    {
                        return response(['id' => $result->id], 201)
                        ->header('Content-Type', 'text/json');
                    }
            }         
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('news.index'))->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $news = News::find($request->id);
            $news->news_status = $news->status ? 'Active' : 'In active'; 
            if(!empty($news->id))
            return response($news, 200)
                  ->header('Content-Type', 'text/json');
        }else{
            return response(['data' => null], 404)
                  ->header('Content-Type', 'text/json');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $news = News::find($request->id);
    
            // Check if the number has changed in the request
            if ($news->number !== $request->number) {
                $existingNews = News::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existingNews) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }

            $news->number = $request->number;
            $news->title = $request->title;
            $news->description = $request->description;
            $news->language = $request->language;
            $news->status = $request->status;
            $news->is_emailed = $request->is_emailed;
            if (isset($request->photo) && $request->photo != 'undefined') {
                $file1 = storeFiles($request, ['photo'], $request->id . '-photo');

                $file_name = explode('/', $file1['photo']);

                if (empty($file1)) {
                    throw new \Exception('photo for news could not be uploaded');
                } else {

                    //we will delete old file

                    $res = File::delete(base_path() .'/storage/app/public/uploads/photo/' .$news->photo);
                    $news->photo = end($file_name);
                }
            }
            $result = $news->save();
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
             $notice = News::findOrFail($request->id);
             
             
             $result = $notice->delete();
             
             if ($result) {
                 return response()->json(['message' => 'News deleted successfully.'], 200);
             } else {
                 return response()->json(['message' => 'Failed to delete News.'], 400);
             }
         }
     }  
}