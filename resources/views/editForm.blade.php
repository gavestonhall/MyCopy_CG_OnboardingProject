{{--
    Page for editting and saving a FilledForm.

    Inputs:
    $form RenderableForm = the instance of a RenderableForm that will be used to render the form
--}}

@extends('layout.main')

@section('title')
  Editing Form {{ $form->filledFormID }}
@endsection

@section('content')
    <h1>Editting FilledForm with ID {{ $form->filledFormID }}</h1>
    <hr>

    {{-- Pass the fields to the template for rendering fields --}}
    <form>
    @include('forms::components.edit.fields', [
        'fields' => $form->fields
    ])
    </form>
    <hr>

    {{-- Saving the form --}}
    <button class="btn btn-primary mb-3" onclick="saveFormContents()">Save changes</button>
    {{-- Viewing the form --}}
    <a class="btn btn-primary mb-3" href="/view/{{ $form->filledFormID }}">Discard changes and view</a>

    @include('js/saveFormContents', ['form' => $form])
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
@endsection
