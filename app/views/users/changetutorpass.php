
<?php $title = 'Změna hesla' ?>
<?php require APPROOT . '/views/include/header.php'?>

<div class="container" style="margin-top:4em" >
  <h2>Change Password</h2>
  <form action="<?= URLROOT; ?>/users/changetutorpass" method="POST">
    <div class="row">
      <div class="input-field col m12">
        <input type="password" name="tutor_pwd" id="tutor-pwd" autocomplete="off" >
        <label for="tutor-pwd">New password</label>
        <div class="red-text"><?= $data['err_tutor_pwd']; ?></div>
      </div>
      <div class="input-field col m12">
        <input type="password" name="confirm_tutor_pwd" id="confirm-tutor-pwd">
        <label for="confirm-tutor-pwd">Confirm password</label>
        <div class="red-text"><?= $data['err_confirm_tutor_pwd']; ?></div>
      </div>
      <a href="<?= URLROOT; ?>/courses" class="btn-large waves-effect waves-light" >Back</a>
      <button name="submit" class="btn btn-large">Change password</button>
    </div>
  </form>
</div>

<?php require APPROOT . '/views/include/footer.php'?>