<?php

class Localization {

  public static function localize_message($message_type, $message_subtype) {

    // determine language from session
    // $language = $_SESSION['language'];
    $language = 'en';

    // get message by language + message type and subtype
    if($message_type == 'error') {
      $message = self::$error_message_translations[$language][$message_subtype];
    } elseif($message_type == 'success') {
      $message = self::$success_message_translations[$language][$message_subtype];
    } elseif($message_type == 'other') {
      $message = self::$other_message_translations[$language][$message_subtype];
    }
    return $message;
  }

  public static function localize_content($content_type) {

    // determine language from session
    // $language = $_SESSION['language'];
    $language = 'en';

    // get content by language + content type
    $content = self::$content_translations[$language][$content_type];

    return $content;
  }

  private static $error_message_translations = [
    'en' => [
        'err_school_name' => 'Please fill in the school name.',
        'err_first_name' => 'Please fill in your first name.',
        'err_last_name' => 'Please fill in your last name.',
        'err_email' => 'Please fill in the email.',
        'err_email_invalid' => 'Email must be a valid email.',
        'err_email_taken' => 'This email is already taken.',
        'err_email_not_registered' => 'This email is not registered.',
        'err_pwd' => 'Type the password.',
        'err_pwd_invalid' => 'The password must have at least 6 characters.',
        'err_confirm_pwd' => 'Type the password again.',
        'err_pwd_match' => 'Passwords are not the same.',
        'err_pwd_incorrect' => 'Password incorrect.',
        'err_school_token' => 'Please fill in the school token.', 
        'err_school_token_invalid' => 'Invalid school token.', 
        'err_course_name' => 'Please fill in the course name.',
        'err_course_day' => 'Please fill in the course day.',
        'err_num_of_students' => 'How many students are in the course?',
        'err_starts_at' => 'When does the course start?',
        'err_ends_at' => 'When does the course end?'
    ],
    'cz' => [
        'err_school_name' => 'Vyplňte prosím jméno školy.',
        'err_first_name' => 'Vyplňte prosím jméno.',
        'err_last_name' => 'Vyplňte prosím příjmení.',
        'err_email' => 'Vyplňte prosím email.',
        'err_email_invalid' => 'Zadeje email ve správném tvaru.',
        'err_email_taken' => 'Tento email je již zaregistrovaný.',
        'err_email_not_registered' => 'Tento email není zaregistrovaný.',
        'err_pwd' => 'Zadejte prosím heslo.',
        'err_pwd_invalid' => 'Heslo musí mít aspoň 6 znaků.',
        'err_confirm_pwd' => 'Zadejte heslo znovu pro kontrolu.',
        'err_pwd_match' => 'Hesla se neshodují.',
        'err_pwd_incorrect' => 'Nesprávné heslo.',
        'err_school_token' => 'Zadejte prosím přístupový token.', 
        'err_school_token_invalid' => 'Nesprávný přístupový token.', 
        'err_course_name' => 'Vyplňte prosím název kurzu.',
        'err_course_day' => 'Vyplňte prosím název kurzu.',
        'err_num_of_students' => 'Zadejte počet studentů.',
        'err_starts_at' => 'Zadejte začátek kurzu.',
        'err_ends_at' => 'Zadejte konec kurzu.'
    ]
  ];

  private static $success_message_translations = [
    'en' => [
      'success_choose_language' => 'Language selected.',
      'success_signup_school' => 'Your school is now signed up. Please login.',
      'success_signup_tutor' => 'Signup successful. Please login.',
      'success_change_pwd' => 'Your password has been changed successfully.',
      'success_add_course' => 'New course created successfully.',
      'success_edit_course' => 'Course updated successfully.',
      'success_delete_course' => 'Course deleted successfully.',
    ],
    'cz' => [
      'success_choose_language' => 'Právě jste změnili jazyk.',
      'success_signup_school' => 'Právě jste zaregistrovali školu. Nyní se přihlaste.',
      'success_signup_tutor' => 'Registrace proběhla úspěšně. Nyní se přihlaste.',
      'success_change_pwd' => 'Právě jste změnili heslo.',
      'success_add_course' => 'Právě jste vytvořili nový kurz.',
      'success_edit_course' => 'Právě jste změnili údaje o kurzu.',
      'success_delete_course' => 'Právě jste zrušili kurz.',
  ]

  ];

  private static $other_message_translations = [
    'en' => [
      'no_courses_yet' => 'You don' . "'" . 't have any courses.',
      'delete_course_help' => 'Now click on <br> Submit changes.'
    ],
    'cz' => [
      'no_courses_yet' => 'Nemáte zapsané žádné kurzy.',
      'delete_course_help' => 'Nyní klikněte na <br> Uložit změny.',
    ]
  ];

  private static $content_translations = [
    'en' => [
      'days_of_week' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
    ],
    'cz' => [
      'days_of_week' => ['Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek'],
    ]
  ];
}