<?php

class Course extends Model {

  /******************* COURSES TABLE **********************/

  public function get_courses($tutor_id) {

    $this->conn->query("SELECT course_id, course_name, course_day,
      DATE_FORMAT(starts_at, '%H:%i') AS starts_at, DATE_FORMAT(ends_at, '%H:%i') AS ends_at
      FROM courses WHERE tutor_id = '$tutor_id'
      ORDER BY FIELD (course_day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')");
    $this->conn->execute();
    $rows = $this->conn->fetch_all();
    return $rows;
  }

  public function get_course_id($data){

    $this->conn->query('SELECT course_id FROM courses
      WHERE school_id = :school_id && tutor_id = :tutor_id
      && course_day = :course_day && starts_at = :starts_at');
    $this->conn->bind(':school_id', $data['school_id']);
    $this->conn->bind(':tutor_id', $data['tutor_id']);
    $this->conn->bind(':course_day', $data['course_day']);
    $this->conn->bind(':starts_at', $data['starts_at']);
    $row = $this->conn->fetch_one();
    return $row['course_id'];
  }

  public function get_course_by_id($course_id) {

    $this->conn->query("SELECT tutor_id, course_name, course_day, school_year,
      DATE_FORMAT(starts_at, '%H:%i') AS starts_at, DATE_FORMAT(ends_at, '%H:%i') AS ends_at
      FROM courses WHERE course_id = '$course_id'");
    $this->conn->execute();
    $row = $this->conn->fetch_one();
    return $row;
  }

  public function save_course($data){

    $this->conn->query('INSERT INTO courses (school_id, tutor_id, course_name, course_day,
      starts_at, ends_at, school_year) VALUES
      (:school_id, :tutor_id, :course_name, :course_day, :starts_at, :ends_at, :school_year)');

    $this->conn->bind(':school_id', $data['school_id']);
    $this->conn->bind(':tutor_id', $data['tutor_id']);
    $this->conn->bind(':course_name', $data['course_name']);
    $this->conn->bind(':course_day', $data['course_day']);
    $this->conn->bind(':starts_at', $data['starts_at']);
    $this->conn->bind(':ends_at', $data['ends_at']);
    $this->conn->bind(':school_year', $data['school_year']);

    $this->conn->execute();
  }

  public function update_course_by_id($data) {

    $this->conn->query('UPDATE courses SET course_name = :course_name,
      starts_at = :starts_at, ends_at = :ends_at WHERE course_id = :course_id');

    // bind values
    $this->conn->bind(':course_name', $data['course_name']);
    $this->conn->bind(':starts_at', $data['starts_at']);
    $this->conn->bind(':ends_at', $data['ends_at']);
    $this->conn->bind(':course_id', $data['course_id']);

    // execute
    $this->conn->execute();
  }

  public function delete_course_by_id($course_id) {

    // delete tutor records
    $this->conn->query("DELETE FROM tutor_records WHERE course_id = :course_id");
    $this->conn->bind(':course_id', $course_id);
    $this->conn->execute();

    // delete attendance
    $this->conn->query("DELETE FROM attendance WHERE course_id = :course_id");
    $this->conn->bind(':course_id', $course_id);
    $this->conn->execute();

    // delete students
    $this->conn->query("DELETE FROM students WHERE course_id = :course_id");
    $this->conn->bind(':course_id', $course_id);
    $this->conn->execute();

    // delete courses
    $this->conn->query("DELETE FROM courses WHERE course_id = :course_id");
    $this->conn->bind(':course_id', $course_id);
    $this->conn->execute();
  }

  /******************* STUDENTS TABLE **********************/
  public function get_student_ids($data){

    $this->conn->query('SELECT student_id FROM students WHERE course_id = :course_id
      ORDER BY student_id ASC');
    $this->conn->bind(':course_id', $data['course_id']);

    $rows = $this->conn->fetch_all();

    foreach($rows as $row) {
      $student_ids[] = $row['student_id'];
    }

    return $student_ids;
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