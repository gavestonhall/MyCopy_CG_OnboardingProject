<!-- Source: https://www.easylaravelbook.com/blog/integrating-a-bootstrap-modal-into-your-laravel-application/ -->

<div class="modal fade" id="deleteModal{{$form->id}}"
     tabindex="-1" role="dialog"
     aria-labelledby="deleteModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"
        id="deleteModalLabel">Confirm deletion</h4>
        <button type="button" class="close"
          data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>
        Please confirm you would like to delete the form
        "<b><span id="delete-title{{$form->id}}">No Name</span></b>" with id
        <b><span id="delete-id{{$form->id}}">null</span></b>.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button"
           class="btn btn-default"
           data-dismiss="modal">Close</button>
        <span class="pull-right">
            <button class="btn btn-primary" onclick="deleteForm({{ $form->id }})">Delete</button>
        </span>
      </div>
    </div>
  </div>
</div>

<button
   type="button"
   class="btn btn-primary mb-3"
   data-id="{{ $form->id }}"
   data-title="{{ ($names[$loop->index] == "" ? "No name" : $names[$loop->index]) }}"
   data-toggle="modal"
   data-target="#deleteModal{{$form->id}}">
  Delete
</button>

<script type="text/javascript">
$(function() {
    $('#deleteModal{{$form->id}}').on("show.bs.modal", function (e) {
         $("#delete-title{{$form->id}}").html($(e.relatedTarget).data('title'));
         $("#delete-id{{$form->id}}").html($(e.relatedTarget).data('id'));
    });
});
</script>
