<!DOCTYPE html>
<html lang="en">

<head>
<?php include_once "includes/head.incl.php" ?>
<?= $this->content('head') ?>
</head>

<body>

  <div class="container">
    <?php include_once "includes/navigation.incl.php" ?>
    <div class="container">
      <?= $this->content('body'); ?>
    </div>
  </div>


</body>
</html>