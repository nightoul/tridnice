<?php

class Courses extends Controller {

  public function __construct (){

    // if not logged in, redirect to login tutor tab
    if(!AccessControl::is_logged_in_tutor()) {
      redirect('users/login#login-tutor');
    } else {
      $this->course_model = $this->model('Course');
    }
  }

  /******************* DISPLAY TUTOR TIMETABLE **********************/
  public function index() {

    // get courses
    $courses = $this->course_model->get_courses($_SESSION['tutor_id']);

    // if there are no courses yet, set message
    if(empty($courses)) {
      $data['no_courses_yet'] = Localization::localize_message('other', 'no_courses_yet');
    }

    // prepare for timetable: create subarrays of courses for each day of week
    $timetable = [ [], [], [], [], [] ];

    foreach ($courses as $course) {
      switch ($course['course_day']) {
        case "Monday":
          $timetable[0][] = $course;
          break;
        case "Tuesday":
          $timetable[1][] = $course;
          break;
        case "Wednesday":
          $timetable[2][] = $course;
          break;
        case "Thursday":
          $timetable[3][] = $course;
          break;
        case "Friday":
          $timetable[4][] = $course;
          break;
      }
    }

    // prepare for timetable: sort courses in each subarray according to starts_at
    foreach($timetable as $day) {
      if(!empty($day)) {
        usort($day, function($first, $second){
          if($first['starts_at'] == $second['starts_at']) {
            return 0;
          }
          if ($first['starts_at'] > $second['starts_at']) {
            return 1;
          } else {
            return -1;
          }
        });
      }
      $data['timetable'][] = $day;
    }

    // prepare days of week for timetable
    $data['days_of_week'] = Localization::localize_content('days_of_week');
    
    // load view
    $this->view('courses/index', $data);
  }


  /* ****************** CREATE NEW COURSE ******************** */
  public function create(){

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      // sanitize $_POST input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
      // get user input
      $data = [
        'course_name' => trim($_POST['course_name']),
        'course_day' => $_POST['course_day'],
        'school_year' => $_POST['school_year'],
        'starts_at' => $_POST['starts_at'],
        'ends_at' => $_POST['ends_at'],
        'num_of_students' => $_POST['num_of_students'],
        'school_id' => $_SESSION['school_id'],
        'tutor_id' => $_SESSION['tutor_id'],
        'err_course_name' => '',
        'err_course_day' => '',
        'err_starts_at' => '',
        'err_ends_at' => '',
        'err_num_of_students' => '',
        'err_student_names' => ''
      ];

      // get user input: student names + errors  
      for($i=0;$i<$data['num_of_students'];$i++) {
  
        $data["student{$i}first_name"] = $_POST["student{$i}_first_name"];
        $data["student{$i}last_name"] = $_POST["student{$i}_last_name"];

        // check for empty fields
        if(empty($data["student{$i}first_name"]) || empty($data["student{$i}last_name"])) {
          $data["err_student_names"] = 'Vyplňte jména studentů.';
        }
      }

      // if empty course name
      if(empty($data['course_name'])) {
        $data['err_course_name'] = Localization::localize_message('error', 'err_course_name');
      }
      // if empty course day
      if(empty($data['course_day'])) {
        $data['err_course_day'] = Localization::localize_message('error', 'err_course_day');
      }
      // if empty starts at
      if(empty($data['starts_at'])) {
        $data['err_starts_at'] = Localization::localize_message('error', 'err_starts_at');
      }
      // if empty ends at
      if(empty($data['ends_at'])) {
        $data['err_ends_at'] = Localization::localize_message('error', 'err_ends_at');
      }
      // if empty number of students
      if(empty($data['num_of_students'])) {
        $data['err_num_of_students'] = Localization::localize_message('error', 'err_num_of_students');
      }

      // if no errors
      if(empty($data['err_course_name']) && empty($data['err_course_day']) && empty($data['err_starts_at'])
        && empty($data['err_ends_at']) && empty($data['err_num_of_students'])
        && empty($data['err_student_first_name']) && empty($data['err_student_last_name'])) {

        // save to courses table
        $this->course_model->save_course($data);

        // get this course id
        $data['course_id'] = $this->course_model->get_course_id($data);
          
        // save to students table
        $this->course_model->save_students($data);

        // get student ids
        $data['student_ids'] = $this->course_model->get_student_ids($data);

        // redirect to courses index with session message
        Flash::set_flash_message('success', 'success_add_course');
        redirect('courses');

        } else {
        
          // load view with errors
          $this->view('courses/create', $data);
        }     
    }
    
