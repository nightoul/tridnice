<?php 

class TutorRecord extends Model {

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
