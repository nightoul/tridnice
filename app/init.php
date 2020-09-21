<?php

session_start();

// load config
require_once 'config/config.php';

// autoload libraries
spl_autoload_register (function($class_name) {
  require_once 'libraries/' . $class_name . '.php';
});

// load helpers
require_once 'helpers/redirect.php';
require_once 'helpers/remap_dates.php';