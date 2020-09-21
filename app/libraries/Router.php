<?php

class Router {
  
  protected $controller = 'Home';  // deffault controller 'Home'
  protected $method = 'index';     // default method 'index'
  protected $params = [];

  public function __construct (){

    // get array from URL: controller/method/params => [0] controller, [1] method, [3+] params
    $url = $this->getUrl();

    // check if controller exists: controller in URL must match an existing file
    if(isset($url) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {

      // set current controller
      $this->controller = ucwords($url[0]);
      unset($url[0]);
    }

    // require current controller (either controller from URL or default controller)
    require_once '../app/controllers/' . $this->controller . '.php';
    
    // instantiate controller
    $this->controller = new $this->controller;

    // check if method provided in URL exists in a given controller
    if(isset($url[1])) {
      if(method_exists($this->controller, $url[1])) {

        // set current method
        $this->method = $url[1];
        unset($url[1]);
      }
    }

    // get params from what is left in the array (if any)
    $this->params = $url ? array_values($url) : [];

    // call controller and method + pass params if any
    call_user_func_array([$this->controller, $this->method], $this->params);
  }

  public function getUrl() {
    
    if (isset($_GET['url'])) {

      // get sanitized URL
      $url = rtrim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);

      // make array from URL
      $url = explode('/', $url);
      return $url;
    }
  }
}