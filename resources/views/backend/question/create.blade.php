@extends('backend.layouts.master')

@section('title','create questions')

@section('content')

<div class="span9">
  <div class="content">


    @if (Session::has('message'))
    <div class="alert alert-success">{{Session::get('message')}}</div>
    @endif

    <form action="{{route('question.store')}}" method="POST">
      @csrf

      <div class="module">
        <div class="module-head">
          <h3>Create question</h3>
        </div>

        <div class="module-body">
          <div class="control-group">
            <label class="control-lable" for="name">choose quiz</label>
            <div class="controls">
              <select name="quiz" id="" class="span8">
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

          <div class="control-group">
            <label class="control-lable" for="name">question name</label>
            <div class="controls">
              <input type="text" name="question" class="span8 @error('name') border-red @enderror" placeholder="name of a question" value=" {{old('question')}}   ">
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

              @for($i=0;$i<4;$i++) <input type="text" name="options[]" class="span7 @error('name') border-red @enderror" placeholder="options{{$i+1}}">

                <input type="radio" name="correct_answer" value="{{$i}}">
                <span>is correct answer</span>
                @endfor

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