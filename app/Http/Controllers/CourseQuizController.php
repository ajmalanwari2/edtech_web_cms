<?php

namespace App\Http\Controllers;


use App\Models\CourseQuiz;
use App\Models\CourseState;
use App\Models\CourseQuizAnswer;
use App\Models\CourseQuizResult;
use App\Models\CourseContent;
use App\Models\Course;
use App\Http\Requests\StoreQuizeRequest;
use App\Http\Requests\UpdateQuizeRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Mockery\Undefined;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;


class CourseQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function list(Request $request)
    {
        if ($request->ajax()) {

            $data = CourseQuiz::where('course_id', $request->course_id)->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $actionBtn = '<a onclick="loadRecord(\'edit\',' . $row->id . ')" href="javascript.void(0)" data-toggle="modal" data-target="#modal-form">
            <i class="material-icons">edit</i></i></a> <a onclick="loadRecord(\'show\',' . $row->id . ')" href="javascript:void(0)"
            data-toggle="modal" data-target="#modal-view"><i class="material-icons"; style="color:SlateBlue">visibility</i></a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-confirm"
            onclick="deleteRecordID=' . $row->id . ';"> <i class="material-icons"; style="color:darkorange">delete</i></a>';

                    return $actionBtn;
                })
                ->rawColumns(['actions', 'Contents'])
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // sleep(5);
        // return response(['id' => '11'], 201)
        //                 ->header('Content-Type', 'text/json');
        try {
            if ($request->ajax()) {
                DB::beginTransaction();
                $data = [
                    'question_text' => $request->q_text,
                    'difficulty_level' => $request->difficulty_level,
                    'correct_answer' => $request->answer,
                    'course_id' => $request->course_id,
                    'option_a_text' => $request->option_a_text,
                    'option_b_text' => $request->option_b_text,
                    'option_c_text' => $request->option_c_text,
                    'option_d_text' => $request->option_d_text,
                    'references' => $request->references,

                    'created_by' => auth()->user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                //first save record then update file fields when uploads are done
                $res = CourseQuiz::create($data);
                DB::commit();

                $rec = CourseQuiz::find($res->id);

                // dd($request->q_image);
                if (isset($request->q_image) && $request->q_image != 'undefined') {
                    $file1 = storeFiles($request, ['q_image'], $request->course_id . '-question');
                    $file_name = explode('/', $file1['q_image']);

                    if (empty($file1))
                        throw new \Exception('Image for question could not be uploaded');

                    $rec->question_image = end($file_name);
                } else {
                    $rec->question_image = '';
                }

                if (isset($request->option_a_image) && $request->option_a_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_a_image'], $request->course_id . '-option-a');
                    $file_name = explode('/', $file1['option_a_image']);

                    if (empty($file1))
                        throw new \Exception('Image for option a could not be uploaded');
                    $rec->option_a_image = end($file_name);
                } else {
                    $rec->option_a_image = '';
                }
                // dd($request->option_b_image);
                if (isset($request->option_b_image) && $request->option_b_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_b_image'], $request->course_id . '-option-b');
                    $file_name = explode('/', $file1['option_b_image']);

                    if (empty($file1))
                        throw new \Exception('Image for option b could not be uploaded');
                    $rec->option_b_image = end($file_name);
                } else {
                    $rec->option_b_image = '';
                }
                if (isset($request->option_c_image) && $request->option_c_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_c_image'], $request->course_id . '-option-c');
                    $file_name = explode('/', $file1['option_c_image']);
                    if (empty($file1))
                        throw new \Exception('Image for option c could not be uploaded');
                    $rec->option_c_image = end($file_name);
                } else {
                    $rec->option_c_image = '';
                }
                if (isset($request->option_d_image) && $request->option_d_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_d_image'], $request->course_id . '-option-d');
                    $file_name = explode('/', $file1['option_d_image']);
                    if (empty($file1))
                        throw new \Exception('Image for option d could not be uploaded');
                    $rec->option_d_image = end($file_name);
                } else {
                    $rec->option_d_image = '';
                }
                $r = $rec->save();
                // Quiz::update($rec);

                // dd($data);

                // \Log::info($data);



                if (!empty($res->id)) {
                    return response(['id' => $res->id], 201)
                        ->header('Content-Type', 'text/json');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('content.index'))->with('error', $e->getMessage());
        }
    }
    //store images from tinycme
    public function storeImages(Request $request)
    {
        // dd($request);
        // $imgpath = request()->file('name')->store('uploads', 'public');
        $imgpath = Storage::disk('public')->put('quiz', $request->file);

        // return response()->json(['location' => config('app.app_url').'storage/' . $imgpath]);
        return response()->json(['location' =>  $imgpath]);
        // echo json_encode(array('location' => $imgpath));

    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data['quiz'] = CourseQuiz::find($request->id);
        // $data['quiz']->question_image = asset($data['quiz']->question_image);
        // dd(asset($data['quiz']->question_image));
        $data['course_reference'] = CourseContent::whereIn('id',explode(',',$data['quiz']->references))->get();
        // dd($references);
        return response()->json([$data]);
        // return view('pages.setting.content.quiz_index', compact('rec'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            if ($request->ajax()) {
                DB::beginTransaction();
                $rec = CourseQuiz::find($request->id);

                $rec->question_text =  $request->q_text;
                $rec->difficulty_level = $request->difficulty_level;
                $rec->correct_answer = $request->answer;
                $rec->option_a_text = $request->option_a_text;
                $rec->option_b_text = $request->option_b_text;
                $rec->option_c_text = $request->option_c_text;
                $rec->option_d_text = $request->option_d_text;
                $rec->references = $request->references;
                $rec->updated_at = date("Y-m-d H:i:s");

                //first save record then update file fields when uploads are done
                // $res = Quiz::create($data);
                // DB::commit();

                // $rec = Quiz::find($res->id);

                // dd($request->q_image);
                if (isset($request->q_image) && $request->q_image != 'undefined') {
                    $file1 = storeFiles($request, ['q_image'], $request->course_id . '-question');

                    $file_name = explode('/', $file1['q_image']);

                    if (empty($file1)) {
                        throw new \Exception('Image for question could not be uploaded');
                    } else {

                        //we will delete old file

                        $res = File::delete(base_path() .'/storage/app/public/uploads/q_image/' .$rec->question_image);
                        $rec->question_image = end($file_name);
                    }
                }
                // dd($rec->question_image);
                if (isset($request->option_a_image) && $request->option_a_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_a_image'], $request->course_id . '-option-a');
                    $file_name = explode('/', $file1['option_a_image']);
                    if (empty($file1)) {
                        throw new \Exception('Image for option a could not be uploaded');
                    } else {
                        $res = File::delete(base_path() . '/storage/app/public/uploads/q_image/' .$rec->option_a_image);
                        $rec->option_a_image = end($file_name);
                    }
                }
                // dd($request->option_b_image);
                if (isset($request->option_b_image) && $request->option_b_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_b_image'], $request->course_id . '-option-b');
                    $file_name = explode('/', $file1['option_b_image']);
                    if (empty($file1)) {
                        throw new \Exception('Image for option b could not be uploaded');
                    } else {
                        $res = File::delete(base_path() . '/storage/app/public/uploads/q_image/' .$rec->option_b_image);
                        $rec->option_b_image = end($file_name);
                    }
                }
                if (isset($request->option_c_image) && $request->option_c_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_c_image'], $request->course_id . '-option-c');
                    $file_name = explode('/', $file1['option_c_image']);
                    if (empty($file1)) {
                        throw new \Exception('Image for option c could not be uploaded');
                    } else {
                        $res = File::delete(base_path() . '/storage/app/public/uploads/q_image/' .$rec->option_c_image);
                        $rec->option_c_image = end($file_name);
                    }
                }
                if (isset($request->option_d_image) && $request->option_d_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_d_image'], $request->course_id . '-option-d');
                    $file_name = explode('/', $file1['option_d_image']);
                    if (empty($file1)) {
                        throw new \Exception('Image for option d could not be uploaded');
                    } else {
                        $res = File::delete(base_path() . '/storage/app/public/uploads/q_image/' .$rec->option_d_image);
                        $rec->option_d_image = end($file_name);
                    }
                }

                // \Log::info($rec);
                $r = $rec->save();
                DB::commit();
                // Quiz::update($rec);


                if ($r==1) {
                    return response(['id' => $rec->id], 201)
                        ->header('Content-Type', 'text/json');
                }else{
                    throw new \Exception('Issue while saving record');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('content.index'))->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizeRequest $request, Quiz $quize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quize)
    {
        //
    }

    // Mobile App API
    public function startQuizMobile(Request $request){
        $subject_id = $request->subject_id;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $grade_id = Student::select('grade_id')->where('user_id', $user_id)->get();
        $grade_id = $grade_id && $grade_id[0] ? $grade_id[0]->grade_id : NULL;
        if($user == NULL || $grade_id == NULL){
            return response(['message' => 'The user is not registered'], 400)
                ->header('Content-Type', 'text/json');
        }
        
        $startQuiz = DB::select('
        select
                count(q.id) as total_question,
                c.total_quiz_time
        from users as u
        left join students as s
        on u.id = s.user_id
        left join schools as sh
        on sh.id = s.school_id
        left join grades as g
        on g.id = s.grade_id
        left join subjects_in_grades as sig
            on g.id = sig.grade_id
        left join subjects as sub
            on sub.id = sig.subject_id
        left join chapters as c  
                on sub.id = c.subject_id
            left join quizes as q
                on c.id = q.course_id      
        where c.id = '.$course_id.' 
            and c.grade_id = '.$grade_id.'     
            and u.id = '.$user_id .'');

            if($startQuiz == []){
                return response(['message' => 'Quiz is not exist for this chapter'], 422)
                    ->header('Content-Type', 'text/json');
            }else{
                return response()->json($startQuiz, 200);
            }
    }

  
    public function submitCourseQuizQuesAnswareMobile(Request $request)
    {
        $user_id = auth()->user()->id;
    
        // Validate the request data
        $validatedData = $request->validate([
            'course_id' => 'required',
            'questions' => 'required|array',
            'questions.*.question_id' => 'required',
            'questions.*.answer' => 'required',
            'time_taken' => 'required',
        ]);
    
        $courseId = $validatedData['course_id'];
        $timeTaken = $validatedData['time_taken'];
    
        $totalCorrectAnswers = 0;
    
        // Store the quiz data
        foreach ($validatedData['questions'] as $questionData) {
            $questionId = $questionData['question_id'];
            $answer = $questionData['answer'];
    
            // Create a new quiz answer instance
            $quizAnswer = new CourseQuizAnswer();
            $quizAnswer->question_id = $questionId;
            $quizAnswer->answer = $answer;
            $quizAnswer->created_by = $user_id;
    
            // Save the quiz answer
            $quizAnswer->save();
    
            // Check if the answer is correct
            $isCorrect = $this->isAnswerCorrect($questionId, $answer);
    
            if ($isCorrect) {
                $totalCorrectAnswers++;
            }
        }
   
        // Create a new quiz result instance
        $quizResult = new CourseQuizResult();
        $quizResult->course_id = $courseId;
        $quizResult->total_correct_answers = $totalCorrectAnswers;
        $quizResult->time_taken = $timeTaken;
        $quizResult->total_questions = count($validatedData['questions']);
        $quizResult->student_id = $user_id;
        $quizResult->state = '1';

        $quizResult->save();

        $course = Course::findOrFail($courseId);
        $course->state = '1';
        $course->save();

        $courseState = CourseState::where('course_id', $courseId)->where('user_id',  $user_id)->first();
    
        if(!empty($courseState)){
        
         $courseState->state = '1';
         $courseState->save();
        }else{
         $course_state = [
             'course_id' =>  $courseId,
             'user_id' =>  $user_id,
             'state' => '1',
         ];
         CourseState::create($course_state);
        }
        // Return a response
        return response()->json(['message' => 'Quiz submitted successfully'], 200);
    }
    
    private function isAnswerCorrect($questionId, $answer)
    {
        $correctDBAnswer = CourseQuiz::select('correct_answer')->where('id', $questionId)->first();
    
        if ($correctDBAnswer && $correctDBAnswer->correct_answer === $answer) {
            return true;
        }
    
        return false;
    }



    public function courseQuizAnswers(Request $request){
        $course_id = $request->course_id;
        $quizAnswers = DB::select('select 
                        qa.question_id,
                        qa.answer
                    from course_quiz_answers as qa    
                    left join course_quizes as q
                        on q.id = qa.question_id
                    left join courses as c
                        on c.id = q.course_id
                    where c.id = '.$course_id .'');

                if($quizAnswers == []){
                    return response(['message' => 'There is no submitted quiz for this chapter'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($quizAnswers, 200);
                }

            }


            public function deleteCourseQuizData()
    {
        DB::table('course_quiz_answers')->truncate();
        DB::table('course_quiz_results')->truncate();

        return response()->json(['message' => 'Tables truncated successfully']);
    }
    
}
