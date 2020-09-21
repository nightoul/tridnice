<?php

function get_calendar_year($school_year, $month){

  // get calendar years from school year
  $calendar_year1 = substr($school_year, 0, 4);
  $calendar_year2 = substr($school_year, 5, 9);

  // get calendar year according to selected month
  if($month >= 0 && $month < 4) {
    $calendar_year = $calendar_year1;
  } else {
    $calendar_year = $calendar_year2;
  }

  return $calendar_year;
}

function remap_month_vals($month){

  switch ($month) {
    case 0:
      $month_numeric = 9;
      $month = 'September';
    break;
    case 1:
      $month_numeric = 10;
      $month = 'October';
    break;
    case 2:
      $month_numeric = 11;
      $month = 'November';
    break;
    case 3:
      $month_numeric = 12;
      $month = 'December';
    break;
    case 4:
      $month_numeric = 1;
      $month = 'January';
    break;
    case 5:
      $month_numeric = 2;
      $month = 'February';
    break;
    case 6:
      $month_numeric = 3;
      $month = 'March';
    break;
    case 7:
      $month_numeric = 4;
      $month = 'April';
    break;
    case 8:
      $month_numeric = 5;
      $month = 'May';
    break;
    case 9:
      $month_numeric = 6;
      $month = 'June';
    break;
  }

  $month_remapped = [
    'month_numeric' => $month_numeric,
    'month' => $month,
  ];

  return $month_remapped;
}