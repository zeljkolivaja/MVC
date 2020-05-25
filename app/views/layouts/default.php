<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> <?=  $this->_siteTitle; ?></title>
    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=PROOT?>css/custom.css">
    <script src="<?=PROOT?>js/jQuery-2.2.2.4.min.js"></script>

    <?= $this->content('head') ?> 


  </head>
  <body>

  <?= $this->content('body'); ?> 
  </body>
</html>
