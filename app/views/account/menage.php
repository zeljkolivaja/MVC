 <?php $this->start('head'); ?>
 <?php $this->setSiteTitle("My account"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>

 <div>
     <h2>Hello <?= $_SESSION["username"]; ?>. <br /> Menage your account</h2>
 </div>
 <br>


 <p> <a href="<?= PROOT ?>account/indexChangePassword" class="btn btn-primary">
         Change your password
     </a>
 </p>

 <form action="<?= PROOT ?>account/delete/?>" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?')">
     <input type="hidden" name="id" value="<?= $_SESSION['userid'] ?>">
     <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
     <button type="submit" class="btn btn-danger">DELETE ACCOUNT</button>
 </form>



 <?php $this->end(); ?>