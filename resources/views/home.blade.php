@extends('layout.main')

@section('title')
  Home
@endsection

@section('content')
  <h1>Welcome to the Deployment Request Form Handler</h1>
  <p>Use the navbar to navigate throughout the website</p>
  <hr>
  <p>Currently implemented features:</p>
  <ul>
    <li>Creating a filled form with dedicated view to select base form.</li>
    <li>Viewing and editing a filled form.</li>
    <li>Index page to reference all filled forms.</li>
  </ul>
  <br\>
  <p>Features yet to be implemented:</p>
  <ul>
    <li>Add duplicate and export functions in view.</li>
    <li>Duplicating filled forms with view to change owner (login system to override?).</li>
    <li>Downloading filled forms as word document.</li>
  </ul>
  <hr>
@endsection
