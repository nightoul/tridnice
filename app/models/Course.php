<?php

class Course extends Model {

  /******************* COURSES TABLE **********************/

  public function get_courses($tutor_id) {

    $this->conn->query("SELECT course_id, course_name, course_day,
      DATE_FORMAT(starts_at, '%H:%i') AS starts_at, DATE_FORMAT(ends_at, '%H:%i') AS ends_at
      FROM courses WHERE user_id = '$tutor_id'
      ORDER BY FIELD (course_day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')");
    $this->conn->execute();
    $rows = $this->conn->fetch_all();
    return $rows;
  }

  public function get_course_id($data){

    $this->conn->query('SELECT course_id FROM courses
      WHERE school_token = :school_token && user_id = :tutor_id
      && course_day = :course_day && starts_at = :starts_at');
    $this->conn->bind(':school_token', $data['school_token']);
    $this->conn->bind(':tutor_id', $data['tutor_id']);
    $this->conn->bind(':course_day', $data['course_day']);
    $this->conn->bind(':starts_at', $data['starts_at']);
    $row = $this->conn->fetch_one();
    return $row['course_id'];
  }

  public function get_course_by_id($course_id) {

    $this->conn->query("SELECT school_token, user_id, course_name, course_day, school_year,
      DATE_FORMAT(starts_at, '%H:%i') AS starts_at, DATE_FORMAT(ends_at, '%H:%i') AS ends_at
      FROM courses WHERE course_id = '$course_id'");
    $this->conn->execute();
    $row = $this->conn->fetch_one();
    return $row;
  }

  public function save_course($data){

    $this->conn->query('INSERT INTO courses (school_token, user_id, course_name, course_day,
      starts_at, ends_at, school_year) VALUES
      (:school_token, :tutor_id, :course_name, :course_day, :starts_at, :ends_at, :school_year)');

    $this->conn->bind(':school_token', $data['school_token']);
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

  /******************* DIRECTOR PAGE: GET COURSES JOINED WITH TUTORS **********************/

  public function get_tutors_and_courses($school_token, $start_pos, $limit){

    $this->conn->query("SELECT CONCAT (u.tutor_last_name, ' ', u.tutor_first_name) AS tutor_name,
    c.course_id, c.course_name, c.course_day,
    DATE_FORMAT(c.starts_at, '%H:%i') AS starts_at, DATE_FORMAT(c.ends_at, '%H:%i') AS ends_at
    FROM users AS u INNER JOIN courses AS c ON u.user_id = c.user_id
    WHERE c.school_token = '$school_token'
    ORDER BY tutor_last_name ASC
    LIMIT $start_pos, $limit");
    $this->conn->execute();
    $rows = $this->conn->fetch_all();

    return $rows;
  }

  public function count_courses($school_token){

    $this->conn->query("SELECT * FROM courses WHERE school_token = '$school_token'");
    $this->conn->fetch_all();
    $row_count = $this->conn->count_rows();

    return $row_count;
  }
}