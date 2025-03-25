<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Grade;
use App\Models\School;
use App\Models\Province;
use App\Models\District;
use App\Models\CourseContent;
use App\Models\Content;
use App\Models\UserCreationRequest;
use App\Rules\ExistsProvinceForeignKey;
use App\Rules\ExistsDistrictForeignKey;
use App\Rules\ExistsSchoolForeignKey;
use App\Rules\ExistsGradeForeignKey;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Mail\ContactUsMail;

class FrontEndController extends Controller
{
    protected $lang;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $_SESSION['lang'] = $request->route('lang') != '' ? $request->route('lang') : $_SESSION['lang'];
        $this->lang = $_SESSION['lang'];
        \App::setLocale($this->lang);
        // $this->middleware('auth');
    }
    public function getLang()
    {
        return $this->lang;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lang = $this->getLang();

        $total_registered_students = DB::table('users')->where('role', 'student')->count();
        $lessonVideoCount = DB::table('subject_lessons')->where('type', 'video')->count();
        $libraryVideoCount = DB::table('library_video_contents')->count();
        $courseVideoCount = DB::table('course_contents')->where('type', 'video')->count();

        $videoCount = $lessonVideoCount + $libraryVideoCount +  $courseVideoCount;




        $lessonAudioCount = DB::table('subject_lessons')->where('type', 'audio')->count();
        $libraryAudioCount = DB::table('library_audio_contents')->count();
        $courseAudioCount = DB::table('course_contents')->where('type', 'audio')->count();

        $audioCount = $lessonAudioCount + $libraryAudioCount +  $courseAudioCount;

        $lessonDocumentCount = DB::table('subject_lessons')->where('type', 'file')->count();
        $libraryDocumentCount = DB::table('library_document_contents')->count();
        $courseDocumentCount = DB::table('course_contents')->where('type', 'file')->count();

        $documentCount = $lessonDocumentCount + $libraryDocumentCount +  $courseDocumentCount;
        //News
        $newsEnglish = DB::select('
            select
                id,
                title,
                description,
                photo,
                created_at
            from news
            where language = \'en\'');
        $newsDari = DB::select('
            select
                id,
                title,
                description,
                photo,
                created_at
            from news
            where language = \'da\'');

        if ($this->lang == 'en') {
            return view('pages.frontend.home', compact(
                'lang',
                'total_registered_students',
                'videoCount',
                'audioCount',
                'documentCount',
                'newsEnglish'
            ));
        } else {
            return view('pages.frontend.home_rtl', compact(
                'lang',
                'total_registered_students',
                'videoCount',
                'audioCount',
                'documentCount',
                'newsDari'
            ));
        }
    }

    public function aboutus()
    {

        $lang = $this->getLang();
        if ($this->lang == 'en') {
            return view('pages.frontend.about', compact('lang'));
        } else {
            return view('pages.frontend.about_rtl', compact('lang'));
        }
    }
    public function contact()
    {
        $provinces = Province::all();
        $districts = District::all();
        // dd(\App::getLocale());
        $lang = $this->getLang();

        if ($this->lang == 'en') {
            return view('pages.frontend.contact', compact('lang','provinces','districts'));
        } else {
            return view('pages.frontend.contact_rtl', compact('lang','provinces','districts'));
        }
    }


    public function contact_submit(Request $request)
    {
       try{
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string|max:255',
            'province_id' => ['required', new ExistsProvinceForeignKey],
            'district_id' => ['required', new ExistsDistrictForeignKey],
        ]);

        if ($validator->fails()) {
            // Return error response with validation errors
            session(['msg'=>$validator->messages()]);
            return redirect()->back();
        }

        $details = [
            'name' => $request->name,
        ];
        \Log::info($request->all());
        \Log::info(config('app.helpdesk_email'));
        \Mail::to(config('app.helpdesk_email'))->send(new ContactUsMail($details,$request->all()));

        // \Mail::to($request->email)->send(new \App\Mail\UserRegistrationMail($details));

        

        session(['msg'=>'We have received your message.']);
        return redirect()->back();
        
       }catch(Exception $e){
        session(['msg'=>$e->getMessage()]);
                return redirect()->back();
       }
    }




    public function getGradedThroughLanguage(Request $request){
        $lang_id = $request->post('lang_id');
        if($lang_id == 'en'){
            $lang_id = 'pa';
        }else{
            $lang_id = $request->post('lang_id');
        } 
        $grades = DB::table('grades')->where('language', $lang_id)->get();
        $html = '<option value="">Select</option>';
        foreach($grades as $grade){
            $html.='<option value="'.$grade->id.'">' .$grade->name.'</option>';
        }
        return $html;
    }

    public function request_form()
    {
       
        // $schools = School::all();
       
        $provinces = Province::all();
        $districts = District::all();
        // dd(\App::getLocale());
        $lang = $this->getLang();
        $grades = Grade::where('status', '1', )->where('language', $lang )->get();
        if ($this->lang == 'en') {
            $grades = Grade::where('status', '1', )->where('language', 'pa' )->get();
            return view('pages.frontend.request_form', compact('lang', 'grades', 'provinces', 'districts'));
        } else {
            return view('pages.frontend.request_form_rtl', compact('lang', 'grades', 'provinces', 'districts'));
        }
    }
    public function request_form_submit(Request $request)
    {
        $school = School::first();
        
        try {

            $identity_number = UserCreationRequest::where('identity_number', $request->identity_number)->get();

            // Validate the user input
            if ($request->role === 'teacher') {
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
                ]);
            } elseif ($request->role === 'parent') {
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
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:255',
                    'identity_number' => 'required|string|max:255|unique:users',
                    'email' => 'required|string|email|max:255',
                    'password' => 'required|string|min:8',
                    'language' => 'required|string',
                    'phone_no' => 'required|string|max:255',
                    'gender' => 'required|string|max:255',
                    'role' => 'required|string|max:255',
                    'province_id' => ['required', new ExistsProvinceForeignKey],
                    'district_id' => ['required', new ExistsDistrictForeignKey],
                    'grade_id' => ['required', new ExistsGradeForeignKey],
                ]);
            }
            // $validator->getMessageBag()->add('first_name.required', 'The name field is required.');
            // $validator->getMessageBag()->add('email.required', 'The name field is required.');
            

            if ($validator->fails()) {
                // Return error response with validation errors
                session(['msg'=>$validator->messages()]);
                return redirect()->back();
            }

            if (count($identity_number) != 0) {
                session(['msg'=>'This identity_number already exist']);
                return redirect()->back();
            }
            DB::beginTransaction();
            $data = $request->input();
            $data['school_id'] = $school->id;
            $result = UserCreationRequest::create($data);
            DB::commit();

            
            if($result->id != '')
                session(['msg'=>'We have recieved your request. Wait for approval']);


                return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            session(['msg'=>$e->getMessage()]);
            return redirect()->back();
        }
    }
    public function content()
    {
        $lang = $this->getLang();

        if ($this->lang=='en'){
            $gradesEnglish = DB::select('
            SELECT
    g.id AS grade_id,
    g.name AS grade_name,
    CASE
        WHEN g.language = \'pa\' THEN \'پشتو\'
        ELSE \'دری\'
    END AS grade_language,
    COALESCE(COUNT(DISTINCT s.id), 0) AS subject_count,
    (
        SELECT COUNT(sl.id)
        FROM subject_lessons AS sl
        JOIN chapters AS ch ON ch.id = sl.chapter_id
        JOIN subjects AS s2 ON s2.id = ch.subject_id
        JOIN subjects_in_grades AS sig ON sig.subject_id = s2.id
        JOIN grades AS g2 ON g2.id = sig.grade_id
        WHERE g2.id = g.id
            AND sl.type = \'video\'
    ) AS video_count
FROM grades AS g
LEFT JOIN subjects_in_grades AS sig ON g.id = sig.grade_id
LEFT JOIN subjects AS s ON s.id = sig.subject_id
WHERE g.language = \'pa\'
and g.status = \'1\'
GROUP BY g.id, g.name, g.language');
            return view('pages.frontend.content',compact('lang', 'gradesEnglish'));
        }else{
            $gradesDari = DB::select('
            SELECT
    g.id AS grade_id,
    g.name AS grade_name,
    CASE
        WHEN g.language = \'da\' THEN \'دری\'
        ELSE \'پشتو\'
    END AS grade_language,
    COALESCE(COUNT(DISTINCT s.id), 0) AS subject_count,
    (
        SELECT COUNT(sl.id)
        FROM subject_lessons AS sl
        JOIN chapters AS ch ON ch.id = sl.chapter_id
        JOIN subjects AS s2 ON s2.id = ch.subject_id
        JOIN subjects_in_grades AS sig ON sig.subject_id = s2.id
        JOIN grades AS g2 ON g2.id = sig.grade_id
        WHERE g2.id = g.id
            AND sl.type = \'video\'
    ) AS video_count
FROM grades AS g
LEFT JOIN subjects_in_grades AS sig ON g.id = sig.grade_id
LEFT JOIN subjects AS s ON s.id = sig.subject_id
WHERE g.language = \'da\'
and g.status = \'1\'
GROUP BY g.id, g.name, g.language');

$gradesPashto = DB::select('
            SELECT
    g.id AS grade_id,
    g.name AS grade_name,
    CASE
        WHEN g.language = \'pa\' THEN \'پشتو\'
        ELSE \'دری\'
    END AS grade_language,
    COALESCE(COUNT(DISTINCT s.id), 0) AS subject_count,
    (
        SELECT COUNT(sl.id)
        FROM subject_lessons AS sl
        JOIN chapters AS ch ON ch.id = sl.chapter_id
        JOIN subjects AS s2 ON s2.id = ch.subject_id
        JOIN subjects_in_grades AS sig ON sig.subject_id = s2.id
        JOIN grades AS g2 ON g2.id = sig.grade_id
        WHERE g2.id = g.id
            AND sl.type = \'video\'
    ) AS video_count
FROM grades AS g
LEFT JOIN subjects_in_grades AS sig ON g.id = sig.grade_id
LEFT JOIN subjects AS s ON s.id = sig.subject_id
WHERE g.language = \'pa\'
and g.status = \'1\'
GROUP BY g.id, g.name, g.language');
            return view('pages.frontend.content_rtl',compact('lang', 'gradesDari', 'gradesPashto'));
        }
    }

    public function grade($lang, $id)
    {
        $lang = $this->getLang();

$grade = Grade::find($id);

        $subjects = DB::select('
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
        s.icon as subject_icon,
        g.id as grade_id
        from subjects as s
        join subjects_in_grades as sig
        on s.id = sig.subject_id
        join grades as g
        on g.id = sig.grade_id
        where g.id = '.$id .'');
        
        if ($this->lang=='en'){
            return view('pages.frontend.grades',compact('lang', 'subjects', 'grade'));
        }else{
            return view('pages.frontend.grades_rtl',compact('lang', 'subjects', 'grade'));
        }
    }

    public function subject($lang, $grade_id, $subject_id)
    {
        $lang = $this->getLang();
        $query = 'SELECT
 	ch.id as chapter_id,
    g.name AS grade_name,
    s.name AS subject_name,
    ch.number AS chapter_number,
    ch.name as chapter_name,
    sl.title,
    sl.body,
    sl.type
FROM chapters ch
JOIN subjects s ON s.id = ch.subject_id
JOIN subjects_in_grades sig ON s.id = sig.subject_id
JOIN grades g ON g.id = sig.grade_id
Left join subject_lessons as sl on sl.chapter_id = ch.id
    where s.id = :subject_id
    AND g.id = :grade_id';

$subjectContents = DB::select($query, ['subject_id' => $subject_id, 'grade_id' => $grade_id]);
//         $subjectContents = DB::select('select
//         sl.id,
//         sl.chapter_id,
//         sl.title,
//         sl.body,
//         sl.type,
//         g.name as grade_name,
//         s.name as subject_name,
//         ch.number as chapter_number
//     from subject_lessons sl 
//     join chapters ch 
//         on sl.chapter_id=ch.id 
//     join subjects as s
//         on s.id = ch.subject_id
//     join subjects_in_grades as sig
//     	on s.id = sig.subject_id
//     join grades as g
//         on g.id = sig.grade_id    
//         where sl.type=\'video\' or sl.type=\'file\' 
//         and s.id='.$subject_id.'
//         and g.id='.$grade_id.'
//    ');
        if ($this->lang == 'en') {
            return view('pages.frontend.subject', compact('lang', 'subjectContents'));
        } else {
            return view('pages.frontend.subject_rtl', compact('lang', 'subjectContents'));
        }
    }

    public function showVideo(Request $request)
    {
        if ($request->ajax()) {
            $video = Content::select('id', 'title', 'body')
            ->where('chapter_id', $request->id)
            ->where('type', 'video')->first();
           
    
            if ($video) {
                
                return response()->json($video);
            }else{
                return response()->json('video-not-available');
            }
        }
    
 
    }
    
    
     public function term_and_policy()
    {
    
        // dd(\App::getLocale());
        $lang = $this->getLang();

        if ($this->lang == 'en') {
            return view('pages.frontend.term_and_policy', compact('lang'));
        } else {
            return view('pages.frontend.term_and_policy_rtl', compact('lang'));
        }
    }

    public function showBook(Request $request)
    {
        if ($request->ajax()) {
            $book = Content::select('id', 'title', 'body')
            ->where('chapter_id', $request->id)
            ->where('type', 'file')->first();
           
    
            if ($book) {
                
                return response()->json($book);
            }else{
                return response()->json('book-not-available');
            }
        }
    
 
    }



    public function courseContent($lang, $id)
    {
        $lang = $this->getLang();
      
        $courseContents = DB::select('select
        cc.id,
        cc.title,
        cc.body,
        cc.type,
        c.name as course_name,
        c.id as course_id
    from course_contents cc
    join courses as c
    on c.id = cc.course_id
    where c.language = \''.$lang.'\'
    and cc.course_id = '.$id.'
   ');
   $courseContentEnglish = DB::select('select
        cc.id,
        cc.title,
        cc.body,
        cc.type,
        c.name as course_name,
         c.id as course_id
    from course_contents cc
    join courses as c
    on c.id = cc.course_id
    where c.language = \'pa\'
     and cc.course_id = '.$id.'
   ');
        if ($this->lang == 'en') {
            return view('pages.frontend.course_content', compact('lang', 'courseContentEnglish'));
        } else {
            return view('pages.frontend.course_content_rtl', compact('lang', 'courseContents'));
        }
    }


    public function course()
    {
        $lang = $this->getLang();

        if ($this->lang=='en'){
            $coursesEnglish = DB::select('
            SELECT
    c.id AS course_id,
    c.name AS course_name,
    CASE
        WHEN c.language = \'pa\' THEN \'پشتو\'
        ELSE \'دری\'
    END AS course_language,
    (
        SELECT COUNT(cc.id)
        FROM course_contents AS cc
        JOIN courses AS c2 ON c2.id = cc.course_id
        WHERE c2.id = c.id
            AND cc.type = \'video\'
    ) AS video_count
FROM courses AS c
WHERE c.language = \'pa\'
and c.status = \'1\'
GROUP BY c.id, c.name, c.language');
            return view('pages.frontend.course',compact('lang', 'coursesEnglish'));
        }else{
            $coursesDari = DB::select('
             SELECT
    c.id AS course_id,
    c.name AS course_name,
    CASE
        WHEN c.language = \'pa\' THEN \'دری\'
        ELSE \'پشتو\'
    END AS course_language,
    (
        SELECT COUNT(cc.id)
        FROM course_contents AS cc
        JOIN courses AS c2 ON c2.id = cc.course_id
        WHERE c2.id = c.id
            AND cc.type = \'video\'
    ) AS video_count
FROM courses AS c
WHERE c.language = \'da\'
and c.status = \'1\'
GROUP BY c.id, c.name, c.language');

$coursesPashto = DB::select('
             SELECT
    c.id AS course_id,
    c.name AS course_name,
    CASE
        WHEN c.language = \'pa\' THEN \'پشتو\'
        ELSE \'دری\'
    END AS course_language,
    (
        SELECT COUNT(cc.id)
        FROM course_contents AS cc
        JOIN courses AS c2 ON c2.id = cc.course_id
        WHERE c2.id = c.id
            AND cc.type = \'video\'
    ) AS video_count
FROM courses AS c
WHERE c.language = \'pa\'
and c.status = \'1\'
GROUP BY c.id, c.name, c.language');
            return view('pages.frontend.course_rtl',compact('lang', 'coursesDari', 'coursesPashto'));
        }
    }


    
    public function courseVideoShow(Request $request)
    {
        if ($request->ajax()) {
            $video = CourseContent::select('id', 'title', 'body')
            ->where('id', $request->id)
            ->where('type', 'video')->first();
           
    
            if ($video) {
                
                return response()->json($video);
            }else{
                return response()->json('video-not-available');
            }
        }
    
 
    }

    public function courseBookShow(Request $request)
    {
        if ($request->ajax()) {
            $book = CourseContent::select('id', 'title', 'body')
            ->where('course_id', $request->id)
            ->where('type', 'file')->first();
           
    
            if ($book) {
                
                return response()->json($book);
            }else{
                return response()->json('book-not-available');
            }
        }
    
 
    }



    public function landing()
    {
        $grades = Grade::all();
        return view('pages.landing.index', compact('grades'));
    }

    public function subjectList($grade_id)
    {

        $grades = Grade::all();
        $subjects = DB::select('SELECT
        sub.id AS subject_id,
        sub.name AS subject_name,
        g.name as grade_name,
        COALESCE(COUNT(sl.id), \'N/A\') AS number_of_lessons
      FROM subjects AS sub
      LEFT JOIN subjects_in_grades AS sig ON sub.id = sig.subject_id
      LEFT JOIN grades AS g ON g.id = sig.grade_id
      LEFT JOIN chapters AS ch ON sub.id = ch.subject_id
      LEFT JOIN subject_lessons AS sl ON ch.id = sl.chapter_id AND sl.type = \'video\'
      WHERE g.id = ' . $grade_id . '
      GROUP BY sub.id, sub.name');

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
        $lessons = DB::select('select
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
            and ch.subject_id=' . $subject_id . '');
        return view('pages.landing.lessons', compact('lessons', 'grades'));
    }

    //api for loading videos of grade
    public function loadGradeVideos($grade_id)
    {
        // if ($request->ajax()) {
        $grade['info'] = Grade::find($grade_id);
        $grade['videos'] = DB::select('select * from subject_lessons sl join chapters ch on sl.chapter_id=ch.id where sl.type=\'video\' and ch.grade_id=' . $grade_id);
        return response()->json(['grade' =>  $grade]);
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
