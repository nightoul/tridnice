
<?php $title = 'Docházka' ?>
<?php require APPROOT . '/views/include/header.php'?>

  <div style="position:relative" class="container">
    <h2><?= $_SESSION['school_name'] ?></h2>
    <form action="<?= URLROOT; ?>/records/show/<?= $data['course_id']?>" method="POST">

      <!-- FORM ONE -->
    
      <div style="position:absolute;top:0;right:0">
        <a href="<?= URLROOT ?>/courses" class="btn-large waves-effect waves-light" >Back</a>
        <button type="submit" class="btn-large waves-effect waves-light" name="submit" >Submit changes</button>
      </div>
      <div class="row">
        <div class="input-field col m8">
          <input id="course-name" type="text" name="course_name" value="<?= $data['course_name'] ?? '' ?>" disabled />
          <label for="course-name">Course name</label>
        </div>
        <div class="input-field col m4">
          <input id="month" type="text" value="<?= $data['month'] ?>" disabled />
          <label for="month">Month</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col m4">
          <input id="day" type="text" value="<?= $data['course_day'] ?>" disabled />
          <label for="day">Day</label>  
        </div>
        <div class="input-field col m4">
          <input id="course-start" type="text" value="<?= $data['starts_at'] ?? '' ?>" disabled />
          <label for="course-start">Course starts at:</label>
        </div>
        <div class="input-field col m4">
          <input id="course-end" type="text" value="<?= $data['ends_at'] ?? '' ?>" disabled />
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
                <input type='text' value='".$student_names[$i]."' autocomplete='off' disabled />
                <label>Name</label>
              </div>
            </td>";
            for($a=0;$a<count($dates); $a++) {
              echo "
              <td>
                <p>
                  <label>
                    <input type='hidden' name='checklist[]' value='0'>
                    <input type='checkbox' name='checklist[]' value='1' class='checkbox student".$i." week".$a."' />
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
            <input id='topic-week".$i."' type='text' name='tutor_records[]'
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

// on submit: send month as a second parameter to records/updaterecord
onload = function () {
  var selectedMonth = document.querySelector("#month").value;

  switch (selectedMonth) {
    case "September":
      selectedMonth = 0;
      break;
    case "October":
      selectedMonth = 1;
      break;
    case "November":
      selectedMonth = 2;
      break;
    case "December":
      selectedMonth = 3;
      break;
    case "January":
      selectedMonth = 4;
      break;
    case "February":
      selectedMonth = 5;
      break;
    case "March":
      selectedMonth = 6;
      break;
    case "April":
      selectedMonth = 7;
      break;
    case "May":
      selectedMonth = 8;
      break;
    case "June":
      selectedMonth = 9;
      break;
  }
  var formAction = (document.forms[0].action += "/" + selectedMonth);
};

// access php attendance array to update checkboxes with JS
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

// disable checkboxes if archived month is selected: get current month
var currentMonth = new Date().getMonth();

switch (currentMonth) {
  case 8:
    currentMonth = 0; // September: 8 -> 0
    break;
  case 9:
    currentMonth = 1; // October: 9 -> 1
    break;
  case 10:
    currentMonth = 2; // November: 10 -> 2
    break;
  case 11:
    currentMonth = 3; // December: 11 -> 3
    break;
  case 0:
    currentMonth = 4; // January: 0 -> 4
    break;
  case 1:
    currentMonth = 5; // February: 1 -> 5
    break;
  case 2:
    currentMonth = 6; // March: 2 -> 6
    break;
  case 3:
    currentMonth = 7; // April: 3 -> 7
    break;
  case 4:
    currentMonth = 8; // May: 4 -> 8
    break;
  case 5:
    currentMonth = 9; // June: 5 -> 9
    break;
  case 6:
    currentMonth = null; // July
    break;
  case 7:
    currentMonth = null; // August
    break;
}

// disable checkboxes if archived month is selected: get selected month
var selectedMonth = "<?= $data['month_numeric']; ?>";

// disable checkboxes
var checkboxes = document.querySelectorAll(".checkbox");
if (selectedMonth < currentMonth) {
  checkboxes.forEach(function (checkbox) {
    checkbox.disabled = true;
  });
}

// on form change: if checkbox is checked, disable its hidden input previous element sibling
document.forms[0].addEventListener("change", function () {
  var checks = document.querySelectorAll("input[type=checkbox]");
  for (i = 0; i < checks.length; i++) {
    if (checks[i].checked == true) {
      checks[i].previousElementSibling.disabled = true;
    } else if (checks[i].checked == false) {
      checks[i].previousElementSibling.disabled = false;
    }
  }
});

</script>

<?php require APPROOT . '/views/include/footer.php'?>
