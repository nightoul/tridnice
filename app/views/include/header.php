
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="<?= URLROOT; ?>/css/styles.css">
  <title><?= $title ?></title>
</head>
<body>

<!-- DESKTOP NAVIGATION -->

<nav class="nav-wrapper blue darken-4">
  <div class="container">
    <a href="<?= URLROOT; ?>" class="brand-logo"><?= SITENAME; ?></a>
    <ul id="nav-mobile" class="right hide-on-med-and-down">

    <?php if(isset($_SESSION['user_id'])) : ?>

      <li><a href="<?= URLROOT;?>/users/changepassword">Change password</a></li>
      <li><a href="<?= URLROOT;?>/users/logout">Logout</a></li>
    
    <?php else : ?>
    
      <li><a href="<?= URLROOT;?>/users/login">Login</a></li>
      <li><a href="<?= URLROOT; ?>/users/signup">Sign up</a></li>

    <?php endif; ?>

    </ul>
  </div>
</nav>

<!-- SELECT LANGUAGE MODAL -->

<div class="modal" id="select-language">
  <div class="modal-content">
      <h4>Please select your language</h4>
  </div>
</div>

