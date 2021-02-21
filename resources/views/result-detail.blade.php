@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <center>
                <h1>Your Result</h1>
            </center>
            @foreach($results as $result)
            <div class="card">
                <div class="card-header">Result</div>


                <div class="card-body">
                    <p>
                        <!-- to check question->question is not null -->
                        @if(isset($result->question['question']))
                    <h2>
                        <!-- to display questions as it is in array  -->
                        {{$result->question['question']}}
                    </h2>

                    </p>
                    @php
                    $i=1;

                    $answers=DB::table('answers')->where('question_id',$result->question_id)->get();
                    foreach($answers as $answer){
                    echo'<p>'.
                        $i++.')'.$answer->answer.
                        '</p>';
                    }
                    @endphp
                    <p>
                        <mark class="secondary">Your answer: {{$result->answer->answer}}</mark>
                    </p>

                    <!-- get correct answer -->
                    @php
                    $correctAnswers=DB::table('answers')->where('question_id',$result->question_id)->where('is_correct',1)->get();
                    foreach($correctAnswers as $answer){
                    echo'<p>'.
                        'correct-answer: '.$answer->answer.
                        '</p>';
                    }
                    @endphp

                    @if($result->answer->is_correct)
                    <p>
                        <span class="badge badge-success">Result:Correct</span>
                    </p>
                    @else
                    <p>
                        <span class="badge badge-danger">Result:InCorrect</span>
                    </p>
                    @endif
                    @else
                    <h2>
                        <mark>No Questions Attempted</mark>

                    </h2>
                    @endif
                </div>

            </div>

            @endforeach
        </div>
    </div>
</div>

@endsection