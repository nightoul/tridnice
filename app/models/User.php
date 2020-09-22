<?php

class User extends Model {


/* **************** REGISTER SCHOOL ********************* */
  
public function register_school($data) {
    $this->conn->query('INSERT INTO users (user_type, school_token, school_name, email, password)
      VALUES ("school", :school_token, :school_name, :email, :password)');
    
    // bind values
    $this->conn->bind(':school_name', $data['school_name']);
    $this->conn->bind(':school_token', $data['school_token']);
    $this->conn->bind(':email', $data['school_email']);
    $this->conn->bind(':password', $data['school_pwd']);
    
    // execute
    if($this->conn->execute()) {
      return true;
    } else {
      return false;
    }
  }
  
  /* **************** LOGIN SCHOOL ********************* */
  
  public function login_school($login, $password) {

    // get password from database
    $this->conn->query('SELECT * FROM users WHERE email = :email && user_type = "school"');
    $this->conn->bind(':email', $login);
    $row = $this->conn->fetch_one();

    // compare passwords
    $hashed_password = $row['password'];
    if(password_verify($password, $hashed_password)) {
      return $row;
    } else {
      return false;
    }
  }
  

  /* **************** CHECK FOR SCHOOL EMAIL ********************* */
  
  public function find_school_email ($school_email){
    $this->conn->query('SELECT * FROM users WHERE email = :email && user_type = "school"');
    $this->conn->bind(':email', $school_email);
    
    $row = $this->conn->fetch_one();
    
    // check 
    if($this->conn->count_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  /* **************** VALIDATE SCHOOL TOKEN ********************* */

  public function validate_school_token ($school_token) {
    $this->conn->query("SELECT * FROM users WHERE school_token = '$school_token' && user_type = 'school'");
    
    if($this->conn->fetch_one()) {
      return true;
    } else {
      return false;
    }
  }
  
  /* **************** CHANGE SCHOOL PASSWORD ********************* */

  public function change_school_password($data){

    $new_password = $data['school_pwd'];
    $school_id = $data['school_id'];

    $this->conn->query('UPDATE schools SET school_password = :new_password WHERE school_id = :school_id');
    $this->conn->bind(':new_password', $new_password);
    $this->conn->bind(':school_id', $school_id);

    if($this->conn->execute()) {
      return true;
    }else {
      return false;
    }
  }


  public function register_tutor ($data) {

    $this->conn->query('INSERT INTO users (user_type, school_token, school_name,
      tutor_first_name, tutor_last_name, email, password)
      VALUES ("tutor", :school_token, :school_name, :tutor_first_name, :tutor_last_name, :email, :password)');
    
    // bind values
    $this->conn->bind(':school_token', $data['school_token']);
    $this->conn->bind(':school_name', $data['school_name']);
    $this->conn->bind(':tutor_first_name', $data['tutor_first_name']);
    $this->conn->bind(':tutor_last_name', $data['tutor_last_name']);
    $this->conn->bind(':email', $data['tutor_email']);
    $this->conn->bind(':password', $data['tutor_pwd']);

    // execute
    if($this->conn->execute()) {
      return true;
    } else {
      return false;
    }

  }

  public function login_tutor ($email, $password) {

     // get password from database
     $this->conn->query('SELECT * FROM users WHERE email = :email && user_type = "tutor"');
     $this->conn->bind(':email', $email);
     $row = $this->conn->fetch_one();
 
     // compare passwords
     $hashed_password = $row['password'];
     if(password_verify($password, $hashed_password)) {
       return $row;
     } else {
       return false;
     }

  }

  public function find_tutor_email($email){

    $this->conn->query('SELECT * FROM users WHERE email = :email && user_type = "tutor"');
    $this->conn->bind(':email', $email);

    $row = $this->conn->fetch_one();

    // check
    if($this->conn->count_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function get_school_token_by_id($id){

    $this->conn->query("SELECT school_token FROM users WHERE user_id = '$id'");
    $row = $this->conn->fetch_one();

    return $row['school_token'];
  }
  

  public function get_school_name_by_token($school_token){

    $this->conn->query("SELECT school_name FROM users
      WHERE school_token = '$school_token' && user_type = 'school'");

    $row = $this->conn->fetch_one();
    return $row['school_name'];
  }

  public function change_tutor_password($data){

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