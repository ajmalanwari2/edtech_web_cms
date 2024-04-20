<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use DataTables;
class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $user_id = auth()->user()->id;
        $bookmark = Bookmark::where('user_id', $user_id)
                            ->where('chapter_id', $request->chapter_id)
                            ->first();
        
        if (!$bookmark) {
            // If no bookmark exists, create a new one
            $bookmark = new Bookmark();
            $bookmark->user_id = $user_id;
            $bookmark->chapter_id = $request->chapter_id;
        }
        
        $bookmark->state = $request->state;
        $result = $bookmark->save();
    
        if ($result) {
            return response()->json(['message' => 'Bookmark updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to update bookmark'], 500);
        }
    }



    // public function bookmarkList(Request $request){
    //     $user_id = auth()->user()->id;
    //     $user = User::find($user_id);
    //     if($user->role === 'student'){
    //     $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
    //     $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
    //     if($user == NULL || $grade_id == NULL){
    //         return response(['message' => 'The user is not registered'], 400)
    //             ->header('Content-Type', 'text/json');
    //     }
    //     $bookmarks = DB::select('select 
    //                     b.chapter_id,
    //                    b.state as bookmark_state
    //                 from bookmarks as b
    //                     left join users as u
    //                         on u.id = b.user_id
    //                     left join students as s
    //                         on u.id = s.user_id
    //                where u.id = '.$user_id .'
    //                and b.chapter_id = '.$request->chapter_id.'');

    //             if($bookmarks == []){
    //                 return response(['message' => 'there is no bookmark for this chapter'], 422)
    //                     ->header('Content-Type', 'text/json');
    //             }else{
    //                 return response()->json($bookmarks, 200);
    //             }

    //         }
    //         else{
    //             return response(['message' => 'The user is not registered as student'], 422)
    //             ->header('Content-Type', 'text/json');
    //         }      

    // }

    public function bookmarkList(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $grade_id = Student::select('grade_id')->where('user_id', $user_id)->first();
    
        if ($user == NULL || $grade_id == NULL) {
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
    
        $bookmarks = DB::select('SELECT
        b.id AS bookmark_id,
        c.id AS chapter_id,
        c.name AS chapter_name,
        c.subject_id,
        cs.state AS chapter_state,
        sub.name as subject_name,
        COALESCE(b.state, 0) AS bookmark_state,
        COUNT(q.id) AS quiz_count,
        (
            SELECT COUNT(sll.id)
            FROM subject_lessons AS sll
            WHERE sll.type = \'video\' AND sll.chapter_id = c.id
        ) AS video_lesson_count,
        (
            SELECT COUNT(sll.id)
            FROM subject_lessons AS sll
            WHERE sll.type = \'audio\' AND sll.chapter_id = c.id
        ) AS audio_lesson_count,
        (
            SELECT COUNT(sll.id)
            FROM subject_lessons AS sll
            WHERE sll.type = \'file\' AND sll.chapter_id = c.id
        ) AS file_lesson_count
    FROM
        users AS u
        LEFT JOIN students AS s ON u.id = s.user_id
        LEFT JOIN schools AS sh ON sh.id = s.school_id
        LEFT JOIN grades AS g ON g.id = s.grade_id
        LEFT JOIN subjects_in_grades AS sig ON g.id = sig.grade_id
        LEFT JOIN subjects AS sub ON sub.id = sig.subject_id
        LEFT JOIN chapters AS c ON sub.id = c.subject_id
        LEFT JOIN quizes AS q ON c.id = q.chapter_id
        LEFT JOIN chapter_states AS cs ON c.id = cs.chapter_id and cs.user_id = '.$user_id.'
        LEFT JOIN bookmarks AS b ON c.id = b.chapter_id and b.user_id = '.$user_id.' 
    WHERE
        u.id = '.$user_id.'
        AND g.id = '.$grade_id->grade_id.'
    GROUP BY
        b.id, c.id, c.name, c.subject_id, cs.state
    HAVING
        bookmark_id IS NOT NULL
        AND bookmark_state = 1
    ORDER BY
        bookmark_state DESC, c.id ASC');
    
        if (empty($bookmarks)) {
            return response(['message' => 'No bookmarks available for this user'], 422)
                ->header('Content-Type', 'text/json');
        } else {
            return response()->json($bookmarks, 200);
        }
    }
    
}
