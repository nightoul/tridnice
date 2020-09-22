
<?php $title = 'Kurzy' ?>
<?php require APPROOT . '/views/include/header.php'?>

<div class="container">
  <div class="row">
    <div class="col m6">
      <h4><?= $_SESSION['school_name'] ?></h4>
      <h6>
      Welcome! Now you can make your own records. Create a new course first and then build up your timetable.
      </h6>
      <div class="red-text"><?= $data['no_courses_yet'] ?? '' ?></div>
    </div>
    <div class="col m6" style="margin-top:2em" >
      <a href="<?= URLROOT; ?>/courses/create" class="btn-large col m6 offset-m2">Create new course</a>
      <a href="<?= URLROOT; ?>/courses/options" class="btn-large right">Options</a>
      <div style="position:relative; top:1em" >
        <div class="input-field col m4 offset-m3">
          <select id="archive" name="month" onchange = sendArchivedMonth(this.value);>
            <option value="0">September</option>        
            <option value="1">October</option>        
            <option value="2">November</option>        
            <option value="3">December</option>        
            <option value="4">January</option>
            <option value="5">February</option>
            <option value="6">March</option>
            <option value="7">April</option>
            <option value="8">May</option>        
            <option value="9">June</option>       
          </select>
          <label>Archive</label>
        </div>
        <div class="input-field col m4 right ">
          <select id="school-year">
            <option value="2020/2021" selected >2020/2021</option>              
          </select>
          <label for="school-year">School year</label>
        </div>
      </div>
    </div>
  </div>
  <table class="responsive-table" >
    <thead>
      <tr>
        <th>Day</th>
        <th>Your Courses</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $days_of_week = $data['days_of_week'];
      $school_week = "";
      $timetable = $data['timetable'];
      for($i=0;$i<count($timetable);$i++){
        $day_of_week = $days_of_week[$i];
        $day = "<tr><td>".$day_of_week."</td>";
        for($a=0;$a<count($timetable[$i]);$a++){
          $id = $timetable[$i][$a]['course_id'];
          $course_name = $timetable[$i][$a]['course_name'];
          $day .= "<td><a href='".URLROOT."/records/record/".$id."' class='course'>".$course_name."</a></td>";
        }
        $day .= "</tr>";
        $school_week .= $day;
      }
      echo $school_week;
      ?>
    </tbody>
  </table>    
</div>

<script>
/*
- this script preselects the select month element to current month
- it disables future months
- it remaps numeric values got from JS getMonth() function to 0-9 values: September (0) to June (9)
- it sends these values as a second parameter to records/updaterecord & records/showrecord
*/

// get select#archive
var archive = document.querySelector("#archive");

// get current month
var currentMonth = new Date().getMonth();

// adjust getMonth() value to school year values in select#archive
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

// preselect to current month
archive.selectedIndex = currentMonth;

// disable future months
var options = archive.getElementsByTagName("option");
for (var i = 0; i < options.length; i++) {
  options[i].value > currentMonth
    ? (options[i].disabled = true)
    : (options[i].disabled = false);
}

// send month as a second parameter to records/updaterecord and records/showrecord
var selectedMonth = document.querySelector("#archive").value;
var links = document.querySelectorAll(".course");

// this sends value of current month
onload = function sendPreselectedMonth() {
  links.forEach(function (link) {
    link.href += "/" + selectedMonth;
  });
};

// this sends value of archived month and runs onchange() of select#archive
function sendArchivedMonth(archivedMonth) {
  links.forEach(function (link) {
    link.href = link.href.substring(0, link.href.lastIndexOf("/"));
    link.href += "/" + archivedMonth;
  });
}
</script>

<?php require APPROOT . '/views/include/footer.php'?>
