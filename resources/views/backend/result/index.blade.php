@extends('backend.layouts.master')

@section('title','result')

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
        <h3>Result with Users</h3>
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
                <a href="result/{{$user->id}}/{{$quiz->id}}"><button class="btn btn-primary">view Result</button></a>
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