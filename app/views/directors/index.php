
<?php $title = 'Kurzy' ?>
<?php require APPROOT . '/views/include/header.php'?>

<div class="container">
  <div class="row">
    <div class="col m6">
      <h4><?= $_SESSION['school_name'] ?></h4>
      <h6 class="left">Welcome! You can search through all of your courses according to the tutor name, course name or course day. 
      Click on the course for more info.</h6>
    </div>
    <div class="col m6" style="margin-top:3em">
      <div class="input-field col m4 offset-m3">
        <select id="archive" onchange="sendArchivedMonth(this.value)" >
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
        <label for="">Archive</label>
      </div>
      <div class="input-field col m4 right">
        <select id="school-year">
          <option value="2020/2021" selected >2020/2021</option>              
        </select>
        <label for="school-year">School year</label>
      </div>
    </div>  
  </div>

  <!-- ALL RECORDS -->

  <table id="table" class="striped responsive-table">
    <thead>
      <th>Tutor name:</th>
      <th>Course name:</th>
      <th>Course day:</th>
      <th>Starts at:</th>
      <th>Ends at:</th>
    </thead>
    <tbody>
      <?php
      $rows = $data['tutors_and_courses'];

      foreach($rows as $row): ?>
        <tr>
          <td><?= $row['tutor_name']?></td>
          <td><a href="<?= URLROOT . '/records/showrecord/'.$row['course_id'] ?>" class="course"><?= $row['course_name']?></a></td>
          <td><?= $row['course_day']?></td>
          <td><?= $row['starts_at']?></td>
          <td><?= $row['ends_at']?></td>  
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- PAGINATION -->

  <?php
  $page = $data['page'];
  $limit = $data['limit'];
  $previous = $page - 1;
  $next = $page + 1;
  $num_of_pages = $data['num_of_pages']; 
  ?>

  <ul class="pagination">
    <li class="waves-effect <?=($page == 1) ? 'disabled' : '' ?>">
      <a <?= ($page > 1) ? "href=?page=$previous"."&limit=$limit" : ""?>>
      <i class="material-icons">chevron_left</i></a>
    </li>

    <?php for($i=1; $i<=$num_of_pages;$i++): ?>
    <li class="waves-effect <?= ($page == $i) ? "active" : "" ?>">
      <a href="?page=<?=$i?>&limit=<?=$limit?>"><?=$i?></a>
    </li>
    <?php endfor; ?>

    <li class="waves-effect <?=($page == $num_of_pages) ? 'disabled' : '' ?>">
      <a <?= ($page < $num_of_pages) ? "href=?page=$next"."&limit=$limit" : ""?>>
      <i class="material-icons">chevron_right</i></a>
    </li>
  </ul>
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
