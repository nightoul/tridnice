<?php

class AccessControl {

  public static function is_logged_in_tutor(){
    if(isset($_SESSION['tutor_id'])) {
      return true;
    } else {
      return false;
    }
  }

  public static function is_logged_in_school(){
    if(isset($_SESSION['school_id'])) {
      return true;
    } else {
      return false;
    }
  }
}