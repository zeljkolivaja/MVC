<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title> <?= $this->_siteTitle; ?></title>
  <link rel="stylesheet" href="<?= PROOT ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= PROOT ?>css/custom.css">
  <script src="<?= PROOT ?>js/jQuery-2.2.2.4.min.js"></script>


  <?= $this->content('head') ?>


</head>

<body>


  <?php $url = explode("/", $_SERVER['REQUEST_URI']); 
  $url = end($url); ?>

  <div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Gallery App</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link <?php echo $url == "" ? "active" : ""  ?> " href="<?= PROOT ?>">Home <span class="sr-only">(current)</span></a>

          <?php if (!SessionController::loggedIn()) : ?>

            <a class="nav-item nav-link <?php echo $url == "indexRegister" ? "active" : ""  ?>" href="<?= PROOT ?>account/indexRegister">Register</a>
            <a class="nav-item nav-link <?php echo $url == "indexLogin" ? "active" : ""  ?> " href="<?= PROOT ?>account/indexLogin">Log In</a>


          <?php endif; ?>

          <?php if (SessionController::loggedIn()) : ?>
            <a class="nav-item nav-link <?php echo $url == "image" ? "active" : ""  ?>" href="<?= PROOT ?>image">Menagement</a>
            <a class="nav-item nav-link <?php echo $url == "menage" ? "active" : ""  ?>" href="<?= PROOT ?>account/menage">My account</a>
            <a class="nav-item nav-link" href="<?= PROOT ?>account/logout">Logout</a>


          <?php endif; ?>

         </div>
      </div>
    </nav>
    <div class="container">

      <?= $this->content('body'); ?>

    </div>


  </div>
</body>

</html>