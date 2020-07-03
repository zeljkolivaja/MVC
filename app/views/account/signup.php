 <?php $this->start('head'); ?>
 <meta content="test" />
 <?php $this->setSiteTitle("Registration"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>

 <div>
     <h2>Register</h2>
 </div>
 <br>

<?php include_once "includes/registerForm.incl.php" ?>

<?php message($message) ?>

 <?php $this->end(); ?>