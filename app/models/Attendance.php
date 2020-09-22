<?php

class Attendance extends Model {

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
    
        $school_token = $data['school_token'];
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
            $this->conn->query("INSERT INTO attendance (school_token, course_id, student_id,
              date, presence, school_year) VALUES ('$school_token', '$course_id', '$student_id',
              '$date', '$presence', '$school_year')");
            $this->conn->execute();
          }
        }
      }
    
      public function count_rows_attendance($data) {
    
        $school_token = $data['school_token'];
        $course_id = $data['course_id'];
        $month = $data['month'];
        $school_year = $data['school_year'];
    
        $this->conn->query("SELECT attendance_id FROM attendance
          WHERE school_token = '$school_token' && course_id = '$course_id'
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
    
        $school_token = $data['school_token'];
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
              WHERE school_token = '$school_token' && course_id = '$course_id' && student_id = '$student_id'
              && date='$date' && school_year = '$school_year'");
            $this->conn->execute();
          }
        }
      }
}
