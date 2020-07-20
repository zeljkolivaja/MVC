<form action="<?= PROOT ?>image/insert" method="POST" enctype='multipart/form-data'>

<input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">


<div class="form-group">
  <label for="name">Image Name</label>
  <input type="text" required class="form-control" name="name" id="name">
</div>


<div class="form-group">
  <label for="image">Select Image</label>
  <input type="file" class="form-control-file" name="image">
</div>


<button type="submit" class="btn btn-primary">Submit</button>

</form>
