<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->is_admin == 1) {
            return redirect('/');
        }
        // get logged user's id
        $authUser = auth()->user()->id;

        //to store id of quizzes taken by logged in user
        $assignedQuizId = [];
        $user = DB::table('quiz_user')->where('user_id', $authUser)->get();
        foreach ($user as $user_data) {
            array_push($assignedQuizId, $user_data->quiz_id);
        }

        // to check array of id matching with quiz's id
        $quizzes = Quiz::whereIn('id', $assignedQuizId)->get();

        $isExamAssigned = DB::table('quiz_user')->where('user_id', $authUser)->exists();

        // check quiz completed
        $wasQuizCompleted = Result::where('user_id', $authUser)->whereIn('quiz_id', (new Quiz)->isExamAttempted())->pluck('quiz_id')->toArray();


        return view('home', compact('quizzes', 'wasQuizCompleted', 'isExamAssigned'));
    }
}
