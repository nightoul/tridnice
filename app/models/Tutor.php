<?php 

class Tutor extends Model {

  public function register ($data) {

    $this->conn->query('INSERT INTO tutors (school_id, tutor_first_name, tutor_last_name, tutor_email, tutor_password)
      VALUES (:school_id, :tutor_first_name, :tutor_last_name, :tutor_email, :tutor_pwd)');
    
    // bind values
    $this->conn->bind(':school_id', $data['school_id']);
    $this->conn->bind(':tutor_first_name', $data['tutor_first_name']);
    $this->conn->bind(':tutor_last_name', $data['tutor_last_name']);
    $this->conn->bind(':tutor_email', $data['tutor_email']);
    $this->conn->bind(':tutor_pwd', $data['tutor_pwd']);

    // execute
    if($this->conn->execute()) {
      return true;
    } else {
      return false;
    }

  }

  public function login ($login, $password) {

     // get password from database
     $this->conn->query('SELECT * FROM tutors WHERE tutor_email = :tutor_email');
     $this->conn->bind(':tutor_email', $login);
     $row = $this->conn->fetch_one();
 
     // compare passwords
     $hashed_password = $row['tutor_password'];
     if(password_verify($password, $hashed_password)) {
       return $row;
     } else {
       return false;
     }

  }

  public function find_tutor_email($email){

    $this->conn->query('SELECT * FROM tutors WHERE tutor_email = :tutor_email');
    $this->conn->bind(':tutor_email', $email);

    $row = $this->conn->fetch_one();

    // check
    if($this->conn->count_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function get_school_id_by_token($school_token) {
    $this->conn->query("SELECT school_id FROM schools WHERE school_token = '$school_token'");
    $this->conn->execute();

    $row = $this->conn->fetch_one();
    return $row['school_id'];
  }

  public function get_school_data($tutor_login){
    $this->conn->query('SELECT schools.school_id, school_name FROM schools INNER JOIN tutors
      ON schools.school_id = tutors.school_id WHERE tutors.tutor_email = :tutor_email');
    $this->conn->bind(':tutor_email', $tutor_login);

    $row = $this->conn->fetch_one();
    return $row;
  }

  public function changepass($data){

    $new_password = $data['tutor_pwd'];
    $tutor_id = $data['tutor_id'];

    $this->conn->query('UPDATE tutors SET tutor_password = :new_password WHERE tutor_id = :tutor_id');
    $this->conn->bind(':new_password', $new_password);
    $this->conn->bind(':tutor_id', $tutor_id);

    if($this->conn->execute()) {
      return true;
    }else {
      return false;
    }
  }
}