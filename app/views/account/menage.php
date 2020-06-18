 <?php $this->start('head'); ?>
 <?php $this->setSiteTitle("My account"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>

 <div>
     <h2>Menage your account</h2>
 </div>
 <br>
 
 
 <button onclick="location.href='<?= PROOT ?>account/indexChangePassword'" type="button" class="btn btn-primary">
 Change your password</button>

 <button onclick="location.href='<?= PROOT ?>account/indexChangePassword'" type="button" class="btn btn-danger">
 Delete your account TODO</button>

 <?php $this->end(); ?>