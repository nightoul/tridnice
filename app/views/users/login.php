
<?php $title = 'Přihlášení školy' ?>
<?php require APPROOT . '/views/include/header.php'?>

<div class="container">
  <div class="row">

    <!-- TABS -->

    <div class="col l12">
      <ul class="tabs">
        <li class="tab col l6"><a href="#login-school" class="indigo-text">Login School</a></li>
        <li class="tab col l6"><a href="#login-tutor" class="indigo-text">Login Tutor</a></li>
      </ul>
    </div>

    <!-- LOGIN SCHOOL -->

    <div id="login-school" class="col l12">
      <h2>Login School</h2>
      <form action="<?= URLROOT; ?>/users/loginschool" method="POST">
        <div class="row">
          <div class="input-field col m12">
            <input type="text" id="school-email" name="school_email" autocomplete="off" value="<?= $data['school_email'] ?? '' ?>" >
            <label for="school-email">Login with your school's email</label>
            <div class="red-text"><?= $data['err_school_email'] ?? ''; ?></div>
          </div>
          <div class="input-field col m12">
            <input type="password" name="school_pwd" id="school-pwd">
            <label for="school-pwd">Password</label>
            <div class="red-text"><?= $data['err_school_pwd'] ?? ''; ?></div>
          </div>
          <button name="submit" class="btn btn-large right">Login</button>
        </div>
      </form>
    </div>

    <!-- LOGIN TUTOR -->

    <div id="login-tutor" class="col l12" >
      <h2>Login Tutor</h2>
      <form action="<?= URLROOT; ?>/users/logintutor" method="POST">
        <div class="row">
          <div class="input-field col m12">
            <input type="text" name="tutor_email" id="tutor-email" autocomplete="off" value="<?= $data['tutor_email'] ?? '' ?>" >
            <label for="tutor-email">Login with your email</label>
            <div class="red-text"><?= $data['err_tutor_email'] ?? ''; ?></div>
          </div>
          <div class="input-field col m12">
            <input type="password" name="tutor_pwd" id="tutor-pwd">
            <label for="tutor-pwd">Password</label>
            <div class="red-text"><?= $data['err_tutor_pwd'] ?? ''; ?></div>
          </div>
          <button name="submit" class="btn btn-large right">Login</button>
        </div>
      </form>
    </div> 

  </div>
</div>

<script>

// if redirected from tutor controller due to submit error, preselect to tutor tab
onload = () => {

  // access PHP $data['redirected']
  var redirected = "<?php echo $data['redirected_from_tutor'] ?>";

  // if not redirected, preselect first tab link
  if(!redirected) {
    var first = document.querySelector('.tabs a').classList.add('active');
  
  // else preselect second tab link
  } else {
    var second = document.querySelectorAll('.tabs a')[1].classList.add('active');
  }
}
</script>

<?php require APPROOT . '/views/include/footer.php'?>
