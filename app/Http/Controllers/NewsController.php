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
use Illuminate\Support\Facades\Storage;
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
            // Check if number already exists
            $number = News::where('number', $request->number)->first();
            if ($number) {
                return response(['message' => 'The number already exists.'], 400)
                    ->header('Content-Type', 'application/json');
            }

            DB::beginTransaction();

            // Create the record but don't commit yet
            $result = News::create($request->input());

            // Handle photo upload
            if (isset($request->photo) && $request->photo != 'undefined') {
                $file1 = storeFiles($request, ['photo'], $result->id . '-photo');

                if (empty($file1['photo'])) {
                    // If upload fails, rollback and throw exception
                    DB::rollBack();
                    throw new \Exception('Photo for news could not be uploaded');
                } else {
                    $file_name = explode('/', $file1['photo']);

                    // Delete old file if exists
                    if ($result->photo) {
                        File::delete(storage_path('app/public/uploads/photo/' . $result->photo));
                    }

                    $result->photo = end($file_name);
                    $result->save();
                }
            }

            DB::commit();

            return response(['id' => $result->id], 201)
                ->header('Content-Type', 'application/json');
        }         
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect(route('news.index'))->with('error', $e->getMessage());
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
        DB::beginTransaction();
        try {
            $news = News::find($request->id);

            if (!$news) {
                return response(['message' => 'News not found.'], 404)
                    ->header('Content-Type', 'application/json');
            }

            // Check if the number has changed
            if ($news->number !== $request->number) {
                $existingNews = News::where('number', $request->number)->first();
                if ($existingNews) {
                    return response(['message' => 'The number is already taken.'], 400)
                        ->header('Content-Type', 'application/json');
                }
            }

            // Update fields
            $news->number = $request->number;
            $news->title = $request->title;
            $news->description = $request->description;
            $news->language = $request->language;
            $news->status = $request->status;
            $news->is_emailed = $request->is_emailed;

            // Handle photo upload
            if (isset($request->photo) && $request->photo != 'undefined') {
                $file1 = storeFiles($request, ['photo'], $request->id . '-photo');

                if (empty($file1['photo'])) {
                    throw new \Exception('Photo for news could not be uploaded');
                }

                // Delete old file if exists
                if ($news->photo && Storage::disk('public')->exists('uploads/photo/' . $news->photo)) {
                    Storage::disk('public')->delete('uploads/photo/' . $news->photo);
                }

                $file_name = explode('/', $file1['photo']);
                $news->photo = end($file_name);
            }

            $news->save();
            DB::commit();

            return response(['message' => 'News updated successfully'], 200)
                ->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
            DB::rollBack();
            return response(['message' => $e->getMessage()], 500)
                ->header('Content-Type', 'application/json');
        }
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