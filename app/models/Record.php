<?php

class Record extends Model {

  public function get_student_ids($course_id){

    $this->conn->query("SELECT student_id FROM students WHERE course_id = '$course_id'
      ORDER BY student_id ASC");
      
    $this->conn->execute();
    $rows = $this->conn->fetch_all();

    foreach($rows as $row) {
      $student_ids[] = $row['student_id'];
    }
    return $student_ids;
  }

  public function get_student_names($student_ids) {
    
    foreach ($student_ids as $student_id) {
      $this->conn->query("SELECT CONCAT (student_first_name, ' ', student_last_name) AS student_name
        FROM students WHERE student_id = '$student_id'");
      $this->conn->execute();
      $student_names[] = $this->conn->fetch_one();
    }

    return $student_names;
  }

  public function get_attendance($data){

    $course_id = $data['course_id'];
    $student_ids = $data['student_ids'];
    $month = $data['month'];
    $school_year = $data['school_year'];

    foreach ($student_ids as $student_id) {
      $this->conn->query("SELECT presence FROM attendance WHERE course_id='$course_id'
        && monthname(date)='$month' && student_id ='$student_id' && school_year = '$school_year'");
      $this->conn->execute();
      $attendance[] = $this->conn->fetch_all();
    }
    return $attendance;
  }

  public function save_attendance($data){

    $school_id = $data['school_id'];
    $course_id = $data['course_id'];
    $student_ids = $data['student_ids'];
    $dates = $data['dates_Y-m-d'];
    $checklist_rows = $data['checklist_rows'];
    $school_year = $data['school_year'];

    for($i = 0; $i<count($checklist_rows); $i++) {  // for each student (row) in grid
      for($a=0; $a<count($checklist_rows[$i]); $a++) { // for each week (column) in grid
        $presence = $checklist_rows[$i][$a];
        $student_id = $student_ids[$i];
        $date = $dates[$a];
        $this->conn->query("INSERT INTO attendance (school_id, course_id, student_id,
          date, presence, school_year) VALUES ('$school_id', '$course_id', '$student_id',
          '$date', '$presence', '$school_year')");
        $this->conn->execute();
      }
    }
  }

  public function count_rows_attendance($data) {

    $school_id = $data['school_id'];
    $course_id = $data['course_id'];
    $month = $data['month'];
    $school_year = $data['school_year'];

    $this->conn->query("SELECT attendance_id FROM attendance
      WHERE school_id = '$school_id' && course_id = '$course_id'
      && monthname(date) = '$month' && school_year = '$school_year'");
    $this->conn->execute();
    
    // check for empty rowcount
    if($this->conn->count_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function update_attendance($data){

    $school_id = $data['school_id'];
    $course_id = $data['course_id'];
    $student_ids = $data['student_ids'];
    $dates = $data['dates_Y-m-d'];
    $checklist_rows = $data['checklist_rows'];
    $school_year = $data['school_year'];

    for ($i=0;$i<count($checklist_rows);$i++) {     // for each student (row) in grid
      for($a=0;$a<count($checklist_rows[$i]);$a++) {    // for each week (column) in grid
        $presence = $checklist_rows[$i][$a];
        $student_id = $student_ids[$i];
        $date = $dates[$a];       
        $this->conn->query("UPDATE attendance SET presence='$presence' 
          WHERE school_id = '$school_id' && course_id = '$course_id' && student_id = '$student_id'
          && date='$date' && school_year = '$school_year'");
        $this->conn->execute();
      }
    }
  }

  public function get_tutor_records($data) {

    $school_id = $data['school_id'];
    $course_id = $data['course_id'];
    $month = $data['month'];
    $school_year = $data['school_year'];

    $this->conn->query("SELECT tutor_record FROM tutor_records
      WHERE school_id = '$school_id' && course_id='$course_id'
      && monthname(date) = '$month' && school_year = '$school_year'");
    $tutor_records = $this->conn->fetch_all();

    return $tutor_records;
  }

  public function save_tutor_records($data) {

    $school_id = $data['school_id'];
    $course_id = $data['course_id'];
    $school_year = $data['school_year'];

    for ($i=0;$i<count($data['tutor_records']);$i++){
      $date = $data['dates_Y-m-d'][$i];
      $tutor_record = $data['tutor_records'][$i];

      $this->conn->query("INSERT INTO tutor_records
        (school_id, course_id, date, tutor_record, school_year)
        VALUES ('$school_id', '$course_id', '$date', :tutor_record, '$school_year')");
      
      $this->conn->bind(':tutor_record', $tutor_record);
      $this->conn->execute();
    }
  }

  public function update_tutor_records($data) {

    $school_id = $data['school_id'];
    $course_id = $data['course_id'];
    $school_year = $data['school_year'];

    for ($i=0;$i<count($data['tutor_records']);$i++){
      $date = $data['dates_Y-m-d'][$i];
      $tutor_record = $data['tutor_records'][$i];

      $this->conn->query("UPDATE tutor_records SET tutor_record = :tutor_record
      WHERE school_id = '$school_id' && course_id = '$course_id'
      && date='$date' && school_year = '$school_year'");

      $this->conn->bind(':tutor_record', $tutor_record);
      $this->conn->execute();
    }
  }
}