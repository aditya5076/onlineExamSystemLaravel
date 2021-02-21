@extends('backend.layouts.master')

@section('title','result')

@section('content')


@if (Session::has('message'))
<div class="alert alert-success">{{Session::get('message')}}</div>
@elseif(Session::has('error'))
<div class="alert alert-danger">{{Session::get('error')}}</div>

@endif

<div class="span9">
  <div class="content">

    <div class="module">
      <div class="module-head">
        <h3>All Result</h3>
      </div>

      <div class="module-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th> Test</th>
              <th>total questions</th>
              <th>attempt questions</th>
              <th>correct answers</th>
              <th>wrong answers</th>
              <th>percentage</th>
            </tr>
          </thead>
          <tbody>
            @foreach($quiz as $key=>$quiz)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$quiz->name}}</td>
              <td>{{$totalQuestions}}</td>
              <td>{{$attempQuestions}}</td>
              <td>{{$userCorrectedAnswers}}</td>
              <td>{{$userWrongAnswers}}</td>
              <td>{{round($percentage,2)}}%</td>
            </tr>
            @endforeach
          </tbody>
        </table>

        <br>
        <!-- user response -->
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>questions</th>
              <th>answers given</th>
              <th>result</th>
            </tr>
          </thead>
          <tbody>
            @foreach($results as $key=>$result)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$result->question->question}}</td>
              <td>{{$result->answer->answer}}</td>
              @if($result->answer->is_correct)
              <td>correct</td>
              @else
              <td>incorrect</td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>

</div>
</div>

@endsection