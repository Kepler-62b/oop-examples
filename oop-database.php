<?php

interface iDataBaseShell {
  public function __construct();
  
  // public function create(); // создает БД

  public function save($table, $data); // сохранение записи в БД
  public function del($table, $id); // удаляет запись в БД по id
  public function delAll($table, $ids); // удаляет записи в БД по id
  public function get($column,$table,$condition=null); // получает записи из БД

}

class Database {

  public function createDB($db_name) {

  }
  public function dropDB($database) {
    return $this->mysqli->query("DROP DATABASE $database");
  }

  public function createTable($table_name) {
    return $this->mysqli->query("CREATE TABLE $table_name ()");
  }
}

class DatabaseShell {
    
  public $mysqli;

  public function __construct($hostname, $username, $password, $database) {
      $this->mysqli=new mysqli($hostname, $username, $password, $database);
  }
  
  public function save_user($table,$value1=null,$value2=null) {
    $values="'$value1', '$value2'";
    var_dump($values);
    $this->table=$table;
    return $this->mysqli->query("INSERT INTO $table (name, password) 
    VALUES ($values)");
  }

  // public function save_user($table,$value1=null,$value2=null,$value3=null,$value4=null) {
  //   $values="'$value1', '$value2', '$value3', '$value4'";
  //   var_dump($values);
  //   $this->table=$table;
  //   return $this->mysqli->query("INSERT INTO $table (name, surname, age, sex) 
  //   VALUES ($values)");
  // }

  public function get($column,$table,$condition=null) {
    if(isset($condition)) {
      $result=$this->mysqli->query("SELECT $column FROM $table WHERE $condition");
      $result=$result->fetch_all(MYSQLI_ASSOC);
      return $result;
    } else {
      $result=$this->mysqli->query("SELECT $column FROM $table");
      $result=$result->fetch_all(MYSQLI_ASSOC);
      return $result;
    }
  }
  public function delete($table,$condition) {
    return $this->mysqli->query("DELETE FROM $table WHERE $condition");
  }
}

// $connect=new DatabaseShell("localhost", "root", null, "for_test");
// var_dump($connect->save_user_1("users_info","anatoliy","shestopalov","31","men"));
// var_dump($connect->delete("users_info","name='anatoliy'"));
// var_dump($connect->get("*","users_info"));


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $connect=new DatabaseShell("localhost","root",null,"for_test");
    var_dump($connect->save_user("users_test",$_POST["email"],$_POST["password"]));
  } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $connect=new DatabaseShell("localhost","root",null,"for_test");
    // var_dump($_SERVER);
    $string=substr($_SERVER['QUERY_STRING'],7);
    var_dump($string);
    if(empty($string)) {
      $string="";
    } else {
      var_dump($connect->get($string,"users_test"));
      var_dump($connect->delete("users_test","id>'10'"));
    }
  }











