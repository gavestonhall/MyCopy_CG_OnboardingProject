{{--
    Page for creating a FilledForm.

    Inputs:
    $forms Array = array of BaseForms that will be chosen from
--}}

@extends('layout.main')

@section('title')
  Creating New Form
@endsection

@section('content')
  <h1>Choose the Form Template to use</h1>
  <hr>
  {{-- Pass the fields to the template for rendering fields --}}
  <form>
  @include('forms::components.edit.fields', [
      'fields' => $fields
  ])
  </form>
  <hr>

  {{-- Creating the form --}}
  <a id="button" class="btn btn-primary mb-3">Create a request</a>
@endsection

@section('scripts')
  {{-- <script src="js/admin/home.js"></script> --}}
  <script type="text/javascript" src="https://cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
  @include('js/createNewForm')
@endsection