    else {
      
    $data = [
      'course_day' => '',
      'err_course_name' => '',
      'err_course_day' => '',
      'err_starts_at' => '',
      'err_ends_at' => '',
      'err_num_of_students' => '',
      'err_student_names' => ''
    ];
    $this->view('courses/create', $data);

    }
  }

  /* ***************** DISPLAY COURSES WITH MORE DETAILS ********************* */
  public function options(){

    // get courses from database
    $courses = $this->course_model->get_courses($_SESSION['tutor_id']);

    // if there are no courses yet, display message
    if(empty($courses)) {
      $data['no_courses_yet'] = Localization::localize_message('other', 'no_courses_yet');
    }

    // sort courses of each day according to starts_at
    usort($courses, function($first, $second){
      if($first['course_day'] == $second['course_day'] && $first['starts_at'] == $second['starts_at']) {
        return 0;
      }
      if ($first['course_day'] == $second['course_day'] && $first['starts_at'] > $second['starts_at']) {
        return 1;
      } elseif ($first['course_day'] == $second['course_day'] && $first['starts_at'] < $second['starts_at']) {
        return -1;
      }
    });  

    // prepare data
    $data['courses'] = $courses;

    // load view with data
    $this->view('courses/options', $data);
  }

  /* ***************** SHOW COURSE ********************* */
  public function show($course_id){

    // get course name, course day and course time
    $course = $this->course_model->get_course_by_id($course_id);

    // check for correct user   
    if($course['tutor_id'] != $_SESSION['tutor_id']) {
      redirect('courses/options');
    }

      // prepare $data array
        $data = [
          'course_id' => $course_id,
          'course_name' => $course['course_name'],
          'starts_at' => $course['starts_at'],
          'ends_at' => $course['ends_at'],
        ];

    // load view
      $this->view('courses/show', $data);
  }

  /* ***************** EDIT OR DELETE COURSE ********************* */
  public function edit($course_id){

    // update or delete course
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['delete'])) {

      // delete course
      $this->course_model->delete_course_by_id($course_id);

      // redirect to course options with session message
      Flash::set_flash_message('success', 'success_delete_course');
      redirect('courses/options');

    } else {

      // sanitize $_POST input data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // prepare $data array
      $data = [
        'course_id' => $course_id,
        'course_name' => trim($_POST['course_name']),
        'starts_at' => $_POST['starts_at'],
        'ends_at' => $_POST['ends_at'],
        'err_course_name' => '',
        'err_starts_at' => '',
        'err_ends_at' => ''
      ];

      // validate input
      if(empty($data['course_name'])) {
        $data['err_course_name'] = Localization::localize_message('error', 'err_course_name');
      }
      if(empty($data['starts_at'])) {
        $data['err_starts_at'] = Localization::localize_message('error', 'err_starts_at');
      }
      if(empty($data['ends_at'])) {
        $data['err_ends_at'] = Localization::localize_message('error', 'err_ends_at');
      }

        // if no errors
        if(empty($data['err_course_name']) && empty($data['err_starts_at'])
        && empty($data['err_ends_at'])) {

          // update course
          $this->course_model->update_course_by_id($data);

          // redirect to course options with session message
          Flash::set_flash_message('success', 'success_edit_course');
          redirect('courses/options');
        } 

        else {
          $this->view('courses/show', $data);
        }
      }
    }
  }
}