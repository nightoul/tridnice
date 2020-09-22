<?php

class Users extends Controller {

  public function __construct() {
    $this->user_model = $this->model('User');
  }


  /* **************** LOAD SIGNUP & LOGIN VIEWS ********************* */

  // load signup view with tabs for signup school & signup tutor
  public function signup() {

    // load signup view
    $this->view('users/signup');
  }

  // load signup view with tabs for login school & login tutor
  public function login () {

    // load login view
    $this->view('users/login');
  }


  /* **************** SIGN UP SCHOOL ********************* */

  // sign up school to database or reload view with errors
  public function signupschool () {
    
    // check for $_POST
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      // sanitize $_POST input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      
      // get user input data
      $data = [
        'user_type' => 'school',
        'school_name' => trim($_POST['school_name']),
        'school_email' => trim($_POST['school_email']),
        'school_password' => trim($_POST['school_password']),
        'confirm_school_password' => trim($_POST['confirm_school_password']),
      ];

      // validate school name
      if(empty($data['school_name'])) {
        $data['err_school_name'] = Localization::localize_message('error', 'err_school_name');
      }

      // validate school email
      if(empty($data['school_email'])) {
        $data['err_school_email'] = Localization::localize_message('error', 'err_email');
        } elseif (!filter_var($data['school_email'], FILTER_VALIDATE_EMAIL)) {
         $data['err_school_email'] = Localization::localize_message('error', 'err_email_invalid');
        } elseif($this->user_model->find_school_email($data['school_email'])) {
          $data['err_school_email'] = Localization::localize_message('error', 'err_email_taken');
      }

      // validate password
      if(empty($data['school_password'])) {
        $data['err_school_password'] = Localization::localize_message('error', 'err_password');
      } elseif(strlen($data['school_password']) < 6) {
        $data['err_school_password'] = Localization::localize_message('error', 'err_password_invalid');
      }

      // validate confirm password
      if(empty($data['confirm_school_password'])) {
        $data['err_confirm_school_password'] = Localization::localize_message('error', 'err_confirm_password');
      } elseif ($data['school_password'] != $data['confirm_school_password']) {
        $data['err_confirm_school_password'] = Localization::localize_message('error', 'err_password_match');
      }

      // if no errors
      if (empty($data['err_school_name']) && empty($data['err_school_email'])
        && empty($data['err_school_password']) && empty($data['err_confirm_school_password'])) {
        
        // hash password
        $data['school_password'] = password_hash($data['school_password'], PASSWORD_DEFAULT);

        // generate unique school token
        $length = 8;
        $chars = "1234567890";
        $data['school_token'] = substr(str_shuffle($chars), 0, $length);

        // call model to register school
        if($this->user_model->register_school($data)) {

          // redirect to login with flash message
          Flash::set_flash_message('success', 'success_signup_school');
          redirect('users/login');
        }

        // if errors
      } else {

        // reload view with errors
        $this->view('users/signup', $data);
      }

    } 
  }

  /* **************** LOGIN SCHOOL ********************* */

  // login school or reload view with errors
  public function loginschool () {
    
    // check for $_POST
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      // sanitize $_POST input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // get user input data and prepare errors
      $data = [
      'school_email' => trim($_POST['school_email']),
      'school_password' => trim($_POST['school_password']),
      ];

      // if empty login
      if(empty($data['school_email'])) {
        $data['err_school_email'] = Localization::localize_message('error', 'err_email');
      }
      // check if login exists (call model method)
      elseif (!$this->user_model->find_school_email($data['school_email'])) {
        $data['err_school_email'] = Localization::localize_message('error', 'err_email_not_registered');
      }
      
      // if empty password
      if(empty($data['school_password'])) {
        $data['err_school_password'] = Localization::localize_message('error', 'err_password');
      }

      // if no errors
      if (empty($data['err_school_email']) && empty($data['err_school_password'])) {
        // check for correct password and login (call model method)
        $logged_in = $this->user_model->login_school($data);

        if($logged_in) {
          // create session 'logged in'
          $this->create_login_session_school($logged_in);

        } else {
          // incorrect password, load view with error
          $data['err_school_password'] = Localization::localize_message('error', 'err_password_incorrect');
          $this->view('users/login', $data);
        }

        // if errors
      } else {
        
        // reload view with errors
        $this->view('users/login', $data);
      }
    }
  }


  /* **************** CREATE LOGIN SESSION SCHOOL********************* */
  
  public function create_login_session_school($logged_in) {
   
    // create session variables for school data from $row
    $_SESSION['user_id'] = $logged_in['user_id'];
    $_SESSION['user_type'] = $logged_in['user_type'];
    $_SESSION['school_name'] = $logged_in['school_name'];
    redirect('directors');
  }

  /* **************** SIGN UP TUTOR ********************* */

  // sign up tutor to database or reload view with errors
  public function signuptutor (){
    
    // check for $_POST
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      // sanitize $_POST input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      
      // get user input data
      $data['user_type'] = 'tutor';
      $data['tutor_first_name'] = trim($_POST['tutor_first_name']);
      $data['tutor_last_name'] = trim($_POST['tutor_last_name']);
      $data['tutor_email'] = trim($_POST['tutor_email']);
      $data['school_token'] = trim($_POST['school_token']);
      $data['tutor_password'] = trim($_POST['tutor_password']);
      $data['confirm_tutor_password'] = trim($_POST['confirm_tutor_password']);

      // if empty first name
      if(empty($data['tutor_first_name'])) {
        $data['err_tutor_first_name'] = Localization::localize_message('error', 'err_first_name');
      }

      // if empty last name
      if(empty($data['tutor_last_name'])) {
        $data['err_tutor_last_name'] = Localization::localize_message('error', 'err_last_name');
      }

      // validate email
      if(empty($data['tutor_email'])) {
        $data['err_tutor_email'] = Localization::localize_message('error', 'err_email');
        } elseif (!filter_var($data['tutor_email'], FILTER_VALIDATE_EMAIL)) {
         $data['err_tutor_email'] = Localization::localize_message('error', 'err_email_invalid');
        } elseif($this->user_model->find_tutor_email($data['tutor_email'])) {
          $data['err_tutor_email'] = Localization::localize_message('error', 'err_email_taken');
      }
      
      // if empty school token
      if(empty($data['school_token'])) {
        $data['err_school_token'] = Localization::localize_message('error', 'err_school_token');
      }
        // validate school token 
        elseif(!$this->user_model->validate_school_token($data['school_token'])) {
          $data['err_school_token'] = Localization::localize_message('error', 'err_school_token_invalid');
      }

      // validate password
      if(empty($data['tutor_password'])) {
        $data['err_tutor_password'] = Localization::localize_message('error', 'err_password');
      } elseif(strlen($data['tutor_password']) < 6) {
        $data['err_tutor_password'] = Localization::localize_message('error', 'err_password_invalid');
      }

      // validate confirm password
      if(empty($data['confirm_tutor_password'])) {
        $data['err_confirm_tutor_password'] = Localization::localize_message('error', 'err_confirm_password');
      } elseif ($data['tutor_password'] != $data['confirm_tutor_password']) {
        $data['err_confirm_tutor_password'] = Localization::localize_message('error', 'err_password_match');
      }

      // if no errors
      if (empty($data['err_tutor_first_name']) && empty($data['err_tutor_last_name'])
         && empty($data['err_tutor_email']) && empty($data['err_school_token'])
         && empty($data['err_tutor_password']) && empty($data['err_confirm_tutor_password'])) {
        
        // hash password
        $data['tutor_password'] = password_hash($data['tutor_password'], PASSWORD_DEFAULT);

        // get school name by token
        $data['school_name'] = $this->user_model->get_school_name_by_token($data['school_token']);

        // call model method to register tutor
        if($this->user_model->register_tutor($data)) {
          
          // redirect to login#tutor with flash message
          Flash::set_flash_message('success', 'success_signup_tutor');
          redirect('users/login#login-tutor');
        } 

        // if errors
      } else {

        // send redirected from tutor signup (to preselect #tutor tab)
        $data['redirected_from_tutor'] = true;

        // reload view with errors
        $this->view('users/signup', $data);
      }
    } 
  }

  /* **************** LOGIN TUTOR ********************* */

  // login school or reload view with errors
  public function logintutor () {

    // check for $_POST
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      // sanitize $_POST input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // get user input data and prepare errors
      $data = [
      'tutor_email' => trim($_POST['tutor_email']),
      'tutor_password' => trim($_POST['tutor_password']),
      ];

      // check for empty login
      if(empty($data['tutor_email'])) {
        $data['err_tutor_email'] = Localization::localize_message('error', 'err_email');
      }
      // check if login exists (call model method)
      elseif (!$this->user_model->find_tutor_email($data['tutor_email'])) {
        $data['err_tutor_email'] = Localization::localize_message('error', 'err_email_not_registered');
      }
     
      // check for empty password
      if(empty($data['tutor_password'])) {
        $data['err_tutor_password'] = Localization::localize_message('error', 'err_password');
      }

      // check for correct password
      if(empty($data['err_tutor_password'])) {
        $logged_in = $this->user_model->login_tutor($data);
        if(!$logged_in) {
          $data['err_tutor_password'] = Localization::localize_message('error', 'err_password_incorrect');
        }
      }
      
      // if no errors
      if(empty($data['err_tutor_email']) && empty($data['err_tutor_password'])) {

        // create session 'logged in'
        $this->create_login_session_tutor($logged_in);
      }
        
      // if errors
        else {

        // send redirected from tutor login (to preselect #tutor tab)
        $data['redirected_from_tutor'] = true;

        // reload view with errors
        $this->view('users/login', $data);
      }
    } 
  }

  /* **************** CREATE LOGIN SESSION TUTOR ********************* */
 
  public function create_login_session_tutor($logged_in) {
    
    // create session variables for tutor data from $row
    $_SESSION['user_id'] = $logged_in['user_id'];
    $_SESSION['user_type'] = $logged_in['user_type'];
    $_SESSION['school_name'] = $logged_in['school_name'];
    redirect('courses');
  }

  /* **************** CHANGE PASSWORD ********************* */
  public function changepassword(){

    // check for $_POST
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      // sanitize $_POST input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // get user input data and prepare errors
      $data = [
      'password' => trim($_POST['password']),
      'confirm_password' => trim($_POST['confirm_password']),
      'err_password' => '',
      'err_confirm_password' => ''
      ];

      // validate password
      if(empty($data['password'])) {
        $data['err_password'] = Localization::localize_message('error', 'err_password');
      } elseif(strlen($data['password']) < 6) {
        $data['err_password'] = Localization::localize_message('error', 'err_password_invalid');
      }

      // validate confirm password
      if(empty($data['confirm_password'])) {
        $data['err_confirm_password'] = Localization::localize_message('error', 'err_confirm_password');
      } elseif ($data['password'] != $data['confirm_password']) {
        $data['err_confirm_password'] = Localization::localize_message('error', 'err_password_match');
      }
      
      // if no errors
      if (empty($data['err_password']) && empty($data['err_confirm_password'])) {

        // get user id
        $data['user_id'] = $_SESSION['user_id'];
        
        // hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // update password
        if($this->user_model->change_password($data)) {

          // redirect to index with session message
          Flash::set_flash_message('success', 'success_change_password');

          if($_SESSION['user_type'] == 'school') {
            redirect('directors');
          } elseif($_SESSION['user_type'] == 'tutor') {
            redirect('courses');
          }
        }

      } else {
        // wrong input data, reload view with errors
        $this->view('users/changepassword', $data);
      }

    } else {

      // if submit is not set
      $data = [
        'err_password' => '',
        'err_confirm_password' => ''
      ];
      // load view
      $this->view('users/changepassword', $data);
    }
  }

  /* **************** LOGOUT ********************* */
  
  public function logout () {
    
    unset($_SESSION['user_id']);
    unset($_SESSION['user_type']);
    unset($_SESSION['school_name']);
    session_destroy();
    redirect('home');
  }
}