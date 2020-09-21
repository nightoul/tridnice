
<?php $title = 'Registrace' ?>
<?php require APPROOT . '/views/include/header.php'?>

<div class="container">
  <div class="row">

    <!-- TABS -->

    <div class="col l12">
      <ul class="tabs">
        <li class="tab col l6"><a href="#signup-school" class="indigo-text">Signup School</a></li>
        <li class="tab col l6"><a href="#signup-tutor" class="indigo-text">Signup Tutor</a></li>
      </ul>
    </div>

    <!-- SIGNUP SCHOOL -->

    <div id="signup-school" class="col l12">
      <h2>Signup School</h2>
      <form action="<?= URLROOT; ?>/users/signupschool" method="POST">  
        <div class="row">
          <div class="input-field col m12">
            <label for="school-name">School name</label>
            <input type="text" id="school-name" name="school_name" autocomplete="off" value="<?= $data['school_name'] ?? '' ?>">
            <div class="red-text"><?= $data['err_school_name'] ?? ''; ?></div>
          </div>
          <div class="input-field col m12">
            <label for="school-email">School email</label>
            <input type="text" id="school-email" name="school_email" autocomplete="off" value="<?= $data['school_email'] ?? '' ?>">
            <div class="red-text"><?= $data['err_school_email'] ?? ''; ?></div>
          </div>
          <div class="input-field col m6">
            <label for="school-pwd">Password</label>
            <input type="password" id="school-pwd" name="school_pwd" >
            <div class="red-text"><?= $data['err_school_pwd'] ?? ''; ?></div>
          </div>
          <div class="input-field col m6">
            <label for="confirm-school-pwd">Confirm password</label>
            <input type="password" id="confirm-school-pwd" name="confirm_school_pwd" >
            <div class="red-text"><?= $data['err_confirm_school_pwd'] ?? ''; ?></div>
          </div>
          <button name="submit" class="btn btn-large right">Sign up</button>
        </div>
      </form>
    </div>

    <!-- SIGNUP TUTOR -->

    <div id="signup-tutor" class="col l12">
      <h2>Signup Tutor</h2>
      <form action="<?= URLROOT; ?>/users/signuptutor" method="POST">
        <div class="row">
          <div class="input-field col m6">
            <label for="tutor-first_name">First name</label>
            <input type="text" id="tutor-first_name" name="tutor_first_name" autocomplete="off" value="<?= $data['tutor_first_name'] ?? ''; ?>" >
            <div class="red-text"><?= $data['err_tutor_first_name'] ?? ''; ?></div>
          </div>
          <div class="input-field col m6">
            <label for="tutor-last_name">Last name</label>
            <input type="text" id="tutor-last_name" name="tutor_last_name" autocomplete="off" value="<?= $data['tutor_last_name'] ?? ''; ?>" >
            <div class="red-text"><?= $data['err_tutor_last_name'] ?? ''; ?></div>
          </div>
          <div class="input-field col m6">
            <label for="tutor-email">Email</label>
            <input type="text" id="tutor-email" name="tutor_email" autocomplete="off" value="<?= $data['tutor_email'] ?? ''; ?>" >
            <div class="red-text"><?= $data['err_tutor_email'] ?? ''; ?></div>
          </div>
          <div class="input-field col m6">
            <label for="school-token">School token</label>
            <input type="text" id="school-token" name="school_token" autocomplete="off" value="<?= $data['school_token'] ?? ''; ?>" >
            <div class="red-text"><?= $data['err_school_token'] ?? ''; ?></div>
          </div>
          <div class="input-field col m6">
            <label for="tutor-pwd">Password</label>
            <input type="password" id="tutor-pwd" name="tutor_pwd" >
            <div class="red-text"><?= $data['err_tutor_pwd'] ?? ''; ?></div>
          </div>
          <div class="input-field col m6">
            <label for="confirm-tutor-pwd">Confirm password</label>
            <input type="password" id="confirm-tutor-pwd" name="confirm_tutor_pwd" >
            <div class="red-text"><?= $data['err_confirm_tutor_pwd'] ?? ''; ?></div>
          </div>
          <button name="submit" class="btn btn-large right">Sign up</button>
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