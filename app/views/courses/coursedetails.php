
<?php $title = 'Detail kurzu' ?>
<?php require APPROOT . '/views/include/header.php'?>

  <div style="position:relative;" class="container">
    <h2><?= $_SESSION['school_name'] ?></h2>
    <form action="<?= URLROOT; ?>/courses/edit/<?=$data['course_id']?>" method="POST">
      <div style="position:absolute; top:0;right:0;">
        <a href="<?= URLROOT; ?>/courses/options" class="btn-large waves-effect waves-light" >Back</a>
        <button type="submit" class="btn-large waves-effect waves-light" name="submit" >Submit changes</button>
      </div>
      <div class="row">
        <div class="input-field col m10">
          <h5>Edit course name:</h5>
          <input id="course-name" type="text" name="course_name" value="<?= $data['course_name'] ?>" />
          <div class="red-text"><?= $data['err_course_name'] ?? ''; ?></div>
        </div>
        <div class="input-field col m2 right">
          <h5>Delete course?</h5>
          <div class="switch">
            <label>
              <input type="checkbox" id="switchbox" name="delete" >
              <span class="lever"></span>
            </label>
          </div>
        </div>
        <div class="col m2 right red-text" id="switch-message"></div>
      </div>
      <div class="row">
        <div class="input-field col m4">
          <h5>Course starts at:</h5>
          <input id="course-start" type="text" class="timepicker" name="starts_at" value="<?= $data['starts_at'] ?>" />
          <div class="red-text"><?= $data['err_starts_at'] ?? ''; ?></div>
        </div>
        <div class="input-field col m6">
          <h5>Course ends at:</h5>
          <input id="course-end" type="text" class="timepicker" name="ends_at" value="<?= $data['ends_at'] ?>" />
          <div class="red-text"><?= $data['err_ends_at'] ?? ''; ?></div>
        </div>
      </div>
    </form>
  </div>

  <script>
    // add switchbox message
    var switchbox = document.querySelector('#switchbox');
    var message = document.querySelector('#switch-message');

    switchbox.addEventListener('click', function(){
      if(switchbox.checked == true) {
        message.innerHTML = "<?php echo Localization::localize_message('other', 'delete_course_help')?>";
      } else {
        message.innerHTML = '';
      }
    });
  </script>

<?php require APPROOT . '/views/include/footer.php'?>
