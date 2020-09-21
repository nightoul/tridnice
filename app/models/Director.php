<?php

class Director extends Model {

  public function get_tutors_and_courses($school_id, $start_pos, $limit){

    $this->conn->query("SELECT CONCAT (t.tutor_last_name, ' ', t.tutor_first_name) AS tutor_name,
    c.course_id, c.course_name, c.course_day,
    DATE_FORMAT(c.starts_at, '%H:%i') AS starts_at, DATE_FORMAT(c.ends_at, '%H:%i') AS ends_at
    FROM tutors AS t INNER JOIN courses AS c ON t.tutor_id = c.tutor_id
    WHERE t.school_id = '$school_id' && c.school_id = '$school_id'
    ORDER BY tutor_last_name ASC
    LIMIT $start_pos, $limit");
    $this->conn->execute();
    $rows = $this->conn->fetch_all();

    return $rows;
  }

  public function count_courses($school_id){

    $this->conn->query("SELECT * FROM courses WHERE school_id = '$school_id'");
    $this->conn->fetch_all();
    $row_count = $this->conn->count_rows();

    return $row_count;
  }
}