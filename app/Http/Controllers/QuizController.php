<?php

namespace App\Http\Controllers;


use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizResult;
use App\Models\StudentTrackingChapter;
use App\Models\Content;
use App\Models\Chapter;
use App\Models\ChapterState;
use App\Http\Requests\StoreQuizeRequest;
use App\Http\Requests\UpdateQuizeRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Mockery\Undefined;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;


class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($subject_id,$chapter_id)
    {
        $subject_id = $subject_id;
        $chapter_id = $chapter_id;
        $references = Content::where('chapter_id',$chapter_id)->get();
        // dd($references[0]->title);

        return view('pages.setting.content.quiz_index', compact('subject_id', 'chapter_id','references'));
    }


public function startQuiz(Request $request){
    Session::put('quizStartTime', now());
    $chapter_id = $request->chapter_id;
    return view('pages.setting.content.quiz.startup_page', compact('chapter_id'));
}

public function quizAnswer(Request $request){
    $chapter_id = $request->chapter_id;
    Session::put("nextq", '1');
    Session::put("wrongans", '0');
    Session::put("correctans", '0');
    $question = Quiz::first();
    return view('pages.setting.content.quiz.answer', compact('chapter_id', 'question'));
}
    public function list(Request $request)
    {
        if ($request->ajax()) {

            $data = Quiz::where('chapter_id', $request->chapter_id)->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('Contents', function ($row) {
                //     if ($row->type == 'image') {
                //         $contentBody = '<a href="' . asset($row->body) . '" target="_blank">Download Content</a>';
                //         return $contentBody;
                //     } else {
                //         return $row->body;
                //     }
                // })
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


    public function submitAnsware(Request $request){
        $user_id = auth()->user()->id;
        $chapter_id = $request->chapter_id;
        $nextq = Session::get('nextq');
        $wrongans = Session::get('wrongans');
        $correctans = Session::get('correctans');
    
        $validate = $request->validate([
            'answer' => 'required',
            'correct_answer' => 'required',
        ]);
    
        $nextq += 1;
    
        if ($request->correct_answer == $request->answer) {
            $correctans += 1;
        } else {
            $wrongans += 1;
        }
    
        Session::put("nextq", $nextq);
        Session::put("wrongans", $wrongans);
        Session::put("correctans", $correctans);
    
        $questions = Quiz::all();
        if ($questions->count() < $nextq) {
            $endTime = now();
            $timeTaken = $endTime->diffInSeconds(Session::get('quizStartTime'));
            $data = [
                'question_id' => $request->question_id,
                'answer' => $request->answer,
                'created_by' => auth()->user()->id,
                'created_at' => date("Y-m-d H:i:s"),
            ];
            $result = QuizAnswer::create($data);

            $data = [
                'chapter_id' => $request->chapter_id,
                'total_questions' => $questions->count(),
                'total_correct_answers' => Session::get('correctans'),
                'time_taken' => $timeTaken,
                'student_id' => $user_id,
                'created_by' => auth()->user()->id,
                'created_at' => date("Y-m-d H:i:s"),
            ];
            QuizResult::create($data);


            return view('pages.setting.content.quiz.end_page', compact('chapter_id'));
        }
      
        $data = [
            'question_id' => $request->question_id,
            'answer' => $request->answer,
            'created_by' => auth()->user()->id,
            'created_at' => date("Y-m-d H:i:s"),
        ];
        $result = QuizAnswer::create($data);
        $question = $questions[$nextq - 1];
    return view('pages.setting.content.quiz.answer',  compact('chapter_id', 'question'));
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
                    'chapter_id' => $request->chapter_id,
                    'option_a_text' => $request->option_a_text,
                    'option_b_text' => $request->option_b_text,
                    'option_c_text' => $request->option_c_text,
                    'option_d_text' => $request->option_d_text,
                    'references' => $request->references,

                    'created_by' => auth()->user()->id,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                //first save record then update file fields when uploads are done
                $res = Quiz::create($data);
                DB::commit();

                $rec = Quiz::find($res->id);

                // dd($request->q_image);
                if (isset($request->q_image) && $request->q_image != 'undefined') {
                    $file1 = storeFiles($request, ['q_image'], $request->chapter_id . '-question');
                    $file_name = explode('/', $file1['q_image']);

                    if (empty($file1))
                        throw new \Exception('Image for question could not be uploaded');

                    $rec->question_image = end($file_name);
                } else {
                    $rec->question_image = '';
                }

                if (isset($request->option_a_image) && $request->option_a_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_a_image'], $request->chapter_id . '-option-a');
                    $file_name = explode('/', $file1['option_a_image']);

                    if (empty($file1))
                        throw new \Exception('Image for option a could not be uploaded');
                    $rec->option_a_image = end($file_name);
                } else {
                    $rec->option_a_image = '';
                }
                // dd($request->option_b_image);
                if (isset($request->option_b_image) && $request->option_b_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_b_image'], $request->chapter_id . '-option-b');
                    $file_name = explode('/', $file1['option_b_image']);

                    if (empty($file1))
                        throw new \Exception('Image for option b could not be uploaded');
                    $rec->option_b_image = end($file_name);
                } else {
                    $rec->option_b_image = '';
                }
                if (isset($request->option_c_image) && $request->option_c_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_c_image'], $request->chapter_id . '-option-c');
                    $file_name = explode('/', $file1['option_c_image']);
                    if (empty($file1))
                        throw new \Exception('Image for option c could not be uploaded');
                    $rec->option_c_image = end($file_name);
                } else {
                    $rec->option_c_image = '';
                }
                if (isset($request->option_d_image) && $request->option_d_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_d_image'], $request->chapter_id . '-option-d');
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
        $data['quiz'] = Quiz::find($request->id);
        // $data['quiz']->question_image = asset($data['quiz']->question_image);
        // dd(asset($data['quiz']->question_image));
        $data['lesson_reference'] = Content::whereIn('id',explode(',',$data['quiz']->references))->get();
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
                $rec = Quiz::find($request->id);

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
                    $file1 = storeFiles($request, ['q_image'], $request->chapter_id . '-question');

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
                    $file1 = storeFiles($request, ['option_a_image'], $request->chapter_id . '-option-a');
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
                    $file1 = storeFiles($request, ['option_b_image'], $request->chapter_id . '-option-b');
                    $file_name = explode('/', $file1['option_b_image']);
                    if (empty($file1)) {
                        throw new \Exception('Image for option b could not be uploaded');
                    } else {
                        $res = File::delete(base_path() . '/storage/app/public/uploads/q_image/' .$rec->option_b_image);
                        $rec->option_b_image = end($file_name);
                    }
                }
                if (isset($request->option_c_image) && $request->option_c_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_c_image'], $request->chapter_id . '-option-c');
                    $file_name = explode('/', $file1['option_c_image']);
                    if (empty($file1)) {
                        throw new \Exception('Image for option c could not be uploaded');
                    } else {
                        $res = File::delete(base_path() . '/storage/app/public/uploads/q_image/' .$rec->option_c_image);
                        $rec->option_c_image = end($file_name);
                    }
                }
                if (isset($request->option_d_image) && $request->option_d_image != 'undefined') {
                    $file1 = storeFiles($request, ['option_d_image'], $request->chapter_id . '-option-d');
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
                on c.id = q.chapter_id      
        where c.id = '.$chapter_id.' 
            and c.grade_id = '.$grade_id.'     
            and u.id = '.$user_id .'');

            if($startQuiz == []){
                return response(['message' => 'Quiz is not exist for this chapter'], 422)
                    ->header('Content-Type', 'text/json');
            }else{
                return response()->json($startQuiz, 200);
            }
    }

    public function quizQuestionMobile(Request $request){
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
               q.question_text as question,
               q.option_a_text as optiona,
               q.option_b_text as optionb,
               q.option_c_text as optionc,
               q.option_d_text as optiond

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
                on c.id = q.chapter_id      
        where c.id = '.$chapter_id.' 
            and c.grade_id = '.$grade_id.'     
            and u.id = '.$user_id .'');

            if($startQuiz == []){
                return response(['message' => 'Quiz is not exist for this chapter'], 422)
                    ->header('Content-Type', 'text/json');
            }else{
                return response()->json($startQuiz, 200);
            }
    }

    public function submitQuizQuesAnswareMobile(Request $request)
    {
        $user_id = auth()->user()->id;
    
        // Validate the request data
        $validatedData = $request->validate([
            'chapter_id' => 'required',
            'questions' => 'required|array',
            'questions.*.question_id' => 'required',
            'questions.*.answer' => 'required',
            'time_taken' => 'required',
        ]);
    
        $chapterId = $validatedData['chapter_id'];
        $timeTaken = $validatedData['time_taken'];
    
        $totalCorrectAnswers = 0;
    
        // Store the quiz data
        foreach ($validatedData['questions'] as $questionData) {
            $questionId = $questionData['question_id'];
            $answer = $questionData['answer'];
    
            // Create a new quiz answer instance
            $quizAnswer = new QuizAnswer();
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
        $quizResult = new QuizResult();
        $quizResult->chapter_id = $chapterId;
        $quizResult->total_correct_answers = $totalCorrectAnswers;
        $quizResult->time_taken = $timeTaken;
        $quizResult->total_questions = count($validatedData['questions']);
        $quizResult->student_id = $user_id;
        $quizResult->state = '1';

        $quizResult->save();

        $chapter = Chapter::findOrFail($chapterId);
        $chapter->state = '1';
        $chapter->save();

        $chapterState = ChapterState::where('chapter_id', $chapterId)->where('user_id',  $user_id)->first();
    
       if(!empty($chapterState)){
       
        $chapterState->state = '1';
        $chapterState->save();
       }else{
        $chapter_state = [
            'chapter_id' =>  $chapterId,
            'user_id' =>  $user_id,
            'state' => '1',
        ];
        ChapterState::create($chapter_state);
       }


        $studentTrackingChapter = StudentTrackingChapter::where('student_id', $user_id)
        ->where('chapter_id', $chapterId)
        ->first(); // Retrieve the model instance using "first()" or "firstOrFail()"
    
    if ($studentTrackingChapter) {
        $studentTrackingChapter->chapter_end_date = date("Y-m-d H:i:s");
        $studentTrackingChapter->save();
    }

        // Return a response
        return response()->json(['message' => 'Quiz submitted successfully'], 200);
    }
    
    private function isAnswerCorrect($questionId, $answer)
    {
        $correctDBAnswer = Quiz::select('correct_answer')->where('id', $questionId)->first();
    
        if ($correctDBAnswer && $correctDBAnswer->correct_answer === $answer) {
            return true;
        }
    
        return false;
    }



    public function quizAnswers(Request $request){
         $user_id = auth()->user()->id;
        $chapter_id = $request->chapter_id;
        $quizAnswers = DB::select('select 
                        qa.question_id,
                        qa.answer
                    from quiz_answers as qa    
                    left join quizes as q
                        on q.id = qa.question_id
                    left join chapters as c
                        on c.id = q.chapter_id
                    where c.id = '.$chapter_id .'
                    and qa.created_by = '.$user_id .'');

                if($quizAnswers == []){
                    return response(['message' => 'There is no submitted quiz for this chapter'], 422)
                        ->header('Content-Type', 'text/json');
                }else{
                    return response()->json($quizAnswers, 200);
                }

            }


public function deleteQuizData()
    {
        DB::table('quiz_answers')->truncate();
        DB::table('quiz_results')->truncate();

        return response()->json(['message' => 'Tables truncated successfully']);
    }
    
}
