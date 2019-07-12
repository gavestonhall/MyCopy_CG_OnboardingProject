{{--
    Page for viewing a FilledForm.

    Inputs:
    $form RenderableForm = the instance of a RenderableForm that will be used to render the form
--}}

@extends('layout.main')

@section('title')
  Viewing Form {{ $form->filledFormID }}
@endsection

@section('content')
  <h1>Viewing FilledForm with ID {{ $form->filledFormID }}</h1>
  <hr>
  {{-- Pass the fields to the template for rendering fields --}}
  <form>
  @include('forms::components.edit.fields', [
      'fields' => $form->fields
  ])
  </form>
  <hr>

  {{-- Editing the form --}}
  <a class="btn btn-primary mb-3" href="/edit/{{ $form->filledFormID }}">Make changes</a>
  <a class="btn btn-primary mb-3" href="/duplicate/{{ $form->filledFormID }}">Duplicate form</a>
  <a class="btn btn-primary mb-3" href="/export/{{ $form->filledFormID }}">Export as document</a>

@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            // Disable all fields, while leaving the section tabs functional
            $('input[id ^= "field"]').prop('disabled', true);
            $('select[id ^= "field"]').prop('disabled', true);
            $('textarea[id ^= "field"]').prop('disabled', true);
            $('checkbox[id ^= "field"]').prop('disabled', true);
        });
    </script>
@endsection
