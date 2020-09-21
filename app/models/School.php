<?php

class School extends Model {

  /* **************** REGISTER SCHOOL ********************* */
  
  public function register($data) {
    $this->conn->query('INSERT INTO schools (school_name, school_email, school_password, school_token)
      VALUES (:school_name, :school_email, :school_password, :school_token)');
    
    // bind values
    $this->conn->bind(':school_name', $data['school_name']);
    $this->conn->bind(':school_email', $data['school_email']);
    $this->conn->bind(':school_password', $data['school_pwd']);
    $this->conn->bind(':school_token', $data['school_token']);
    
    // execute
    if($this->conn->execute()) {
      return true;
    } else {
      return false;
    }
  }
  
  /* **************** LOGIN SCHOOL ********************* */
  
  public function login($login, $password) {

    // get password from database
    $this->conn->query('SELECT * FROM schools WHERE school_email = :school_email');
    $this->conn->bind(':school_email', $login);
    $row = $this->conn->fetch_one();

    // compare passwords
    $hashed_password = $row['school_password'];
    if(password_verify($password, $hashed_password)) {
      return $row;
    } else {
      return false;
    }
  }
  

  /* **************** CHECK FOR SCHOOL EMAIL ********************* */
  
  public function find_school_email ($email){
    $this->conn->query('SELECT * FROM schools WHERE school_email = :school_email');
    $this->conn->bind(':school_email', $email);
    
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
    $this->conn->query("SELECT * FROM schools WHERE school_token = '$school_token'");
    
    if($this->conn->fetch_one()) {
      return true;
    } else {
      return false;
    }
  }
  
  /* **************** CHANGE SCHOOL PASSWORD ********************* */

  public function changepass($data){

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
}