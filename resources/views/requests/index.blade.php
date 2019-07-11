@extends('layouts.app')

@section('title', "Deployment Request | View")

@section('content')
  <h1>List of all Deployment Requests</h1>
  <p>Click on the name of each request in order to view more information and functionality.</p>

  <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col" class="flex-col">Description</th>
        </tr>
      </thead>
      <tbody>
        @foreach($requests as $request)
          <tr>
            <th scope="row">{{ $request->id }}</th>
          <td><a href="/requests/{{ $request->id }}">{{ $request->name }}</a></td>
            <td>{{ $request->description}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  
@endsection