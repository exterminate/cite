<?php

class Author {
  
  public $email;
  public $deepLink;
  public $time;
  
  function __construct($email, $deepLink, $handler) {
    $this->email = $email;
    $this->deepLink = $deepLink;
    $this->handler = $handler;
  }
  
  public function createLoginSession() {
    $sql = "INSERT INTO authors () VALUES ()";
    $array = array(
      ":email" => $this->email,
      ":deepLink" => $this->deepLink,
      ":time" => strtotime("now")
      );
      
  }
}

?>
