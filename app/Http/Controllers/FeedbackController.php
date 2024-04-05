<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.setting.feedback.index');
    }


    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::select('
            SELECT
                f.id,
                u.name as username,
                u.identity_number,
                f.updated_at,
                u.email,
                f.type,
                f.message
            FROM users AS u
            JOIN feedbacks AS f ON u.id = f.user_id
            ORDER BY f.updated_at DESC
            ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord(' . $row->id . ')" href="javascript:void(0)" 
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons" style="color:SlateBlue">visibility</i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
  

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
{
    if ($request->ajax()) {
        $feedback = DB::select('
            SELECT
                f.id,
                u.name as username,
                u.identity_number,
                f.updated_at,
                u.email,
                f.type,
                f.message
            FROM users AS u
            JOIN feedbacks AS f ON u.id = f.user_id
            WHERE f.id = '.$request->id.'
        ');
        $feedback = $feedback && $feedback[0] ? $feedback[0] : [];
        if (!empty($feedback->id)) {
            return response()->json($feedback, 200);
        }
    }

    return response()->json(['data' => null], 404);
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