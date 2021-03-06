<?php

class Directors extends Controller {

  public function __construct (){

    // if not logged in, redirect to login school tab
    if(!AccessControl::is_logged_in_school()) {
      redirect('users/login');
    } else {
      $this->course_model = $this->model('Course');
      $this->user_model = $this->model('User');
    }
  }

  public function index(){

    /* ******************* SHOW TUTORS AND COURSES (PAGINATION) **************** */

    // get school token
    $school_id = $_SESSION['user_id'];
    $school_token = $this->user_model->get_school_token_by_id($school_id);

    // set current page from query string
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // set limit
    $limit = 5;

    // set starting position
    $start_pos = $page > 1 ? ($page - 1) * $limit : 0;

    // get tutors and their courses
    $data['tutors_and_courses'] = 
      $this->course_model->get_tutors_and_courses($school_token, $start_pos, $limit);

    // get number of courses for this school
    $num_of_courses = $this->course_model->count_courses($school_token);

    // calculate number of pages
    $num_of_pages = ceil($num_of_courses / $limit);

    // prepare data for view
    $data['page'] = $page;
    $data['limit'] = $limit;
    $data['num_of_pages'] = $num_of_pages;


    // load view with data
    $this->view('directors/index', $data);
  }
}