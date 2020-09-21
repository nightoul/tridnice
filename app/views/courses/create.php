
<?php $title = 'Nový kurz' ?>
<?php require APPROOT . '/views/include/header.php'?>

  <div class="container" style="position:relative" >
    <h2><?= $_SESSION['school_name'] ?></h2>
    <h4>Add a new course</h4>
    <form action="<?= URLROOT; ?>/courses/create" method="POST">
      <div style="position:absolute;top:0;right:0">
        <a href="<?= URLROOT; ?>/courses" class="btn-large waves-effect waves-light" >Back</a>
        <button type="submit" class="btn-large waves-effect waves-light" name="submit" >Create new course</button>
      </div>
      <div class="row">
        <div class="input-field col m6">
          <input id="course-name" type="text" name="course_name" value="<?= $data['course_name'] ?? '' ?>" />
          <label for="course-name">Course name (ie name of coursebook)</label>
          <div class="red-text"><?= $data['err_course_name']; ?></div>
        </div>
        <div class="input-field col m3">
          <select name="course_day">
            <option <?= ($data['course_day'] == '') ? 'selected' : '' ?> value="" >Select course day</option>
            <option <?= ($data['course_day'] == 'Monday') ? 'selected' : '' ?> value="Monday">Monday</option>
            <option <?= ($data['course_day'] == 'Tuesday') ? 'selected' : '' ?> value="Tuesday">Tuesday</option>
            <option <?= ($data['course_day'] == 'Wednesday') ? 'selected' : '' ?> value="Wednesday">Wednesday</option>
            <option <?= ($data['course_day'] == 'Thursday') ? 'selected' : '' ?> value="Thursday">Thursday</option>
            <option <?= ($data['course_day'] == 'Friday') ? 'selected' : '' ?> value="Friday">Friday</option>        
          </select>
          <label>Day</label>
          <div class="red-text"><?= $data['err_course_day']; ?></div>
        </div>
        <div class="input-field col m3">
          <select name="school_year">
            <option value="2020/2021" selected>2020/2021</option>
          </select>
          <label>School year</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col m6">
          <input id="no-of-students" type="number" min="1" max="8" name="num_of_students" onkeyup="showStudents(this.value)" onchange="showStudents(this.value)" />
          <label for="no-of-students">How many students are in the course (max 8)?</label>
          <div class="red-text"><?= $data['err_num_of_students']; ?></div>
          <div class="red-text"><?= $data['err_student_names']; ?></div>
        </div>
        <div class="input-field col m3">
          <input id="course-start" type="text" class="timepicker" name="starts_at" value="<?= $data['starts_at'] ?? ''?>" />
          <label for="course-start">Course starts at:</label>
          <div class="red-text"><?= $data['err_starts_at']; ?></div>
        </div>
        <div class="input-field col m3">
          <input id="course-end" type="text" class="timepicker" name="ends_at" value="<?= $data['ends_at'] ?? '' ?>" />
          <label for="course-end">Course ends at:</label>
          <div class="red-text"><?= $data['err_ends_at']; ?></div>
        </div>          
      </div>
      <table class="striped responsive-table">
        <tbody id="students"></tbody>
      </table>
    </form>
  </div>

  <script>
  
    function showStudents(studentsCount) {
      var table = document.querySelector("#students");    
      var output = '';
      for (i=0; i<studentsCount; i++) {
      var trow = `
      <tr>
        <td>
          <div class="input-field">
            <input type="text" id="student${i}-first_name" name="student${i}_first_name" autocomplete="off" />
            <label for="student${i}-first_name">Jméno</label>
          </div>
        </td>
        <td>
          <div class="input-field">
            <input type="text" id="student${i}-last_name" name="student${i}_last_name" autocomplete="off" />
            <label for="student${i}-last_name">Příjmení</label>
          </div>
        </td>
      </tr>`;
      output += trow;
    }
    table.innerHTML = output;
    }

  </script>

<?php require APPROOT . '/views/include/footer.php'?>
