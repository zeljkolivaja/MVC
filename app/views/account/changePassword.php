 <?php $this->start('head'); ?>
 <meta content="test" />
 <?php $this->setSiteTitle("Change password"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body');?>

 <div>
     <h2>Change your password</h2>
 </div>
 <br>
 <form action="<?= PROOT ?>account/updatePassword" method="POST">
 
     <div class="form-group">
         <label for="password">Old Password</label>
         <input type="password" required class="form-control" name="passwordOld" id="exampleInputPassword1">
     </div>

     <div class="form-group">
         <label for="passwordNew">New Password</label>
         <input type="password" required class="form-control" name="passwordNew" id="exampleInputPassword1">
     </div>
  
     <div class="form-group">
         <label for="passwordNew2">Enter New Password Again</label>
         <input type="password" required class="form-control" name="passwordNew2" id="exampleInputPassword1">
     </div>

     <button type="submit" class="btn btn-primary">Submit</button>

 </form>

 
 <?php  if($message != NULL): ?>
<div class="alert alert-danger" role="alert">
<?php echo $message; ?>
</div>
 <?php endif?>


 <?php $this->end();?>