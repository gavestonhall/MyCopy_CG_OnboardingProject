<form action="/download" method="POST">
  @csrf
  <input type="hidden" name="id" value={{ $form->filledFormID }}>
  <input type="hidden" name="type" value="Word">
  <button type="submit" class="btn btn-secondary mb-3">
      Download as a Word Document
  </button>
</form>
