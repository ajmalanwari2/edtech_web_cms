<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $student = DB::select('select count(id) as student_count from students');
        $teacher = DB::select('select count(id) as teacher_count from teachers');
        $parent = DB::select('select count(id) as parent_count from student_parents');

        $student_count = $student && isset($student[0]->student_count) ? $student[0]->student_count : 0;
        $teacher_count = $teacher && isset($teacher[0]->teacher_count) ? $teacher[0]->teacher_count : 0;
        $parent_count = $parent && isset($parent[0]->parent_count) ? $parent[0]->parent_count : 0;

        $student_male_count = DB::table('students')
            ->whereRaw('LOWER(gender) = ?', ['male'])
            ->count();
        $student_female_count = DB::table('students')
            ->whereRaw('LOWER(gender) = ?', ['female'])
            ->count();
        $teacher_male_count = DB::table('teachers')
            ->whereRaw('LOWER(gender) = ?', ['male'])
            ->count();
        $teacher_female_count = DB::table('teachers')
            ->whereRaw('LOWER(gender) = ?', ['female'])
            ->count();
        $parent_male_count = DB::table('student_parents')
            ->whereRaw('LOWER(gender) = ?', ['male'])
            ->count();
        $parent_female_count = DB::table('student_parents')
            ->whereRaw('LOWER(gender) = ?', ['female'])
            ->count();

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
        $syncUsers = DB::table('users')->where('role', '!=', 'admin')->where('status', '=', '1')->count();
        $unSyncUsers = DB::table('users')->where('role', '!=', 'admin')->where('status', '=', '0')->count();
        $lessons = DB::table('chapters')->count();
        $courses = DB::table('courses')->count();
        $libraryDocumentContents = DB::table('library_document_contents')->count();
        $libraryAudioContents = DB::table('library_audio_contents')->count();
        $libraryVideoContents = DB::table('library_video_contents')->count();
        $libraryKitContents = DB::table('library_kit_contents')->count();

        $libraries = $libraryDocumentContents + $libraryAudioContents + $libraryVideoContents + $libraryKitContents;

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

        // $data = DB::select('
        //     SELECT
        //         MONTHNAME(created_at) AS month,
        //         SUM(CASE WHEN role = \'student\' THEN 1 ELSE 0 END) AS student_count,
        //         SUM(CASE WHEN role = \'teacher\' THEN 1 ELSE 0 END) AS teacher_count,
        //         SUM(CASE WHEN role = \'parent\' THEN 1 ELSE 0 END) AS parent_count
        //     FROM
        //     users
        //     GROUP BY
        //     MONTH(created_at)
        //     ');

        //     $chartData = [];
        //     foreach ($data as $row) {
        //         $chartData[] = [
        //             'month' => $row->month,
        //             'student_count' => $row->student_count,
        //             'teacher_count' => $row->teacher_count,
        //             'parent_count' => $row->parent_count,
        //         ];
        //     }
        $year = request('year', 2026); // Default year = 2026

        $data = DB::select(
            "
    SELECT
        MONTHNAME(u.created_at) AS month,
        MONTH(u.created_at) AS month_number,
        SUM(CASE WHEN u.role = 'student' THEN 1 ELSE 0 END) AS student_count,
        SUM(CASE WHEN u.role = 'teacher' THEN 1 ELSE 0 END) AS teacher_count,
        SUM(CASE WHEN u.role = 'parent' THEN 1 ELSE 0 END) AS parent_count,
        SUM(CASE WHEN u.role = 'student' AND LOWER(s.gender) = 'male' THEN 1 ELSE 0 END) AS student_male_count,
        SUM(CASE WHEN u.role = 'student' AND LOWER(s.gender) = 'female' THEN 1 ELSE 0 END) AS student_female_count,
        SUM(CASE WHEN u.role = 'teacher' AND LOWER(t.gender) = 'male' THEN 1 ELSE 0 END) AS teacher_male_count,
        SUM(CASE WHEN u.role = 'teacher' AND LOWER(t.gender) = 'female' THEN 1 ELSE 0 END) AS teacher_female_count,
        SUM(CASE WHEN u.role = 'parent' AND LOWER(sp.gender) = 'male' THEN 1 ELSE 0 END) AS parent_male_count,
        SUM(CASE WHEN u.role = 'parent' AND LOWER(sp.gender) = 'female' THEN 1 ELSE 0 END) AS parent_female_count
    FROM users u
    LEFT JOIN students s
        ON u.id = s.user_id AND u.role = 'student'
    LEFT JOIN teachers t
        ON u.id = t.user_id AND u.role = 'teacher'
    LEFT JOIN student_parents sp
        ON u.id = sp.user_id AND u.role = 'parent'
    WHERE YEAR(u.created_at) = ?
        AND u.role IN ('student', 'teacher', 'parent')
    GROUP BY MONTH(u.created_at), MONTHNAME(u.created_at)
    ORDER BY month_number ASC
",
            [$year],
        );

        $chartData = [];

        foreach ($data as $row) {
            $chartData[] = [
                'month' => $row->month,
                'student_count' => $row->student_count,
                'teacher_count' => $row->teacher_count,
                'parent_count' => $row->parent_count,
                'student_male_count' => $row->student_male_count,
                'student_female_count' => $row->student_female_count,
                'teacher_male_count' => $row->teacher_male_count,
                'teacher_female_count' => $row->teacher_female_count,
                'parent_male_count' => $row->parent_male_count,
                'parent_female_count' => $row->parent_female_count,
            ];
        }
        $grades = Grade::get();
        $gradeId = '';
        if (!empty($grades)) {
            $gradeId = isset($grades[0]->id) ? $grades[0]->id : 0;
        } else {
            $gradeId = 0;
        }

        $subject_statistics = DB::select(
            '
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
    where g.id = ' . $gradeId,
        );

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
        return view('pages.dashboard.index', compact('student_count', 'teacher_count', 'parent_count', 'studentPercentage', 'teacherPercentage', 'parentPercentage', 'totalUsers', 'student_male_count', 'student_female_count', 'teacher_male_count', 'teacher_female_count', 'parent_male_count', 'parent_female_count', 'chartData', 'year', 'syncUsers', 'unSyncUsers', 'lessons', 'courses', 'libraries', 'grades', 'subject_statistics', 'library_videos', 'library_audios', 'library_documents', 'library_kits', 'courses_statistics', 'grade_statisticts', 'provincial_user_statistics', 'syncUserPercentage', 'unSyncUserPercentage', 'totalUsersPercentage'));
    }

    public function landing()
    {
        $grades = Grade::all();
        return view('pages.landing.index', compact('grades'));
    }

    public function subjectList($grade_id)
    {
        $grades = Grade::all();
        $subjects = DB::select(
            'SELECT
        sub.id AS subject_id,
        sub.name AS subject_name,
        g.name as grade_name,
        COALESCE(COUNT(sl.id), \'N/A\') AS number_of_lessons
      FROM subjects AS sub
      LEFT JOIN subjects_in_grades AS sig ON sub.id = sig.subject_id
      LEFT JOIN grades AS g ON g.id = sig.grade_id
      LEFT JOIN chapters AS ch ON sub.id = ch.subject_id
      LEFT JOIN subject_lessons AS sl ON ch.id = sl.chapter_id AND sl.type = \'video\'
      WHERE g.id = ' .
                $grade_id .
                '
      GROUP BY sub.id, sub.name',
        );

        // if($subjects == []){
        //     return response(['message' => 'The student is not registered'], 422)
        //         ->header('Content-Type', 'text/json');
        // }else{
        //     return response()->json($subjects, 200);
        // }
        return view('pages.landing.subject', compact('subjects', 'grades'));
    }

    public function lessonList($subject_id)
    {
        $grades = Grade::all();
        $lessons = DB::select(
            'select
            sl.id,
            sl.chapter_id,
            sl.title,
            sl.body,
            sl.type,
            g.name as grade_name,
            s.name as subject_name,
            ch.name as chapter_name
        from subject_lessons sl
        join chapters ch
            on sl.chapter_id=ch.id
        join subjects as s
            on s.id = ch.subject_id
        join grades as g
            on g.id = ch.subject_id
            where sl.type=\'video\'
            and ch.subject_id=' .
                $subject_id .
                '',
        );
        return view('pages.landing.lessons', compact('lessons', 'grades'));
    }

    //api for loading videos of grade
    public function loadGradeVideos($grade_id)
    {
        // if ($request->ajax()) {
        $grade['info'] = Grade::find($grade_id);
        $grade['videos'] = DB::select('select * from subject_lessons sl join chapters ch on sl.chapter_id=ch.id where sl.type=\'video\' and ch.grade_id=' . $grade_id);
        return response()->json(['grade' => $grade]);
        // }
    }

    public function create(Request $request)
    {
        return view('pages.setting.create');
    }

    public function store(Request $request)
    {
        $document = Setting::create($request->input());
        return redirect()->route('settings.create')->with('success', 'The record is added successfully..');
    }
}
