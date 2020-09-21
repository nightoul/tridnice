<?php

// redirect user
function redirect($location) {
  header('Location: ' . URLROOT . '/' . $location);
}