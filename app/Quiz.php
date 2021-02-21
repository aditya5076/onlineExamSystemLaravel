<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Result;

class Quiz extends Model
{
    protected $fillable = ['name', 'description', 'minutes'];

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'quiz_user');
    }

    // assignExam
    public function assignExam($data)
    {
        $quizID = $data['quiz_id']; //from select's name tag
        $quiz = Quiz::find($quizID);
        $userID = $data['user_id']; //from select's name tag
        return $quiz->users()->syncWithoutDetaching($userID);
    }

    public function storeQuiz($data)
    {
        return Quiz::create($data);
    }

    public function editQuizById($id)
    {
        return Quiz::findOrFail($id);
    }

    public function updateQuiz($data, $id)
    {
        return Quiz::findOrFail($id)->update($data);
    }

    // check exam is been attempted
    public function isExamAttempted()
    {
        // get array of user's id
        $attemptQuiz = [];
        $authUser = auth()->user()->id;
        $userResult = Result::where('user_id', $authUser)->get();
        foreach ($userResult as $user_data) {
            array_push($attemptQuiz, $user_data->quiz_id);
        }
        return $attemptQuiz;
    }
}
