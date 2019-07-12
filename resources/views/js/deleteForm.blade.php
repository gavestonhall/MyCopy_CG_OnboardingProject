
{{--
    JS for deleting a form.

    Inputs:
    $form RenderableForm = the instance of a RenderableForm that is being edited
--}}

<script type="text/javascript">
  function deleteForm(form_id) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var data = { id: form_id};
    console.log(form_id);
    $.ajax({
      url: 'delete',
      type: 'POST',
      data: data,
      success: function(response)
      {
        console.log(response);
        if (response == "Success") {
          $('#tableWrapper').load(location.href + ' #table');
          return alert("Successfully deleted form with id:"+form_id);
        } else {
          return alert(response);
        }
      }
    });
  }
</script>
