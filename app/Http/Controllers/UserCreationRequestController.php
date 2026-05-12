<?php

namespace App\Http\Controllers;

use App\Models\UserCreationRequest;
use App\Models\Province;
use App\Models\District;
use App\Models\School;
use App\Models\Grade;
use App\Models\StudentInParent;
use App\Models\Feedback;
use App\Models\UserDeletionRequest;
use App\Models\DeletedUser;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;
use App\Rules\ExistsProvinceForeignKey;
use App\Rules\ExistsDistrictForeignKey;
use App\Rules\ExistsSchoolForeignKey;
use App\Rules\ExistsGradeForeignKey;
use Illuminate\Support\Facades\Auth;

class UserCreationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allRegisteredUserindex()
    {
        $provinces = Province::all();
        $districts = District::all();
        $schools = School::all();
        $grades = Grade::all();
        return view('pages.users.index', compact('provinces', 'districts', 'schools', 'grades' ));
    }
    /**
     * Display a listing of the resource as json .
     */
    public function allRegisteredUserList(Request $request){
        if ($request->ajax()) {
            if ((int) $request->input('length') === -1) {
                @ini_set('memory_limit', '512M');
                @set_time_limit(120);
            }

            $data = DB::table('users as u')
                ->leftJoin('students as s', function ($join) {
                    $join->on('s.user_id', '=', 'u.id')
                        ->whereNull('s.deleted_at');
                })
                ->leftJoin('teachers as t', 't.user_id', '=', 'u.id')
                ->leftJoin('student_parents as sp', 'sp.user_id', '=', 'u.id')
                ->leftJoin('provinces as ps', 'ps.id', '=', 's.province_id')
                ->leftJoin('provinces as pt', 'pt.id', '=', 't.province_id')
                ->leftJoin('provinces as pp', 'pp.id', '=', 'sp.province_id')
                ->leftJoin('districts as ds', 'ds.id', '=', 's.district_id')
                ->leftJoin('districts as dt', 'dt.id', '=', 't.district_id')
                ->leftJoin('districts as dp', 'dp.id', '=', 'sp.district_id')
                ->leftJoin('schools as ss', 'ss.id', '=', 's.school_id')
                ->leftJoin('schools as st', 'st.id', '=', 't.school_id')
                ->leftJoin('schools as spc', 'spc.id', '=', 'sp.school_id')
                ->leftJoin('grades as gs', 'gs.id', '=', 's.grade_id')
                ->leftJoin('grades as gt', 'gt.id', '=', 't.grade_id')
                ->leftJoin('grades as gp', 'gp.id', '=', 'sp.grade_id')
                ->whereNull('u.deleted_at')
                ->where('u.role', '!=', 'admin')
                ->select([
                    'u.id',
                    'u.name',
                    'u.identity_number',
                    'u.email',
                    'u.role',
                    'u.status',
                    DB::raw("COALESCE(s.phone_no, t.phone_no, sp.phone_no, '') as phone_no"),
                    DB::raw("COALESCE(ps.name, pt.name, pp.name, '') as province"),
                    DB::raw("COALESCE(ds.name, dt.name, dp.name, '') as district"),
                    DB::raw("COALESCE(ss.name, st.name, spc.name, '') as school"),
                    DB::raw("COALESCE(gs.name, gt.name, gp.name, '') as grade"),
                ])
                ->orderByDesc('u.id');

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    if($row->status){
                        return 'Active';
                    }else{
                        return 'In active';
                    }

                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#modal-form">
                    <i class="material-icons">edit</i></i></a> <a onclick="loadRecord('.$row->id.')" href="javascript:void(0)"
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm"
                    onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i></a>';
                    return $actionBtn;
                })
                ->filterColumn('phone_no', function ($query, $keyword) {
                    $query->whereRaw("COALESCE(s.phone_no, t.phone_no, sp.phone_no, '') LIKE ?", ["%{$keyword}%"]);
                })
                ->filterColumn('province', function ($query, $keyword) {
                    $query->whereRaw("COALESCE(ps.name, pt.name, pp.name, '') LIKE ?", ["%{$keyword}%"]);
                })
                ->filterColumn('district', function ($query, $keyword) {
                    $query->whereRaw("COALESCE(ds.name, dt.name, dp.name, '') LIKE ?", ["%{$keyword}%"]);
                })
                ->filterColumn('school', function ($query, $keyword) {
                    $query->whereRaw("COALESCE(ss.name, st.name, spc.name, '') LIKE ?", ["%{$keyword}%"]);
                })
                ->filterColumn('grade', function ($query, $keyword) {
                    $query->whereRaw("COALESCE(gs.name, gt.name, gp.name, '') LIKE ?", ["%{$keyword}%"]);
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $keyword = strtolower($keyword);
                    $compactKeyword = str_replace(' ', '', $keyword);

                    if (str_contains('inactive', $compactKeyword)) {
                        $query->where('u.status', 0);
                        return;
                    }

                    if (str_contains('active', $keyword)) {
                        $query->where('u.status', 1);
                        return;
                    }

                    $query->whereRaw("CASE WHEN u.status = 1 THEN 'Active' ELSE 'In active' END LIKE ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function addNewUser(Request $request)
    {
        try {
        if ($request->ajax()) {
            $identity_number = User::where('identity_number', $request->identity_number)->get();
            if(count($identity_number) != 0){
                return response(['message' => 'This identity number already exist'], 400)
                    ->header('Content-Type', 'text/json');
            }
            DB::beginTransaction();
            $user = [
                'name' => $request->name,
                'identity_number' => $request->identity_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'status' => $request->status
            ];
            $user_id = User::create($user)->id;
            if($request->role == 'student'){
                $student = [
                    'phone_no' => $request->phone_no,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'user_id' => $user_id,
                    'province_id' => $request->province_id,
                    'district_id' => $request->district_id,
                    'school_id' => $request->school_id,
                    'grade_id' => $request->grade_id,
                    'language' => $request->language,
                ];
                Student::create($student);
            }
            if($request->role == 'parent'){
                $parent = [
                    'phone_no' => $request->phone_no,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'user_id' => $user_id,
                    'province_id' => $request->province_id,
                    'district_id' => $request->district_id,
                    'school_id' => $request->school_id,
                    'grade_id' => $request->grade_id,
                ];
                StudentParent::create($parent);
            }
            if($request->role == 'teacher'){
                $teacher = [
                    'phone_no' => $request->phone_no,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'user_id' => $user_id,
                    'province_id' => $request->province_id,
                    'district_id' => $request->district_id,
                    'school_id' => $request->school_id,
                    'grade_id' => $request->grade_id,
                ];
                Teacher::create($teacher);
            }

            $details = [
                'name' => $request->first_name,
            ];

            \Mail::to($request->email)->send(new \App\Mail\UserRegistrationMail($details));
            DB::commit();

            if (!empty($user_id))
                return response([$user_id], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$user_id], 400)
                    ->header('Content-Type', 'text/json');
        }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('user.index'))->with('error',$e->getMessage());
        }
    }


    public function updateRegisteredUser(Request $request)
    {
        try {
            if ($request->ajax()) {
                DB::beginTransaction();
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->identity_number = $request->identity_number;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->status = $request->status;
            $user_id = $user->save();
            if($request->role == 'student'){
                $student = Student::where('user_id', $request->id)->first();
                $student->phone_no = $request->phone_no;
                $student->gender = $request->gender;
                $student->dob = $request->dob;
                $student->user_id = $request->id;
                $student->province_id = $request->province_id;
                $student->district_id = $request->district_id;
                $student->school_id = $request->school_id;
                $student->grade_id = $request->grade_id;
                $student->language = $request->language;
                $student->save();
            }
            if($request->role == 'parent'){
                $parent = StudentParent::where('user_id', $request->id)->first();
                $parent->phone_no = $request->phone_no;
                $parent->gender = $request->gender;
                $parent->dob = $request->dob;
                $parent->user_id = $request->id;
                $parent->province_id = $request->province_id;
                $parent->district_id = $request->district_id;
                $parent->school_id = $request->school_id;
                $parent->grade_id = $request->grade_id;
                $parent->save();
            }
            if($request->role == 'teacher'){
                $teacher = Teacher::where('user_id', $request->id)->first();
                $teacher->phone_no = $request->phone_no;
                $teacher->gender = $request->gender;
                $teacher->dob = $request->dob;
                $teacher->user_id = $request->id;
                $teacher->province_id = $request->province_id;
                $teacher->district_id = $request->district_id;
                $teacher->school_id = $request->school_id;
                $teacher->grade_id = $request->grade_id;
                $teacher->language = $request->language;
                $teacher->save();
            }

            DB::commit();

            if (!empty($user_id))
                return response([$user_id], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$user_id], 400)
                    ->header('Content-Type', 'text/json');
        }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('user.index'))->with('error',$e->getMessage());
        }
    }


    public function registeredUserShow(Request $request)
    {
        if ($request->ajax()) {
            $user = User::with('student', 'teacher', 'parent')->find($request->id);
            $user->user_status = $user->status ? 'Active' : 'In Active';
            if($user->student){
                $user->user_phone = $user->student->phone_no;
                $user->user_gender = $user->student->gender;
                $user->user_dob = $user->student->dob;
                $user->province_id = $user->student->province_id;
                $user->district_id = $user->student->district_id;
                $user->school_id = $user->student->school_id;
                $user->grade_id = $user->student->grade_id;
                $user->user_language = $user->student->language;
                $user->user_province = Province::find($user->student->province_id)->name;
                $user->user_district = District::find($user->student->district_id)->name;
                $user->user_school = School::find($user->student->school_id)->name;
                $user->user_grade = Grade::find($user->student->grade_id)->name;
            }elseif($user->teacher){
                $user->user_phone = $user->teacher->phone_no;
                $user->user_gender = $user->teacher->gender;
                $user->user_dob = $user->teacher->dob;
                $user->province_id = $user->teacher->province_id;
                $user->district_id = $user->teacher->district_id;
                $user->school_id = $user->teacher->school_id;
                $user->grade_id = $user->teacher->grade_id;
                $user->user_language = $user->teacher->language;
                $user->user_province = Province::find($user->teacher->province_id)->name;
                $user->user_district = District::find($user->teacher->district_id)->name;
                $user->user_school = School::find($user->teacher->school_id)->name;
                // $user->user_grade = Grade::find($user->teacher->grade_id)->name;
            }elseif($user->parent){
                $user->user_phone = $user->parent->phone_no;
                $user->user_gender = $user->parent->gender;
                $user->user_dob = $user->parent->dob;
                $user->province_id = $user->parent->province_id;
                $user->district_id = $user->parent->district_id;
                $user->school_id = $user->parent->school_id;
                $user->grade_id = $user->parent->grade_id;

                $user->user_phone = $user->parent->phone_no;
                $user->user_province = Province::find($user->parent->province_id)->name;
                $user->user_district = District::find($user->parent->district_id)->name;
                $user->user_school = School::find($user->parent->school_id)->name;
                // $user->user_grade = Grade::find($user->parent->grade_id)->name;
            }else{
                $user->user_phone = '';
                $user->user_province = '';
                $user->user_district = '';
                $user->user_school = '';
                $user->user_grade = '';
            }

            if(!empty($user->id))
            return response($user, 200)
                  ->header('Content-Type', 'text/json');
        }else{
            return response(['data' => null], 404)
                  ->header('Content-Type', 'text/json');
        }
    }

    public function index()
    {
        $provinces = Province::all();
        $districts = District::all();
        $schools = School::all();
        $grades = Grade::all();
        return view('pages.setting.requests.index', compact('provinces', 'districts', 'schools', 'grades' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function userRequests()
    {
        $provinces = Province::all();
        $districts = District::all();
        $schools = School::all();
        $grades = Grade::all();
        return view('pages.users.user_creation_request', compact('provinces', 'districts', 'schools', 'grades' ));
    }
    // public function create()
    // {
    //     $number_registered_students = UserCreationRequest::where('role', 'student')->where('is_approved', '1')->count();
    //     $number_pending_students = UserCreationRequest::where('role', 'student')->where('is_approved', '0')->count();
    //     $number_registered_teachers = UserCreationRequest::where('role', 'teacher')->where('is_approved', '1')->count();
    //     $number_pending_teachers = UserCreationRequest::where('role', 'teacher')->where('is_approved', '0')->count();
    //     $number_registered_parents = UserCreationRequest::where('role', 'parent')->where('is_approved', '1')->count();
    //     $number_pending_parents = UserCreationRequest::where('role', 'parent')->where('is_approved', '0')->count();

    //     return view('pages.setting.requests.create', compact('number_registered_students',
    //     'number_pending_students', 'number_registered_teachers', 'number_pending_teachers',
    //     'number_registered_parents', 'number_pending_parents'));
    // }

      /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $identity_number = UserCreationRequest::where('identity_number', $request->identity_number)->get();

                // Validate the user input
                if($request->role === 'teacher'){
                    $validator = Validator::make($request->all(), [
                        'first_name' => 'required|string|max:255',
                        'identity_number' => 'required|string|max:255|unique:users',
                        'email' => 'required|string|email|max:255',
                        'password' => 'required|string|min:8',
                        'phone_no' => 'required|string|max:255',
                        'gender' => 'required|string|max:255',
                        'role' => 'required|string|max:255',
                        'language' => 'required|string|max:255',
                        'province_id' => ['required', new ExistsProvinceForeignKey],
                        'district_id' => ['required', new ExistsDistrictForeignKey],
                        'school_id' => ['required', new ExistsSchoolForeignKey],
                    ]);
                } elseif($request->role === 'parent'){
                    $validator = Validator::make($request->all(), [
                        'first_name' => 'required|string|max:255',
                        'identity_number' => 'required|string|max:255|unique:users',
                        'email' => 'required|string|email|max:255',
                        'password' => 'required|string|min:8',
                        'phone_no' => 'required|string|max:255',
                        'gender' => 'required|string|max:255',
                        'role' => 'required|string|max:255',
                        'province_id' => ['required', new ExistsProvinceForeignKey],
                        'district_id' => ['required', new ExistsDistrictForeignKey],
                        'school_id' => ['required', new ExistsSchoolForeignKey],
                    ]);
                } else{
                    $validator = Validator::make($request->all(), [
                        'first_name' => 'required|string|max:255',
                        'identity_number' => 'required|string|max:255|unique:users',
                        'email' => 'required|string|email|max:255',
                        'password' => 'required|string|min:8',
                        'phone_no' => 'required|string|max:255',
                        'gender' => 'required|string|max:255',
                        'role' => 'required|string|max:255',
                        'language' => 'required|string|max:255',
                        'province_id' => ['required', new ExistsProvinceForeignKey],
                        'district_id' => ['required', new ExistsDistrictForeignKey],
                        'school_id' => ['required', new ExistsSchoolForeignKey],
                        'grade_id' => ['required', new ExistsGradeForeignKey],
                    ]);

                }
                

                if ($validator->fails()) {
                    // Return error response with validation errors
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => $validator->errors()], 422);
                }

            if(count($identity_number) != 0){
                return response(['message' => 'This identity_number already exist'], 422)
                    ->header('Content-Type', 'text/json');
            }
                DB::beginTransaction();
                $result = UserCreationRequest::create($request->input());
                DB::commit();
                    if(!empty($result->id))
                    {
                        return response(['id' => $result->id], 200)
                        ->header('Content-Type', 'text/json');
                    }

        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('rmo.index'))->with('error',$e->getMessage());
        }
    }
    public function list(Request $request){
        if ($request->ajax()) {
            $data = UserCreationRequest::with('province', 'school', 'district', 'grade')
            ->where('is_approved', NULL)
            ->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('province', function($row){
                    return $row->province ? $row->province->name : '';
                })
                ->addColumn('school', function($row){
                    return $row->school ? $row->school->name : '';
                })
                ->addColumn('district', function($row){
                    return $row->district ? $row->district->name : '';
                })
                ->addColumn('grade', function($row){
                    return $row->grade ? $row->grade->name : '';
                })
                ->addColumn('requested_date', function ($row) {
                    if($row->created_at){
                        return date("Y-m-d ", strtotime($row->created_at));
                    }else{
                        return '';
                    }
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm"
                    onclick="approveRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkgreen">check</i></a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-reject"
                    onclick="rejectRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:red">cancel</i></a>
                    <a onclick="loadRecord('.$row->id.')" href="javascript.void(0)" data-toggle="modal" data-target="#modal-form">
                    <i class="material-icons">edit</i></i></a> <a onclick="loadRecord('.$row->id.')" href="javascript:void(0)"
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);

        }
    }
    public function approve(Request $request)
    {
        try {
        if ($request->ajax()) {
            $userCreationRequest = UserCreationRequest::find($request->id);
            DB::beginTransaction();
            $user = [
                'name' => $userCreationRequest->first_name,
                'identity_number' => $userCreationRequest->identity_number,
                'email' => $userCreationRequest->email,
                'password' => Hash::make($userCreationRequest->password),
                'role' => $userCreationRequest->role
            ];
            $user_id = User::create($user)->id;
            if($userCreationRequest->role == 'student'){
                $student = [
                    'phone_no' => $userCreationRequest->phone_no,
                    'gender' => $userCreationRequest->gender,
                    'dob' => $userCreationRequest->dob,
                    'user_id' => $user_id,
                    'student_parent_id' => $userCreationRequest->student_parent_id,
                    'province_id' => $userCreationRequest->province_id,
                    'district_id' => $userCreationRequest->district_id,
                    'school_id' => $userCreationRequest->school_id,
                    'grade_id' => $userCreationRequest->grade_id,
                    'language' => $userCreationRequest->language,
                ];
                Student::create($student);
            }
            if($userCreationRequest->role == 'parent'){
                $parent = [
                    'phone_no' => $userCreationRequest->phone_no,
                    'gender' => $userCreationRequest->gender,
                    'dob' => $userCreationRequest->dob,
                    'user_id' => $user_id,
                    'province_id' => $userCreationRequest->province_id,
                    'district_id' => $userCreationRequest->district_id,
                    'school_id' => $userCreationRequest->school_id,
                    'grade_id' => $userCreationRequest->grade_id,
                ];
                $result = StudentParent::create($parent);
                if ($userCreationRequest->student_ids != null) {
                    $studentIds = explode(', ', $userCreationRequest->student_ids);
            
                    foreach ($studentIds as $studentId) {
                        $studentParent = new StudentInParent();
                        $studentParent->student_parent_id = $result->id;
                        $studentParent->student_id = $studentId;
                        $studentParent->created_by = auth::user()->id;
                        $studentParent->save();
                    }
                }
            }
            if($userCreationRequest->role == 'teacher'){
                $teacher = [
                    'phone_no' => $userCreationRequest->phone_no,
                    'gender' => $userCreationRequest->gender,
                    'dob' => $userCreationRequest->dob,
                    'user_id' => $user_id,
                    'province_id' => $userCreationRequest->province_id,
                    'district_id' => $userCreationRequest->district_id,
                    'school_id' => $userCreationRequest->school_id,
                    'language' => $userCreationRequest->language,
                ];
                Teacher::create($teacher);
            }
            DB::commit();
            DB::beginTransaction();
            UserCreationRequest::where('id', $request->id)->update(['is_approved' => 1]);
            DB::commit();
            $details = [
                'name' => $userCreationRequest->first_name,
            ];
            \Mail::to($userCreationRequest->email)->send(new \App\Mail\UserRegistrationMail($details));
            if (!empty($userCreationRequest))
                return response([$userCreationRequest], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$userCreationRequest], 400)
                    ->header('Content-Type', 'text/json');
        }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('user.index'))->with('error',$e->getMessage());
        }
    }

    public function reject(Request $request)
    {
        try {
        if ($request->ajax()) {
            DB::beginTransaction();
            $userRejectionRequest = UserCreationRequest::find($request->id);
            UserCreationRequest::where('id', $request->id)->update(['is_approved' => 0]);

            DB::commit();
            if (!empty($userRejectionRequest))
                return response([$userRejectionRequest], 200)
                    ->header('Content-Type', 'text/json');
            else
                return response([$userRejectionRequest], 400)
                    ->header('Content-Type', 'text/json');
        }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('user.index'))->with('error',$e->getMessage());
        }
    }

     /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $userCreationRequest = UserCreationRequest::find($request->id);
            $userCreationRequest->request_province = $userCreationRequest->province->name;
            $userCreationRequest->request_district = $userCreationRequest->district->name;
            $userCreationRequest->request_school = $userCreationRequest->school->name;
            $userCreationRequest->request_grade = $userCreationRequest->grade->name;
            $userCreationRequest->request_date = $userCreationRequest->created_at ? date("Y-m-d ", strtotime($userCreationRequest->created_at)) : '';
            if(!empty($userCreationRequest->id))
            return response($userCreationRequest, 200)
                  ->header('Content-Type', 'text/json');
        }else{
            return response(['data' => null], 404)
                  ->header('Content-Type', 'text/json');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserCreationRequest $userCreationRequest)
    {
        //
    }

      /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $userCreationRequest = UserCreationRequest::find($request->id);
            $userCreationRequest->first_name = $request->first_name;
            $userCreationRequest->identity_number = $request->identity_number;
            $userCreationRequest->email = $request->email;
            $userCreationRequest->phone_no = $request->phone_no;
            $userCreationRequest->gender = $request->gender;
            $userCreationRequest->dob = $request->dob;
            $userCreationRequest->province_id = $request->province_id;
            $userCreationRequest->district_id  = $request->district_id;
            $userCreationRequest->school_id  = $request->school_id;
            $userCreationRequest->grade_id  = $request->grade_id;
            $userCreationRequest->password  = $request->password;
            $result = $userCreationRequest->save();
            if (!empty($result))
                return response([$result], 201)
                    ->header('Content-Type', 'text/json');
        }
    }

    public function destroy(Request $request)
    {
            // $result = User::where('id', $request->id)->delete();
            // Student::where('user_id', $request->id)->delete();
            // Teacher::where('user_id', $request->id)->delete();
            // StudentParent::where('user_id', $request->id)->delete();
            // if (!empty($result))
            //     return response()->json(['message' => 'User deleted successfully']);
    $user = User::withTrashed()->find($request->id);

    if ($user) {
        $user->forceDelete(); // Hard delete
        Student::where('user_id', $request->id)->forceDelete();
        Teacher::where('user_id', $request->id)->forceDelete();
        StudentParent::where('user_id', $request->id)->forceDelete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    return response()->json(['message' => 'User not found'], 404);
           
    }


    public function userProfile(){
        $user_id =  auth()->user()->id;
        $user = User::find($user_id);
        if($user == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
        $userprofile = [];
        if($user->role == 'student'){
            $userprofile = DB::select('
            select 
            u.id,
                u.name,
                s.phone_no,
                u.identity_number,
                u.email,
                u.role,
                u.profile_image,
                concat(p.name, " ", d.name) as address,
                s.gender,
                s.dob,
                sh.name as school,
                g.name as grade,
                CASE
                WHEN s.language = "en" THEN "English"
                WHEN s.language = "da" THEN "Dari"
                ELSE "Pashto"
            END AS language,
            s.province_id,
             s.district_id
             from users as u
               join students as s
                on u.id = s.user_id
                join grades as g
                on g.id = s.grade_id
                join provinces as p
                on p.id = s.province_id
                join districts as d
                on d.id = s.district_id
                join schools as sh
                on sh.id = s.school_id
            where u.id = '.$user_id.'
            ');
        }

        if($user->role == 'teacher'){
            $userprofile = DB::select('
            select
                u.id,
                u.name, 
                t.phone_no,
                u.identity_number,
                u.email,
                u.role,
                u.profile_image,
                concat(p.name, " ", d.name) as address,
                t.gender,
                t.dob,
                CASE
                WHEN t.language = "en" THEN "English"
                WHEN t.language = "da" THEN "Dari"
                ELSE "Pashto"
                END AS language,
                t.province_id,
                t.district_id
             from users as u
                left join teachers as t
                on u.id = t.user_id
                left join provinces as p
                on p.id = t.province_id
                left join districts as d
                on d.id = t.district_id
            where u.id = '.$user_id.'
            ');
        }


        if($user->role == 'parent'){
            $userprofile = DB::select('
            select 
                u.id,
                u.name,    
                sp.phone_no,
                u.identity_number,
                u.email,
                u.role,
                u.profile_image,
                concat(p.name, " ", d.name) as address,
                sp.gender,
                sp.dob,
                sp.province_id,
                sp.district_id
             from users as u
                left join student_parents as sp
                on u.id = sp.user_id
                left join provinces as p
                on p.id = sp.province_id
                left join districts as d
                on d.id = sp.district_id
            where u.id = '.$user_id.'
            ');
        }
        $userprofile = $userprofile ? $userprofile[0] : []; 
        if($userprofile == []){
            return response(['message' => 'The user is not registered'], 422)
                ->header('Content-Type', 'text/json');
        }else{
            return response()->json($userprofile, 200);
        }


    }

// for mobile 
    public function updateUserProfile(Request $request)
    {
        try {
           
                DB::beginTransaction();
                $user_profile_id = auth()->user()->id;
            $user = User::find($user_profile_id);
              // Validate the user input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'province_id' => 'required|integer|max:20',
            'district_id' => 'required|integer|max:20',
            'gender' => 'required|string|max:20',
            'dob' => 'required|date',
        ]);

            if ($validator->fails()) {
                // Return error response with validation errors
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $validator->errors()], 422);
            }
            $user->name = $request->name;
            $user->email = $request->email;
            // $user->password = Hash::make($request->password);
            // $image = storeFiles($request, ['profile_image'], $user_profile_id);
            // if($image && $image['profile_image']){
            //     $user->profile_image = $image['profile_image'];
            // }
            $user->save();
            if($user->role == 'student'){
                $student = Student::where('user_id', $user_profile_id)->first();
                $student->province_id = $request->province_id;
                $student->district_id = $request->district_id;
                $student->gender = $request->gender;
                $student->dob = $request->dob;
                $student->save();
            }
            if($user->role == 'parent'){
                $parent = StudentParent::where('user_id', $user_id)->first();
                $parent->province_id = $request->province_id;
                $parent->district_id = $request->district_id;
                $parent->gender = $request->gender;
                $parent->dob = $request->dob;
                $parent->save();
            }
            if($user->role == 'teacher'){
                $teacher = Teacher::where('user_id', $user_id)->first();
                $teacher->province_id = $request->province_id;
                $teacher->district_id = $request->district_id;
                $teacher->gender = $request->gender;
                $teacher->dob = $request->dob;
                $teacher->save();
            }

            DB::commit();

            if (!blank($user) or !empty($user)){
                return response()->json(
                    ['message' => 'success'], 200)
                ->header('Content-Type', 'text/json');
            }else{
                return response()->json(
                    ['message' => 'The user is not exist.'], 422);
            }
                
     
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('user.index'))->with('error',$e->getMessage());
        }
    }


    // for mobile 
    public function userProfileImage(Request $request)
    {
        try {
           
                DB::beginTransaction();
                $user_profile_id = auth()->user()->id;
            $user = User::find($user_profile_id);
          
            $image = storeFiles($request, ['profile_image'], $user_profile_id);
            if($image && $image['profile_image']){
                $user->profile_image = $image['profile_image'];
            }else{
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => 'No profile image uploaded'], 422);
            }
            $user->save();
           

            DB::commit();

            if (!blank($user) or !empty($user)){
                return response(
                    ['message' => 'success',
                    'data' => $image['profile_image']], 200)
                ->header('Content-Type', 'text/json');
            }else{
                return response()->json(
                    ['message' => 'The user is not exist.'], 422);
            }
                
     
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('user.index'))->with('error',$e->getMessage());
        }
    }


    public function userPasswordUpdate(Request $request)
    {
        try {
           
                DB::beginTransaction();
                $user_profile_id = auth()->user()->id;
            $user = User::find($user_profile_id);
          
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:9'
            ]);
    
                if ($validator->fails()) {
                    // Return error response with validation errors
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => $validator->errors()], 422);
                }
                $user->password = Hash::make($request->password);
            $user->save();
           

            DB::commit();

            if (!blank($user) or !empty($user)){
                return response()->json(
                    ['message' => 'success'], 200)
                ->header('Content-Type', 'text/json');
            }else{
                return response()->json(
                    ['message' => 'The user is not exist.'], 422);
            }
                
     
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('user.index'))->with('error',$e->getMessage());
        }
    }


    public function syncUser(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $user_id = auth()->user()->id;
            $user = User::find($user_id);
            // Validate the user input
            $validator = Validator::make($request->all(), [
                'sync_datetime' => 'required|date_format:Y-m-d H:i:s',
            ]);
    
            if ($validator->fails()) {
                // Return error response with validation errors
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $validator->errors()
                ], 422);
            }
           
            $user->sync_datetime = $request->sync_datetime;
            $user->save();
    
            DB::commit();
    
            return response()->json(['message' => 'success'], 200);
    
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function inactiveUser(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $user_id = auth()->user()->id;
            $user = User::find($user_id);
            // Validate the user input
            $validator = Validator::make($request->all(), [
                'status' => 'required',
                'message' => 'required',
            ]);
    
            if ($validator->fails()) {
                // Return error response with validation errors
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $validator->errors()
                ], 422);
            }
           
            $user->status = $request->status;
            $user->save();

                $deleteUser = [
                    'type' => 'delete-account',
                    'message' => $request->message,
                    'user_id' => $user_id,
                ];
                Feedback::create($deleteUser);
          

            DB::commit();
    
            return response()->json(['message' => 'success'], 200);
    
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function contact(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $user_id = auth()->user()->id;
            $user = User::find($user_id);
            // Validate the user input
            $validator = Validator::make($request->all(), [
                'message' => 'required',
            ]);
    
            if ($validator->fails()) {
                // Return error response with validation errors
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $validator->errors()
                ], 422);
            }

                $deleteUser = [
                    'type' => 'feedback',
                    'message' => $request->message,
                    'user_id' => $user_id,
                ];
                Feedback::create($deleteUser);
          

            DB::commit();
    
            return response()->json(['message' => 'success'], 200);
    
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


 

