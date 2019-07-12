@extends('layout.main')

@section('title')
  Index
@endsection

@section('content')
  <h1>All filled Deployment Requests</h1>
  <hr>
  <div id="tableWrapper">
  <table id="table" class="table table-hover">
    <thead class="thead-light">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Owner</th>
        <th scope="col">Date</th>
        <th scope="col"></th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($forms as $form)
        <tr>
          <th scope="row">{{$form->id}}</th>
          <td>{{$names[$loop->index]}}</td>
          <td>{{$form->owner}}</td>
          <td>{{$dates[$loop->index]}}</td>
          <td><a class="btn btn-primary mb-3" href="/view/{{ $form->id }}">View</a></td>
          <td><a class="btn btn-primary mb-3" href="/edit/{{ $form->id }}">Edit</a></td>
          <td><button class="btn btn-primary mb-3" onclick="deleteForm({{ $form->id }})">Delete</button></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  </div>

  @include('js/deleteForm')
@endsection
