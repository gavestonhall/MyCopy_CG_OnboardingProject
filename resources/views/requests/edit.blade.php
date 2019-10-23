@extends('layouts.app')

@section('content')
<h1>Edit Deployment Request | {{ $request->name }}</h1>

    @if ($errors->any())
        <div class="alert-danger">

        @foreach ($errors->all() as $error)
            <li class="nav-link">{{ $error }}</li>
        @endforeach

        </div>
    @endif

<form class="d-inline" action="/requests/{{ $request->id }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="has-error">
            <label class="mt-2" for="name">Name:</label>
            <input class="form-control mb-2" type="text" name="name" placeholder="Application Name" value="{{ $request->name }}" required>
        </div>

        <div>
            <label for="description">Description:</label>
        </div>

        <textarea class="form-control mb-3" placeholder="Give details of deployment..." name="description" cols="80" rows="10" required>{{ $request->description }}</textarea>
        
        <button class="btn btn-primary" type="submit">Update</button>
</form>

<form class="d-inline" action="/requests/{{ $request->id }}" method="POST">
    @method('DELETE')
    @csrf

    <button class="ml-2 btn btn-danger" type="submit">Delete</button>
</form>



@endsection