@extends('backend.layouts.master')

@section('title','update questions')

@section('content')

<div class="span9">
  <div class="content">

    @if (Session::has('message'))
    <div class="alert alert-success">{{Session::get('message')}}</div>
    @endif

    <form action="{{route('question.update',[$ques->id])}}" method="POST">
      @csrf
      {{method_field('PUT')}}

      <div class="module">
        <div class="module-head">
          <h3>update question</h3>
        </div>

        <div class="module-body">
          <div class="control-group">
            <label class="control-lable" for="name">choose quiz</label>
            <div class="controls">
              <select name="quiz" id="" class="span8">
                @foreach(App\Quiz::all() as $quiz)
                <option value="{{$quiz->id}}" @if($quiz->id == $ques->quiz_id)selected
                  @endif
                  >{{$quiz->name}}</option>
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
            <label class="control-lable" for="name">question name</label>
            <div class="controls">
              <input type="text" name="question" class="span8 @error('name') border-red @enderror" placeholder="name of a question" value=" {{$ques->question}}   ">
            </div>
            @error('question')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror

          </div>

          <div class="control-group">
            <label class="control-lable" for="name">options</label>
            <div class="controls">

              @foreach($ques->answers as $key=>$answer)
              <input type="text" name="options[]" class="span7" value="{{$answer->answer}}" placeholder="optio">

              <input type="radio" name="correct_answer" value="{{$key}}" @if($answer->is_correct==1){{'checked'}}@endif
              >
              <span>is correct answer</span>
              @endforeach

            </div>
            @error('question')
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