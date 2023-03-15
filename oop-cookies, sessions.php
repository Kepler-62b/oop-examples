<?php

class CookiesShell {

  const COUNTER=1;

  public $name;
  // public $value;
  public $time;

  public function set(string $name,int $time) {
      $this->name=$name;
      $this->time=$time;

      if(empty($_COOKIE)) {
          // echo "if";
          setcookie($name,$this::COUNTER,time() + $time);
          $_COOKIE[$name]=$this::COUNTER;
      } else {
          // echo "else";
          $value=$this::COUNTER+$_COOKIE[$name];
          setcookie($name,$value,time() + $time);
          $_COOKIE[$name]=$value;
      }
      // return $this;
  }
  
  public function del() {
      unset($_COOKIE[$this->name]);
  }

  public function counter() {
      print_r("Counter of visits to the page by a user: " . $_COOKIE[$this->name]);
  }
}


// $cookie=new CookiesShell();

// $cookie->set("test",5);
// $cookie->counter();
// $cookie->del();

class SessionShell {
  public function __construct() {
    if(!isset($_SESSION)) {
        echo "if";
        session_start();
    }
    return $this;
  }

  public function set($name,$value) {
    $_SESSION[$name]=$value;
    return $this;
  }

  public function get($name) {
    return $_SESSION[$name];
  }

  public function del($name) {
    unset($_SESSION[$name]);
  }
public function delCoockie() {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]);


    // unset($_COOKIE);
    return $this;
  }

  public function destroy() {
    session_destroy();
    return $this;
  }
}

var_dump($_COOKIE);
var_dump($_SESSION);



?>