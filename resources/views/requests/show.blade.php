@extends('layouts.app')

@section('title', "$request->name")

@section('content')

<h2>Name:</h2>
<p>{{ $request->name }}</p>

<h2>Description:</h2>
<p>{{ $request->description }}</p>

<form class="d-inline" action="/requests/{{ $request->id }}/edit" method="GET">
    <button type="submit" class="btn btn-primary">Edit</button>
</form>

<form class="d-inline" action="/requests/{{ $request->id }}/edit" method="POST">
    @csrf

    <button class="ml-2 btn btn-success" type="submit">Duplicate</button>
</form>


<form class="d-inline" action="/requests/{{ $request->id }}" method="POST">
    @method('DELETE')
    @csrf

    <button class="ml-2 btn btn-danger" type="submit">Delete</button>
</form>

<form action="/requests/{{ $request->id }}" method="POST">
    @csrf

    <button class="mt-2 btn btn-warning" type="submit">Download as a Word Document</button>
</form>

@endsection