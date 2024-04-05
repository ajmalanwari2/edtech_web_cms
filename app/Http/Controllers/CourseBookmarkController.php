<?php

namespace App\Http\Controllers;

use App\Models\CourseBookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use DataTables;
class CourseBookmarkController extends Controller
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
        $bookmark = CourseBookmark::where('user_id', $user_id)
                            ->where('course_id', $request->course_id)
                            ->first();
        
        if (!$bookmark) {
            // If no bookmark exists, create a new one
            $bookmark = new CourseBookmark();
            $bookmark->user_id = $user_id;
            $bookmark->course_id = $request->course_id;
        }
        
        $bookmark->state = $request->state;
        $result = $bookmark->save();
    
        if ($result) {
            return response()->json(['message' => 'Bookmark updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to update bookmark'], 500);
        }
    }




    // public function bookmarkList(Request $request)
    // {
    //     $user_id = auth()->user()->id;
    //     $user = User::find($user_id);
    //     $grade_id = Student::select('grade_id')->where('user_id', $user_id)->first();
    
    //     if ($user == NULL || $grade_id == NULL) {
    //         return response(['message' => 'The user is not registered'], 400)
    //             ->header('Content-Type', 'text/json');
    //     }
    
    //     $bookmarks = DB::select('SELECT
    //     b.id AS bookmark_id,
    //     c.id AS course_id,
    //     c.name AS course_name,
    //     COALESCE(b.state, 0) AS bookmark_state
    // FROM
    //     users AS u
    //     LEFT JOIN course_bookmarks AS b ON u.id = b.user_id 
    //     LEFT JOIN courses AS c ON c.id = b.course_id 
    // WHERE
    //     u.id = '.$user_id.'
    // GROUP BY
    //     b.id, c.id, c.name
    // HAVING
    //     bookmark_id IS NOT NULL
    //     AND bookmark_state = 1
    // ORDER BY
    //     bookmark_state DESC, c.id ASC');
    
    //     if (empty($bookmarks)) {
    //         return response(['message' => 'No bookmarks available for this user'], 422)
    //             ->header('Content-Type', 'text/json');
    //     } else {
    //         return response()->json($bookmarks, 200);
    //     }
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
        c.id AS course_id,
        c.name AS course_name,
        c.state as course_state,
        COALESCE(b.state, 0) AS bookmark_state,
        COUNT(q.id) AS quiz_count,
        (
            SELECT COUNT(cc.id)
            FROM course_contents AS cc
            WHERE cc.type = \'video\' AND cc.course_id = c.id
        ) AS video_course_count,
        (
            SELECT COUNT(cc.id)
            FROM course_contents AS cc
            WHERE cc.type = \'audio\' AND cc.course_id = c.id
        ) AS audio_course_count,
        (
            SELECT COUNT(cc.id)
            FROM course_contents AS cc
            WHERE cc.type = \'file\' AND cc.course_id = c.id
        ) AS file_course_count
    FROM
        users AS u
        LEFT JOIN students AS s ON u.id = s.user_id
        LEFT JOIN course_bookmarks AS b ON u.id = b.user_id 
        LEFT JOIN courses AS c ON c.id = b.course_id
        LEFT JOIN course_quizes AS q ON c.id = q.course_id   
    WHERE
        u.id = '.$user_id.'
    GROUP BY
        b.id, c.id, c.name
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
