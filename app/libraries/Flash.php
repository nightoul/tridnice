<?php

class Flash {

  public static function set_flash_message($message_type, $message_subtype) {

      $message = Localization::localize_message($message_type, $message_subtype);

      $_SESSION['message'] = $message;
  }

  public static function show_flash_message(){
    if(isset($_SESSION['message'])) {
      echo "<script> M.toast({html:'" . $_SESSION['message'] . "'}) </script>";
      unset($_SESSION['message']);
    }
  }
}