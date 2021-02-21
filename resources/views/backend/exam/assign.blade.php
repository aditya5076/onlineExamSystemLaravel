@extends('backend.layouts.master')

@section('title','create exam')

@section('content')

<div class="span9">
  <div class="content">


    @if (Session::has('message'))
    <div class="alert alert-success">{{Session::get('message')}}</div>
    @endif

    <form action="{{route('assign.exam')}}" method="POST">
      @csrf

      <div class="module">
        <div class="module-head">
          <h3>Assign exam</h3>
        </div>

        <div class="module-body">
          <!-- assign quiz -->
          <div class="control-group">
            <label class="control-lable" for="name">choose quizzes</label>
            <div class="controls">
              <select name="quiz_id" id="" class="span8">
                @foreach(App\Quiz::all() as $quiz)
                <option value="{{$quiz->id}}">{{$quiz->name}}</option>
                @endforeach
              </select>
            </div>
            @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <!-- assign user -->
          <div class="control-group">
            <label class="control-lable" for="name">choose users</label>
            <div class="controls">
              <select name="user_id" id="" class="span8">
                @foreach(App\User::all() as $user)
                @if($user->is_admin!=1)
                <option value="{{$user->id}}">{{$user->name}}</option>
                @endif
                @endforeach
              </select>
            </div>
            @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror

          </div>



          <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>

          </div>

    </form>

  </div>
</div>


</div>
</div>

@endsection