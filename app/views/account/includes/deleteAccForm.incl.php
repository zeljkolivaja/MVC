
 <form action="<?= PROOT ?>account/delete/?>" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?')">
     <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
     <input type="hidden" name="id" value="<?= $_SESSION['userid'] ?>">
     <button type="submit" class="btn btn-danger">DELETE ACCOUNT</button>
 </form>