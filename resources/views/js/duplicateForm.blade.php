
{{--
    JS for duplicating an existing form.

    Inputs:
    $form RenderableForm = the instance of a RenderableForm that is being edited
--}}

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).ready(function() { // Disables enter form submit function
    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });
  });
  $("#ownerName").keydown(function(event) {
        if (event.keyCode === 13) {
          duplicateForm();
        }
    });
  $('#duplicate').click(() => duplicateForm()); // This prevents from firing onLoad

  function duplicateForm() {
    var data = { id: {{$form->filledFormID}}, owner: $('#ownerName').val() };
    console.log(data);
      $.ajax({
          url: '/duplicate',
          type: 'POST',
          data: data,
          success: function(response)
          {
            var sucRoute = "/edit/" + response.id;
            console.log(response);
            if (response.msg == "Success") {
              console.log(sucRoute);
              window.location = sucRoute;
            } else {
              return alert(response.msg);
            }
          }
      });
   }
</script>
