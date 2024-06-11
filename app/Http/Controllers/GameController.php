<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Http\Requests\StoreRegionalManagementOfficeRequest;
use App\Http\Requests\UpdateRegionalManagementOfficeRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\User;
use App\Models\Game;
use App\Models\ReadNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.setting.game.index');
    }


    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Game::query()->orderBy('updated_at', 'desc')->get();
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

                $number = Game::where('number', $request->number)->get();
                if(count($number) != 0){
                    return response(['message' => 'The number is already exist.'], 400)
                        ->header('Content-Type', 'text/json');
                }

                DB::beginTransaction();
                $result = Game::create($request->input());
                DB::commit();  

                $rec = Game::find($result->id);
                if (isset($request->icon) && $request->icon != 'undefined') {
                    $file1 = storeFiles($request, ['icon'], $result->id . '-icon');

                    $file_name = explode('/', $file1['icon']);

                    if (empty($file1)) {
                        throw new \Exception('icon for game could not be uploaded');
                    } else {

                        //we will delete old file

                        $res = File::delete(base_path() .'/storage/app/public/uploads/icon/' .$rec->icon);
                        $rec->icon = end($file_name);
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
            return redirect(route('game.index'))->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $game = Game::find($request->id);
            $game->game_status = $game->status ? 'Active' : 'In active'; 
            if(!empty($game->id))
            return response($game, 200)
                  ->header('Content-Type', 'text/json');
        }else{
            return response(['data' => null], 404)
                  ->header('Content-Type', 'text/json');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $game = Game::find($request->id);
    
            // Check if the number has changed in the request
            if ($game->number !== $request->number) {
                $existingGame = Game::where('number', $request->number)->first();
    
                // If a province with the same number already exists, return an error response
                if ($existingGame) {
                    return response(['message' => 'The number is already taken.'], 400)->header('Content-Type', 'text/json');
                }
            }

            $game->number = $request->number;
            $game->name = $request->name;
            $game->url = $request->url;
            $game->language = $request->language;
            $game->status = $request->status;
            if (isset($request->icon) && $request->icon != 'undefined') {
                $file1 = storeFiles($request, ['icon'], $request->id . '-icon');

              

                if (empty($file1)) {
                    throw new \Exception('icon for game could not be uploaded');
                } else {

                    $filePath = 'uploads/icon/'.$game->icon;
    
                    // Check if the file exists in the storage
                    if (Storage::disk('public')->exists($filePath)) {
                        // Delete the file
                        Storage::disk('public')->delete($filePath);
                        // File deleted successfully
                    }
                    
                    $file_name = explode('/', $file1['icon']);
                    $game->icon = end($file_name);
                }
            }
            $result = $game->save();
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
             $game = Game::findOrFail($request->id);
             
             
             $result = $game->delete();
             
             if ($result) {
                 return response()->json(['message' => 'Game deleted successfully.'], 200);
             } else {
                 return response()->json(['message' => 'Failed to delete Game.'], 400);
             }
         }
     }  


     public function gameList(){
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

        $games = DB::select('select 
                        g.id,
                       g.name,
                       g.url,
                       g.status,
                       CASE
                       WHEN g.language = "en" THEN "English"
                       WHEN g.language = "da" THEN "Dari"
                       ELSE "Pashto"
                   END AS language,
                       CASE
                       WHEN g.icon != "" THEN CONCAT("storage/uploads/icon/", g.icon)
                       ELSE NULL
                       END AS icon
                    from games as g   
                    where g.language = \''.$grade_language.'\'');

                if($games == []){
                    return response(['message' => 'No course is available'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($games, 200);
                }

            }
            else{
                return response(['message' => 'The user is not registered'], 422)
                ->header('Content-Type', 'text/json');
            }      
    }

}