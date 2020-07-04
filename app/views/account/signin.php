 <?php $this->start('head'); ?>
 <meta content="test" />
 <?php $this->setSiteTitle("Login"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body');?>

 <div>
     <h2>Login</h2>
 </div>
 <br>

<?php include_once "includes/loginForm.incl.php" ?>

<br/>

<?php message($message) ?>

 <?php $this->end();?>