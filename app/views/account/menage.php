 <?php $this->start('head'); ?>
 <?php $this->setSiteTitle("My account"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>

 <div>
     <h2>Hello <?php e($_SESSION["username"]); ?>. <br /></h2>
     <hr>
     <h4>Menage your account</h4>
 </div>
 <br>


 <p> <a href="<?= PROOT ?>account/indexChangePassword" class="btn btn-primary">
         Change your password
     </a>
 </p>

 <?php include_once "includes/deleteAccForm.incl.php" ?>

 <?php $this->end(); ?>