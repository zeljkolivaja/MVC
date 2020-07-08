 <?php $this->start('head'); ?>
 <?php $this->setSiteTitle("Upload image"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>

 <div class="text-center">
   <h2>IMAGE UPLOAD</h2>
 </div>

 <?php include_once "includes/uploadImageForm.incl.php" ?> 

<?php message($message) ?>

 <hr>

 <br />
 <div class="text-center">
   <h2>IMAGE GALLLERY</h2>
 </div>


 <?php include_once "includes/imageTable.incl.php" ?> 

 <?php $this->end(); ?>