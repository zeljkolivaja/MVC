 <?php $this->start('head'); ?>
 <meta content="test" />
 <?php $this->setSiteTitle("page title"); ?>
 <?php $this->end(); ?>

 <?php $this->start('body'); ?>


 <p><span id="serverResponse"></span></p>
 <p> Click the button to see how many images there is currently in the database </p>

 <button type="button" class="btn btn-primary" onclick="setTimeout(ajaxcall, 1000)">Click me</button>

<?php include_once "includes/ajaxCallINCL.php" ?>

<?php $this->end(); ?>