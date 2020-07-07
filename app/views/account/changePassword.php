 <?php $this->start('head'); ?>
 <?php $this->setSiteTitle("Change password"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body');?>

 <div>
     <h2>Change your password</h2>
 </div>
 <br>

<?php include_once "includes/updatePassForm.incl.php" ?>

<?php message($message) ?>

 <?php $this->end();?>