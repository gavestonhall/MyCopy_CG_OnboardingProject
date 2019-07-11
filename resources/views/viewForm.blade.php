@extends('forms::layouts.main')

@section('content')
  <h1>Viewing FilledForm with ID {{ $form->filledFormID }}</h1>
  <hr>
  {{-- Pass the fields to the template for rendering fields --}}
  <form class="#target">
  @include('forms::components.edit.fields', [
      'fields' => $form->fields
  ])
  </form>
  <hr>

  {{-- Editing the form --}}
  <button class="btn btn-primary mb-3" onclick="document.location.href='/forms/edit/1'">Make changes</button>

@endsection

@section('scripts')
    {{-- <script src="js/admin/home.js"></script> --}}
    <script type="text/javascript" src="https://cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            $('input[id ^= "field"]').prop('disabled', true);
            $('select[id ^= "field"]').prop('disabled', true);
            $('textarea[id ^= "field"]').prop('disabled', true);
            $('checkbox[id ^= "field"]').prop('disabled', true);
        });
    </script>
@endsection
