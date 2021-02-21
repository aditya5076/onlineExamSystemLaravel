@extends('backend.layouts.master')

@section('title','create questions')

@section('content')

<div class="span9">
  <div class="content">

    @if (Session::has('message'))
    <div class="alert alert-success">{{Session::get('message')}}</div>
    @endif

    <div class="module">
      <div class="module-head">
        <h3>All questions</h3>
      </div>

      <div class="module-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Questions</th>
              <th>Quiz</th>
              <th>Created</th>
              <th>edit</th>
              <th>delete</th>
              <th>view</th>
            </tr>
          </thead>
          <tbody>
            @if(count($questions)>0)
            @foreach($questions as $key=>$question)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$question->question}}</td>
              <td>{{$question->quiz->name}}</td>
              <td>{{date('F d,Y',strtotime($question->created_at))}}</td>
              <!-- edit route -->
              <td><a href="{{route('question.edit',[$question->id])}}">
                  <button class="btn btn-primary">edit</button>
                </a>
              </td>
              <!-- delete route -->
              <form action="{{route('question.destroy',[$question->id])}}" method="post" id="delete-question{{$question->id}}">@csrf
                {{method_field('DELETE')}}
              </form>

              <td><a href="#" onclick="warning()">
                  <input type="submit" value="delete" class="btn btn-danger">
                </a>
              </td>
              <!-- show route -->
              <td><a href="{{route('question.show',[$question->id])}}">
                  <button class="btn btn-primary">view</button>
                </a>
              </td>
            </tr>
            @endforeach
            @else
            <td>No question found</td>
            @endif
          </tbody>
        </table>
        <div class="pagination pagination-centered">
          {{$questions->links()}}
        </div>
      </div>
    </div>

  </div>

</div>
</div>

<script>
  const warning = () => {
    if (confirm('do you want delete?')) {
      event.preventDefault();
      document.getElementById('delete-question{{$question->id}}').submit()

    } else {
      event.preventDefault()
    }
  }
</script>



@endsection