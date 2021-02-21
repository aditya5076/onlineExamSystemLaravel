<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Answer;
use App\Quiz;

class Question extends Model
{
    protected $fillable = ['question', 'quiz_id'];

    private $limit = 10;
    private $order = 'DESC';

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function storequestion($data)
    {
        $data['quiz_id'] = $data['quiz'];
        return Question::create($data);
    }

    public function getquestions()
    {
        return Question::orderBy('created_at', $this->order)->with('quiz')->paginate($this->limit);
    }

    public function getquestionsById($id)
    {
        return Question::findOrFail($id);
    }

    public function editquestionsById($id)
    {
        return Question::findOrFail($id);
    }

    public function updateQuestion($data, $id)
    {
        $question = Question::findOrFail($id);
        $question->question = $data['question'];
        $question->quiz_id = $data['quiz'];
        $question->save();
        return $question;
    }
}
