@extends('backend.layouts.master')

@section('title','exam with user')

@section('content')

<div class="span9">
  <div class="content">

    @if (Session::has('message'))
    <div class="alert alert-success">{{Session::get('message')}}</div>
    @elseif(Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error')}}</div>

    @endif

    <div class="module">
      <div class="module-head">
        <h3>Assigned Exams with Users</h3>
      </div>

      <div class="module-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Quiz Name</th>
              <th>User's Name</th>
              <th>minutes</th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @if(count($quizzes)>0)
            @foreach($quizzes as $key=>$quiz)
            @foreach($quiz->users as $key=>$user)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$quiz->name}}</td>
              <td>{{$user->name}}</td>
              <td>{{$quiz->minutes}}</td>
              <td><a href="{{route('quiz.question',[$quiz->id])}}"><button class="btn btn-inverse">View Questions</button></a></td>

              <!-- remove exam -->
              <td>
                <form action="{{route('exam.remove')}}" method="post" id="delete-form{{$quiz->id}}">@csrf
                  <input type="hidden" name="user_id" value="{{$user->id}}">
                  <input type="hidden" name="quiz_id" value="{{$quiz->id}}">
                  <button class="btn btn-danger" type="submit">Remove</button>
                </form>
              </td>
            </tr>
            @endforeach
            @endforeach
            @else
            <td>No Quiz found</td>
            @endif
          </tbody>
        </table>
      </div>
    </div>

  </div>

</div>
</div>



@endsection