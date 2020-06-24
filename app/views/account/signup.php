 <?php $this->start('head'); ?>
 <meta content="test" />
 <?php $this->setSiteTitle("Registration"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>

 <div>
     <h2>Register</h2>
 </div>
 <br>
 <form action="<?= PROOT ?>account/register" method="POST">

     <div class="form-group">
         <label for="username">Username</label>
         <input type="text" required class="form-control" name="username" id="username">
     </div>

     <div class="form-group">
         <label for="email">Email address</label>
         <input type="email" required class="form-control" name="email" id="email" aria-describedby="emailHelp">
         <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
     </div>

     <div class="form-group">
         <label for="password">Password</label>
         <input type="password" required class="form-control" name="password" id="exampleInputPassword1">
     </div>

     <div class="form-group">
         <label for="password2">Enter password again</label>
         <input type="password" required class="form-control" name="password2" id="exampleInputPassword1">
     </div>


     <div class="form-group">
         <label for="city">City</label>
         <input type="text" required class="form-control" name="city" id="city">
     </div>


     <div class="form-group">
         <label for="street">Street</label>
         <input type="text" required class="form-control" name="street" id="street">
     </div>

     <button type="submit" class="btn btn-primary">Submit</button>

 </form>


 <?php if ($message != "") : ?>

     <div class="alert alert-danger" role="alert">
         <?php echo $message; ?>
     </div>
 <?php endif ?>


 <?php $this->end(); ?>