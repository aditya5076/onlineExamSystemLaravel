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
        <h3>All users</h3>
      </div>

      <div class="module-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>name</th>
              <th>email</th>
              <th>password</th>
              <th>occupation</th>
              <th>address</th>
              <th>phone</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @if(count($users)>0)
            @foreach($users as $key=>$user)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->visible_password}}</td>
              <td>{{$user->occupation}}</td>
              <td>{{$user->address}}</td>
              <td>{{$user->phone}}</td>
              <!-- edit route -->
              <td><a href="{{route('user.edit',[$user->id])}}">
                  <button class="btn btn-primary">edit</button>
                </a>
              </td>
              <!-- delete route -->
              <form action="{{route('user.destroy',[$user->id])}}" method="post" id="delete-user{{$user->id}}">@csrf
                {{method_field('DELETE')}}
              </form>

              <td><a href="#" onclick=" if (confirm('do you want delete?')) {
                  event.preventDefault();
                  document.getElementById('delete-user{{$user->id}}').submit()
                  } else {
                  event.preventDefault()
                  }">
                  <input type="submit" value="delete" class="btn btn-danger">
                </a>
              </td>

            </tr>
            @endforeach
            @else
            <td>No user found</td>
            @endif
          </tbody>
        </table>
        <div class="pagination pagination-centered">
          {{$users->links()}}
        </div>
      </div>
    </div>

  </div>

</div>
</div>





@endsection