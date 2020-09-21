
<?php $title = 'Možnosti' ?>
<?php require APPROOT . '/views/include/header.php'?>

<div style="position:relative;" class="container">
  <div class="row">
    <div class="col m7">
      <h4><?= $_SESSION['school_name'] ?></h4>
      <h6>
      Feel free to edit course details or delete a course. 
      </h6>
    </div>
    <div style="position:absolute;top:2em;right:0;">
      <a class="btn-large" href="<?= URLROOT; ?>/courses">Back</a>
      <button class="btn-large" type="submit" form="change-pass-form" name="submit">Submit changes</button>
    </div>
  </div>

  <!-- COLLECTIONS -->

  <h4 style="display:inline;">Your Courses</h4>
  <h5 style="display:inline;position:relative;left:16em;text-transform:uppercase;">Edit course details</h5>
  <ul class="collection">
  <?php  
  $output = '';
  for($i=0;$i<count($data['courses']); $i++) {
  $output .= "
  <li class='collection-item avatar'>
    <i class='material-icons circle'>school</i>
    <span class='title'>".$data['courses'][$i]['course_day']."</span>
    <p>".$data['courses'][$i]['course_name']."<br>"
        .$data['courses'][$i]['starts_at']." - ".$data['courses'][$i]['ends_at']."
    </p>
    <a href='" . URLROOT ."/courses/show/" . $data['courses'][$i]['course_id'] ."' class='secondary-content'><i class='material-icons'>edit</i></a>
  </li>";
  }
  echo $output;
  ?>
  </ul>
</div>

<?php require APPROOT . '/views/include/footer.php'?>
