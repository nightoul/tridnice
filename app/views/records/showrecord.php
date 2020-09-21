
<?php $title = 'Docházka' ?>
<?php require APPROOT . '/views/include/header.php'?>

  <div style="position:relative" class="container">
    <h2><?= $_SESSION['school_name'] ?></h2>
    <form>

      <!-- FORM ONE -->
    
      <div style="position:absolute;top:0;right:0">
        <a href="<?= URLROOT ?>/directors" class="btn-large waves-effect waves-light" >Back</a>
      </div>
      <div class="row">
        <div class="input-field col m8">
          <input style="color:black" id="course-name" type="text" name="course_name" value="<?= $data['course_name'] ?? '' ?>" disabled />
          <label for="course-name">Course name</label>
        </div>
        <div class="input-field col m4">
          <input style="color:black" id="month" type="text" value="<?= $data['month'] ?>" disabled />
          <label for="month">Month</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col m4">
          <input style="color:black" id="day" type="text" value="<?= $data['course_day'] ?>" disabled />
          <label for="day">Day</label>  
        </div>
        <div class="input-field col m4">
          <input style="color:black" id="course-start" type="text" value="<?= $data['starts_at'] ?? '' ?>" disabled />
          <label for="course-start">Course starts at:</label>
        </div>
        <div class="input-field col m4">
          <input style="color:black" id="course-end" type="text" value="<?= $data['ends_at'] ?? '' ?>" disabled />
          <label for="course-end">Course ends at:</label>
        </div>
      </div>

      <!-- FORM TWO -->

      <div style="display:flex">
        <h5>Students</h5>
        <h5 style="position:relative;left:9em" >Attendance</h5>
      </div>
      <table class="striped responsive-table">
        <thead>
        <tr>
        <th></th>
        <?php 
        $dates = $data['dates_d. m.'];
        $student_names = $data['student_names'];
        for ($i=0;$i<count($dates);$i++) {
          echo "<th>$dates[$i]</th>";
        }            
          ?>
          </tr>
        </thead>
        <tbody>
        <?php

        $weeks = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];

        for($i=0;$i<count($student_names);$i++) {
          echo "
          <tr>
            <td>
              <div class='input-field'>
                <input type='text' value='".$student_names[$i]."' disabled />
                <label>Name</label>
              </div>
            </td>";
            for($a=0;$a<count($dates); $a++) {
              echo "
              <td>
                <p>
                  <label>
                    <input type='hidden' value='0'>
                    <input type='checkbox' value='1' disabled class='checkbox student".$i." week".$a."' />
                    <span>".$weeks[$a]."</span>
                  </label>
                </p>
              </td>
              ";
            }
        }
        ?>
        </tbody>
      </table>

      <!-- FORM THREE -->

      <h5>Tutor record</h5>
      <?php  

      $output="";
      if(isset($data['tutor_records'])) {
        $records = $data['tutor_records'];
      }

      for($i=0; $i<count($dates); $i++) {

        $output .= "
        <div class='row'>
          <div class='input-field col s3'>
            <input type='text' disabled value='";
            $output .= $dates[$i];
            $output .= "'/>
          <label>Date</label>
        </div>
          <div class='input-field col s9'>
            <input id='topic-week".$i."' type='text' disabled
              value='";
        if(isset($records[$i])) {
          $output .= $records[$i];
        }
        $output .= "'/>
            <label for='topic-week".$i."'>Subject matter</label>
          </div>
        </div>";
      }
      echo $output;
      ?>
    </form>
  </div>

<script>

// access php attendance array
var attendance = JSON.parse('<?php echo json_encode($data['attendance']) ?>');

// update checkboxes
for (var i = 0; i < attendance.length; i++) {
  for (var a = 0; a < attendance[i].length; a++) {
    if (attendance[i][a] == 1) {
      var check = document.querySelector(`.student${i}.week${a}`);
      if (check.checked == false) {
        check.checked = true;
        check.previousElementSibling.disabled = true;
      }
    } else if (attendance[i][a] == 0) {
      var check = document.querySelector(`.student${i}.week${a}`);
      if (check.checked == true) {
        check.checked = false;
      }
    }
  }
}

</script>

<?php require APPROOT . '/views/include/footer.php'?>
