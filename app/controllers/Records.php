<?php

class Records extends Controller {

  public function __construct (){

    $this->user_model = $this->model('User');
    $this->course_model = $this->model('Course');
    $this->student_model = $this->model('Student');
    $this->attendance_model = $this->model('Attendance');
    $this->tutor_record_model = $this->model('TutorRecord');
  }


  public function show($course_id, $month) {

    // check if neither school nor tutor are logged in
    if(!AccessControl::is_logged_in_school() && !AccessControl::is_logged_in_tutor()) {
      redirect('users/login');
      exit();
    }
   
    // call getter
    $data = $this->getrecord($course_id, $month);

    // if school logged in
    if(AccessControl::is_logged_in_school()) {

      // check for correct user   
      // if($data['school_id'] != $_SESSION['user_id']) {
      //   redirect('directors');
      // }

      // send user type
      $data['user_type'] = 'school';
    
      // load view with data
      $this->view('records/show', $data);
    }

    if(AccessControl::is_logged_in_tutor()) {

      // check for correct user   
    // if($data['tutor_id'] != $_SESSION['tutor_id']) {
    //   redirect('courses');
    // }

    // update record
    if(isset($_POST['submit'])) {

      // get attendance from form
      $checklist = $_POST['checklist'];
      
      /* slice checklist into rows: each student has one row of data in the checkbox grid
      which means either 4 or 5 columns according to number of weeks in a given month */
      $data['checklist_rows'] = array_chunk($checklist, count($data['dates_Y-m-d']));
      
      // get tutor records from form
      $data['tutor_records'] = $_POST['tutor_records'];

    
      /* ***************** INSERT/UPDATE *********************** */

      // check for first entry
      if(!$this->attendance_model->count_rows_attendance($data)) {
        // if attendance for this month is empty, insert data for new month
          $this->attendance_model->save_attendance($data);
          $this->tutor_record_model->save_tutor_records($data);
      } else {
        // else update presence in existing month
          $this->attendance_model->update_attendance($data);
          $this->tutor_record_model->update_tutor_records($data);
      }

      // redirect to courses index
      redirect('courses');
    } else {

      // send user type
      $data['user_type'] = 'tutor';

      // load view
      $this->view('records/show', $data);
    }  

    }

    

  }
  
  


  public function getrecord($course_id, $month){

    // get this course by id
    $course = $this->course_model->get_course_by_id($course_id);
    
    // prepare data: basic course info
    $data = [
      'course_id' => $course_id,
      'course_name' => $course['course_name'],
      'course_day' => $course['course_day'],
      'starts_at' => $course['starts_at'],
      'ends_at' => $course['ends_at'],
      'school_year' => $course['school_year']
    ];

    // get school token
    $data['school_token'] = $this->user_model->get_school_token_by_id($_SESSION['user_id']);

    
    /* *******************  REMAP MONTH VALUES ************************* 

    - JS takes 0-9 (Sept - Jun) month values from select#archive and passes it as
    second parameter into records/updaterecord and records/showrecord */

    $month_remapped = remap_month_vals($month);

    // prepare data
    $data['month_numeric'] = $month_remapped['month_numeric'];
    $data['month'] = $month_remapped['month'];


    /* ***************** MAKE DATES FOR GRID COLUMNS *********************** */

    // prepare args
    $calendar_year = get_calendar_year($data['school_year'], $month);
    $month = $data['month'];
    $day = $data['course_day'];

    // make grid column dates
    $dates = $this->make_grid_column_dates($calendar_year, $month, $day);

    // get dates in Y-m-d format
    foreach($dates['Y-m-d'] as $date['Y-m-d']) {
      $data['dates_Y-m-d'][] = $date['Y-m-d'];
    }

    // get dates in d. m. format
    foreach($dates['d. m.'] as $date['d. m.']) {
      $data['dates_d. m.'][] = $date['d. m.'];
    }


    /* *******************  GET STUDENTS FROM DATABASE  ********************** */

    // get student ids & prepare for view
    $student_ids = $this->student_model->get_student_ids($course_id);
    $data['student_ids'] = $student_ids;

    // get student names mapped to ids & prepare for view
    $student_names = $this->student_model->get_student_names($student_ids);
    foreach ($student_names as $student_name) {
      $data['student_names'][] = $student_name['student_name'];
    }

    // get student attendance mapped to ids & prepare for view (JSON)
    $attendance_raw = $this->attendance_model->get_attendance($data);
    foreach($attendance_raw as $attendance_raw_sg) {
      $data['attendance'][] = array_column($attendance_raw_sg, 'presence');
    }

    /* *******************  GET TUTOR RECORDS FROM DATABASE  ********************** */

    // get records
    $tutor_records = $this->tutor_record_model->get_tutor_records($data);

    // prepare data for view: tutor records
    foreach($tutor_records as $tutor_record) {
      if(isset($tutor_record['tutor_record'])) {
        $data['tutor_records'][] = $tutor_record['tutor_record'];
      }
    }

    return $data;
  }
  
  public function make_grid_column_dates($year, $month, $day) {

    // get UNIX timestamp for first and last date in selected month
    $start_date = new DateTime("$year-$month");
    $start_date = $start_date->modify("first $day of this month")->format('U');
    $end_date = new DateTime("$year-$month");
    $end_date = $end_date->modify("last $day of this month")->format('U');
    
    // get number of lessons in selected month
    $num_of_lessons = 1;
    $from = $start_date;
    
    while ($from <= $end_date) {
      $from += WEEK; // WEEK is a constant from config
      $num_of_lessons++;
    }
    
    // get grid dates in UNIX timestamp format
    $dates_U[] = $start_date;
    $next_date = $start_date;
    
    for($i=0; $i<$num_of_lessons - 1; $i++) { // because first lesson is already put into array
      $next_date += WEEK;
      $dates_U[] = $next_date;
    }
    
    // get grid dates in Y-m-d and d. m. formats
    foreach($dates_U as $date_U){
      $dates['Y-m-d'][] = date('Y-m-d', $date_U);
      $dates['d. m.'][] = date('d. m.', $date_U);
    }

    return $dates;
  }
}
