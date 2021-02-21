@extends('layouts.app')

@section('content')
<quiz-component :times="{{$quiz->minutes}}" :quizId="{{$quiz->id}}" :quiz-questions="{{$quizQuestions}}" :has-quiz-played="{{$authUserHasPlayedQuiz}}">


</quiz-component>

<!-- to disable right-button -->
<script type="text/javascript">
  window.oncontextmenu = function() {
    console.log('right click is been disabled');
    return false;
  }
</script>



@endsection