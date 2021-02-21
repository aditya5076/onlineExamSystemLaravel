<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Quiz;
use App\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userExam()
    {
        $quizzes = Quiz::all();
        return view('backend.exam.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.exam.assign');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignExam(Request $request)
    {
        $quiz = (new Quiz)->assignExam($request->all());
        return redirect()->back()->with('message', 'exam assigned to user');
    }

    public function removeExam(Request $request)
    {
        $userId = $request->get('user_id');
        $quizId = $request->get('quiz_id');
        $quiz = Quiz::findOrFail($quizId);
        $result = Result::where('user_id', $userId)->where('quiz_id', $quizId)->exists();

        //check exam is been taken
        if ($result) {
            return redirect()->back()->with('error', 'exam is been completed by user. So cannot be removed');
        } else {
            // detach userId from quiz_user table
            $quiz->users()->detach($userId);
            return redirect()->back()->with('message', 'exam removed to user');
        }
    }

    public function getQuizQuestions(Request $request, $quizId)
    {
        $authUser = auth()->user()->id;

        // -----------------------ROUTE HANDLING--------------------------
        // to check if user has been assigned a particaular quiz
        $userId = DB::table('quiz_user')->where('user_id', $authUser)->pluck('quiz_id')->toArray();

        // check in userId[] is there a particaular quizId
        if (!in_array($quizId, $userId)) {
            return redirect()->to('/home')->with('error', 'this exam not assigned to you');
        }
        // -----------------------------------------------------------------

        $quiz = Quiz::find($quizId);
        $time = Quiz::where('id', $quizId)->pluck('minutes');

        // get ques linked with quiz
        $quizQuestions = Question::where('quiz_id', $quizId)->with('answers')->get();

        // check user haven taken exam before
        $authUserHasPlayedQuiz = Result::where(['user_id' => $authUser, 'quiz_id' => $quizId])->get();

        // -----------------------ROUTE HANDLING--------------------------
        // stop to access the questions once user completed the quiz
        $hasCompletedQuizArray = Result::where('user_id', $authUser)->whereIn('quiz_id', (new Quiz)->isExamAttempted())->pluck('quiz_id')->toArray();

        // check quiz_id is already there in hasCompletedQuizArray
        if (in_array($quizId, $hasCompletedQuizArray)) {
            return redirect()->to('/home')->with('error', 'you have already attempted exam');
        }

        return view('quiz', compact('quiz', 'time', 'quizQuestions', 'authUserHasPlayedQuiz'));
    }


    // store userRespones in results table
    public function postQuiz(Request $request)
    {
        $questionId = $request['questionId'];
        $answerId = $request['answerId'];
        $quizId = $request['quizId'];

        $authUser = auth()->user();

        return $userQuestionWithAnswer = Result::updateOrCreate([
            'user_id' => $authUser->id,
            'quiz_id' => $quizId,
            'question_id' => $questionId,
        ], ['answer_id' => $answerId]);
    }

    public function viewResult($userId, $quizId)
    {
        $results = Result::where('user_id', $userId)->where('quiz_id', $quizId)->get();
        // if (!$results->question) {
        //     return redirect()->to('/home')->with('message', 'exam assigned to user');
        // }
        return view('result-detail', compact('results'));
    }

    public function resultAdmin()
    {
        $quizzes = Quiz::all();
        return view('backend.result.index', compact('quizzes'));
    }

    public function userQuizResult($userId, $quizId)
    {
        $results = Result::where('user_id', $userId)->where('quiz_id', $quizId)->get();

        $totalQuestions = Question::where('quiz_id', $quizId)->count();

        // to get attempted questions by user
        $attempQuestions = Result::where('quiz_id', $quizId)->where('user_id', $userId)->count();

        $quiz = Quiz::where('id', $quizId)->get();

        // get correct answer_id and store in array
        $ans = [];
        foreach ($results as $result) {
            array_push($ans, $result->answer_id);
        }

        $userCorrectedAnswers = Answer::whereIn('id', $ans)->where('is_correct', 1)->count();
        // wrong answers
        $userWrongAnswers = $totalQuestions - $userCorrectedAnswers;
        // percentage
        if ($attempQuestions) {
            $percentage = ($userCorrectedAnswers / $totalQuestions) * 100;
        } else {
            $percentage = 0;
        }

        return view('backend.result.result', compact('results', 'totalQuestions', 'attempQuestions', 'userCorrectedAnswers', 'userWrongAnswers', 'percentage', 'quiz'));
    }
}
