
<?php $title = 'Změna hesla' ?>
<?php require APPROOT . '/views/include/header.php'?>

<div class="container" style="margin-top:4em" >
  <h2>Change Password</h2>
  <form action="<?= URLROOT; ?>/users/changeschoolpass" method="POST">
    <div class="row">
      <div class="input-field col m12">
        <input type="password" name="school_pwd" id="school-pwd" autocomplete="off" >
        <label for="school-pwd">New password</label>
        <div class="red-text"><?= $data['err_school_pwd']; ?></div>
      </div>
      <div class="input-field col m12">
        <input type="password" name="confirm_school_pwd" id="confirm-school-pwd">
        <label for="confirm-school-pwd">Confirm password</label>
        <div class="red-text"><?= $data['err_confirm_school_pwd']; ?></div>
      </div>
      <a href="<?= URLROOT; ?>/directors" class="btn-large waves-effect waves-light" >Back</a>
      <button name="submit" class="btn btn-large">Change password</button>
    </div>
  </form>
</div>

<?php require APPROOT . '/views/include/footer.php'?>