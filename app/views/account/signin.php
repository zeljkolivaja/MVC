 <?php $this->start('head'); ?>
 <meta content="test" />
 <?php $this->setSiteTitle("Login"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body');?>

 <div>
     <h2>Login</h2>
 </div>
 <br>
 <form action="<?= PROOT ?>account/login" method="POST">

     <div class="form-group">
         <label for="username">Username</label>
         <input type="text" required class="form-control" name="username"  id="username">
     </div>



     <div class="form-group">
         <label for="password">Password</label>
         <input type="password" required class="form-control" name="password" id="exampleInputPassword1">
     </div>



     <div class="form-group form-check">
         <input type="checkbox" class="form-check-input" name="rememberme" id="exampleCheck1">
         <label class="form-check-label" for="exampleCheck1">Check me out</label>
     </div>

     <button type="submit" class="btn btn-primary">Submit</button>

 </form>
<br/>

 <?php  if($message != ""): ?>
<div class="alert alert-danger" role="alert">
<?php echo $message; ?>
</div>
 <?php endif?>



 <?php $this->end();?>