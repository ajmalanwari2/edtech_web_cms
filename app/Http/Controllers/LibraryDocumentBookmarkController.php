<?php

namespace App\Http\Controllers;

use App\Models\LibraryDocumentBookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use DataTables;
class LibraryDocumentBookmarkController extends Controller
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
        $bookmark = LibraryDocumentBookmark::where('user_id', $user_id)
                            ->where('library_document_id', $request->library_document_id)
                            ->first();
        
        if (!$bookmark) {
            // If no bookmark exists, create a new one
            $bookmark = new LibraryDocumentBookmark();
            $bookmark->user_id = $user_id;
            $bookmark->library_document_id = $request->library_document_id;
        }
        
        $bookmark->state = $request->state;
        $result = $bookmark->save();
    
        if ($result) {
            return response()->json(['message' => 'Bookmark updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to update bookmark'], 500);
        }
    }




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
        s.name AS subject_name,
        COALESCE(b.state, 0) AS bookmark_state
    FROM
        users AS u
        LEFT JOIN library_document_bookmarks AS b ON u.id = b.user_id 
        LEFT JOIN library_documents AS la ON la.id = b.library_document_id
        LEFT JOIN subjects AS s ON s.id = la.subject_id
    WHERE
        u.id = '.$user_id.'
    GROUP BY
        b.id, la.id, s.name
    HAVING
        bookmark_id IS NOT NULL
        AND bookmark_state = 1
    ORDER BY
        bookmark_state DESC, la.id ASC');
    
        if (empty($bookmarks)) {
            return response(['message' => 'No bookmarks available for this user'], 422)
                ->header('Content-Type', 'text/json');
        } else {
            return response()->json($bookmarks, 200);
        }
    }
    
}
