<?php

class AccessControl {

  public static function is_logged_in_school(){
    if(isset($_SESSION['user_id'])) {

      // check for user type
      if($_SESSION['user_type'] == 'school') {
        return true;
      } else {
        return false;
      }
    }
  }

  public static function is_logged_in_tutor(){
    if(isset($_SESSION['user_id'])) {

      // check for user type
      if($_SESSION['user_type'] == 'tutor') {
        return true;
      } else {
        return false;
      }
    }
  }
}