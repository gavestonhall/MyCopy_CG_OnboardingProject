<!-- Source: https://www.easylaravelbook.com/blog/integrating-a-bootstrap-modal-into-your-laravel-application/ -->

<div class="modal" id="duplicateModal"
     tabindex="-1" role="dialog"
     aria-labelledby="duplicateModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"
        id="duplicateModalLabel">Enter details for duplication</h4>
        <button type="button" class="close"
          data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>
        Enter the name of the owner of the duplicated deployment request
        of previous id <b><span id="duplicate-id">null</span></b>.
        </p>
        <form>
          <input type="text" class="form-control" id="ownerName" value="">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button"
           class="btn btn-default"
           data-dismiss="modal">Close</button>
        <span class="pull-right">
            <button class="btn btn-primary" id="button">Create duplicate</button>
        </span>
      </div>
    </div>
  </div>
</div>

<!-- TODO change values-->

<button
   type="button"
   class="btn btn-primary mb-3"
   data-id="{{ $form->filledFormID }}"
   data-toggle="modal"
   data-target="#duplicateModal">
  Duplicate form
</button>

<script type="text/javascript">
$(function() {
    $('#duplicateModal').on("show.bs.modal", function (e) {
         $("#duplicate-id").html($(e.relatedTarget).data('id'));
    });
});
</script>
