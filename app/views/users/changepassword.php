
<?php $title = 'Změna hesla' ?>
<?php require APPROOT . '/views/include/header.php'?>

<div class="container" style="margin-top:4em" >
  <h2>Change Password</h2>
  <form action="<?= URLROOT; ?>/users/changepassword" method="POST">
    <div class="row">
      <div class="input-field col m12">
        <input type="password" name="password" id="password" autocomplete="off" >
        <label for="password">New password</label>
        <div class="red-text"><?= $data['err_password']; ?></div>
      </div>
      <div class="input-field col m12">
        <input type="password" name="confirm_password" id="confirm-password">
        <label for="confirm-password">Confirm password</label>
        <div class="red-text"><?= $data['err_confirm_password']; ?></div>
      </div>

      <?php if($_SESSION['user_type'] == 'school'): ?>
      <a href="<?= URLROOT; ?>/directors" class="btn-large waves-effect waves-light" >Back</a>

      <?php elseif($_SESSION['user_type'] == 'tutor'): ?>
      <a href="<?= URLROOT; ?>/courses" class="btn-large waves-effect waves-light" >Back</a>
      <?php endif; ?>
      
      <button name="submit" class="btn btn-large">Change password</button>
    </div>
  </form>
</div>

<?php require APPROOT . '/views/include/footer.php'?>