
{{--
    JS for creating a new form.

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
  $("#1").keydown(function(event) {
        if (event.keyCode === 13) {
          createNewForm();
        }
    });
  $('#button').click(() => createNewForm()); // This prevents from firing onLoad

  function createNewForm() {
    var data = { id: $('#0').val(), owner: $('#1').val() };
    console.log(data);
      $.ajax({
          url: 'new',
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
