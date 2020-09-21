
<?php 

class Student extends Model {

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

  public function save_students($data){

    for($i=0;$i<$data['num_of_students'];$i++) {

      $this->conn->query('INSERT INTO students (school_id, course_id, student_first_name, student_last_name)
      VALUES (:school_id, :course_id, :student_first_name, :student_last_name)');
      $this->conn->bind(':school_id', $data['school_id']);
      $this->conn->bind(':course_id', $data['course_id']);
      $this->conn->bind(':student_first_name', $data["student{$i}first_name"]);
      $this->conn->bind(':student_last_name', $data["student{$i}last_name"]);

      // execute
      $this->conn->execute();
    }
  }

}

