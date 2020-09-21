<?php

class Home extends Controller {

  public function index(){

    // if school logged in, redirect to director index
    if(AccessControl::is_logged_in_school()) {
      redirect('directors');
    }
    
    // if tutor logged in, redirect to courses index
    if(AccessControl::is_logged_in_tutor()) {
      redirect('courses');
    }
    
    $data = [];

    $this->view('home/index', $data);
  }
}