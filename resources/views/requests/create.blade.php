@extends('layouts.app')

@section('title', 'Deployment Requests | Create')

@section('content')
    <h1>Fill out the form to create a Deployment Request</h1>

    <form action="/requests" method="POST">
        @csrf
        @if ($errors->any())
            <div class="alert-danger">

            @foreach ($errors->all() as $error)
                <li class="nav-link">{{ $error }}</li>
            @endforeach

            </div>
        @endif
        
        <div class="has-error">
            <label class="mt-2" for="name">Name:</label>
            <input class="form-control mb-2 has-error" type="text" name="name" placeholder="Application Name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="description">Description:</label>
        </div>
        <textarea class="form-control mb-3" placeholder="Give details of deployment..." name="description" cols="80" rows="10" required>{{ old('description') }}</textarea>

        <div>
            <button class="btn btn-primary" type="submit">Add Request</button>
        </div>

    </form>
@endsection