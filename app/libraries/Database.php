<?php

// connect to database, create prep stmts, bind values, return rows

class Database {

  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $conn;
  private $stmt;
  private $error;

  public function __construct(){

    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    // create PDO instance
    try {

      $this->conn = new PDO($dsn, $this->user, $this->pass, $options);

    } catch(PDOException $e) {
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

  // prepare statement with query
  public function query($sql){
    $this->stmt = $this->conn->prepare($sql);
  }

  public function bind($param, $value, $type = null){

    if(is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
        break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
        break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
        break;
        default:
          $type = PDO::PARAM_STR;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }

  // execute prepared statement
  public function execute() {
    return $this->stmt->execute();
  }

    // get one row as assoc array
  public function fetch_one(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  // get result set as multidim array
  public function fetch_all(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // count rows
  public function count_rows(){
    return $this->stmt->rowCount();
  }
}