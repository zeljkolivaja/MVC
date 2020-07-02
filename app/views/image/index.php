 <?php $this->start('head'); ?>
 <?php $this->setSiteTitle("Upload image"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>

 <div class="text-center">
   <h1>IMAGE UPLOAD</h1>
 </div>

 <?php include_once "includes/uploadImageForm.incl.php" ?> 

<?php message($message) ?>

 <hr>

 <br />
 <div class="text-center">
   <h1>IMAGE GALLLERY</h1>
 </div>


 <?php include_once "includes/imageTable.incl.php" ?> 

 <?php $this->end(); ?>