public function profile($id)
{
    $user = User::findOrFail($id);

    return view('pages.users.user_profile.index', [
        'rec' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'identity_number' => $user->identity_number,
        ]
    ]);
}


public function updateProfile(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'identity_number' => 'nullable|string|max:50',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->identity_number = $request->identity_number;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}


public function approve_deletion_request(Request $request)
{
    try {
        DB::beginTransaction();

        // Find the user
        $user = User::findOrFail($request->id);
        // Update the deletion request status
        $deletionRequest = UserDeletionRequest::where('user_id', $request->id)->firstOrFail();
        $deletionRequest->update(['status' => 'approved']);

        // Prepare data to save in DeletedUser
        $userData = [
            'first_name' => $user->name,
            'identity_number' => $user->identity_number,
            'email' => $user->email,
            'password' => Hash::make($user->password),
            'role' => $user->role,
        ];

        // Add student-specific info if user is a student
        if ($user->role === 'student') {
            $student = Student::where('user_id', $request->id)->first();
            if ($student) {
                $userData['province_id'] = $student->province_id;
                $userData['district_id'] = $student->district_id;
                $userData['gender'] = $student->gender;
                $userData['dob'] = $student->dob;
            }
        }

         if ($user->role === 'teacher') {
            $teacher = Teacher::where('user_id', $request->id)->first();
            if ($teacher) {
                $userData['province_id'] = $teacher->province_id;
                $userData['district_id'] = $teacher->district_id;
                $userData['gender'] = $teacher->gender;
                $userData['dob'] = $teacher->dob;
            }
        }

         if ($user->role === 'parent') {
            $student_parent = StudentParent::where('user_id', $request->id)->first();
            if ($student_parent) {
                $userData['province_id'] = $student_parent->province_id;
                $userData['district_id'] = $student_parent->district_id;
                $userData['gender'] = $student_parent->gender;
                $userData['dob'] = $student_parent->dob;
            }
        }
        // Save to DeletedUser
        $deletedUser = DeletedUser::create($userData);

        // Delete the user

  if ($user) {
        $user->forceDelete(); // Hard delete
        Student::where('user_id', $request->id)->forceDelete();
        Teacher::where('user_id', $request->id)->forceDelete();
        StudentParent::where('user_id', $request->id)->forceDelete();

       
    }
        DB::commit();


        return response()->json(['message' => 'User deletion approved and account deleted', 'data' => $deletedUser], 200);

    } catch (\Exception $e) {
        \Log::info($e);
        DB::rollBack();
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}


public function reject_deletion_request(Request $request)
{
    try {
        DB::beginTransaction();

        // Find the user
        $user = User::findOrFail($request->id);
        // Update the deletion request status
        $deletionRequest = UserDeletionRequest::where('user_id', $request->id)->firstOrFail();
        $deletionRequest->update(['status' => 'rejected']);

        DB::commit();


        return response()->json(['message' => 'User deletion rejected and account not deleted', 'data' => $deletionRequest], 200);

    } catch (\Exception $e) {
       \Log::info($e);
        DB::rollBack();
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}

public function requestDeletion(Request $request)
    {

        $existingRequest = UserDeletionRequest::where('user_id', $request->id)->first();
        if ($existingRequest) {
            return response()->json(['message' => 'Request already submitted'], 400);
        }

        $request = UserDeletionRequest::create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Deletion request submitted', 200]);
    }


    public function deleteUserIndex()
    {
        $provinces = Province::all();
        $districts = District::all();
        $schools = School::all();
        $grades = Grade::all();
        return view('pages.setting.requests.delete_users_index', compact('provinces', 'districts', 'schools', 'grades' ));
    }


    public function delete_user_list(Request $request)
{
    if ($request->ajax()) {

        $data = UserDeletionRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();
        return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('name', function ($row) {
                return $row->user ? $row->user->name : '';
            })

            ->addColumn('identity_number', function ($row) {
                return $row->user ? $row->user->identity_number : '';
            })

            ->addColumn('email', function ($row) {
                return $row->user ? $row->user->email : '';
            })

            ->addColumn('role', function ($row) {
                return $row->user ? $row->user->role : '';
            })

            ->addColumn('requested_date', function ($row) {
                return $row->created_at
                    ? $row->created_at->format('Y-m-d')
                    : '';
            })
            ->addColumn('actions', function ($row) {
                return '
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm"
                        onclick="approveRecordID=' . $row->user_id . ';">
                        <i class="material-icons" style="color:darkgreen">check</i>
                    </a>

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-reject"
                        onclick="rejectRecordID=' . $row->user_id . ';">
                        <i class="material-icons" style="color:red">cancel</i>
                    </a>
                ';
            })

            ->rawColumns(['actions'])
            ->make(true);
    }
}


}
