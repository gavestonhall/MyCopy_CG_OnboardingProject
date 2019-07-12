{{--
    JS for saving the contents of a form.

    Inputs:
    $form RenderableForm = the instance of a RenderableForm that is being edited
--}}

<script type="text/javascript">
  function getContentsAndFeedback(){
    var returnable = {};

    var form = {};
    var feedback = {};
    var fieldCounter = {{ $form->getFieldCounter() }};
    for (var i = 0; i < fieldCounter; i++) {
      var fname = 'field-' + i;
      var editor = CKEDITOR.instances[fname];

      if (editor !== undefined) {
        form[fname] = editor.getData();
        // console.log("Data for " + fname + ": " + form[fname]);
      } else {
        form[fname] = $('#' + fname).val();
        // console.log("Data for " + fname + ": " + form[fname]);
        if (form[fname] === undefined || form[fname] === 'null') form[fname] = '';
      }

      var fbname = 'feedback-' + i;
      if ($('#' + fbname).length > 0) {
        feedback[fbname] = $('#' + fbname).val();
      }
    }

    returnable['form_contents'] = form;
    returnable['feedback'] = feedback;

    return returnable;
  }

  function saveFormContents(){
    console.log("GETTING CONTENTS AND FEEDBACK");
    console.log(getContentsAndFeedback());

    var contents = getContentsAndFeedback();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: "POST",
      url: "/edit/{{ $form->filledFormID }}",
      data: JSON.stringify(contents),
      contentType: "application/json; charset=UTF-8",
      success: function(data){
        alert("Response: " + data);
      }
    });

    // Using Vanilla JavaScript
    // var xhr = new XMLHttpRequest();
    // xhr.open("POST", "/filledform/{{ $form->filledFormID }}", true);
    // xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    // xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    //
    // // send the collected data as JSON
    // xhr.send(JSON.stringify(contents));
    //
    // xhr.onloadend = function () {
    //   alert("Response: " + data);
    // };

  }
</script>
