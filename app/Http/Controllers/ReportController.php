<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\models\Content;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.reports.index');
    }
}
