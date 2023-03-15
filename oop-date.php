<?php

class Date {
  public $date;
  public $date_unix_stamp;

  public function __construct(string $date=null) {
    if(empty($date)) {
      $this->date=date("Y-m-d");
      $this->date_unix_stamp=strtotime($this->date);
  } else {
      $this->date=date("Y-m-d", strtotime($date));
      $this->date_unix_stamp=strtotime($this->date);
      }
  }
  // геттеры
  public function getDay() {
    // return strftime("%d", $this->date_unix_stamp);
    return date("d", $this->date_unix_stamp);
  }
  public function getWeekDay(string $lang=null) {
    if($lang=="ru") {
      setlocale(LC_TIME, "ru-RU.UTF-8");
      return strftime("%A", $this->date_unix_stamp);
    } 
    elseif($lang=="en") {
      setlocale(LC_TIME, "");
      return strftime("%A", $this->date_unix_stamp);
    }
    return strftime("%u", $this->date_unix_stamp);
  }
  public function getMonth($lang=null) {
    if($lang=='ru') {
      setlocale(LC_TIME, "ru_Ru.UTF-8");
      return strftime("%B", $this->date_unix_stamp);
    } elseif($lang=='en') {
      setlocale(LC_TIME, "");
      return strftime("%B", $this->date_unix_stamp);
    }
    return strftime("%m", $this->date_unix_stamp);
  } 
  public function getYaer() {
    return strftime("%Y", $this->date_unix_stamp);
  }
  // сеттеры
  public function addDay(string $day) {
      $day=(strtotime($day . " day", $this->date_unix_stamp));
      $this->date("Y-m-d", $day);
  }
  public function subDay(string $day) {
      $day=(strtotime("-" . $day . " day", $this->date_unix_stamp));
      $this->date=date("Y-m-d", $day);
      $this->date_unix_stamp=$day;
  }
  public function addMonth(string $month) {
    $month=(strtotime($month . " month", $this->date_unix_stamp));
    $this->date=date("Y-m-d", $month);
    $this->date_unix_stamp=$month;
  }
  public function subMonth(string $month) {
    $month=(strtotime("-" . $month . " month", $this->date_unix_stamp));
    $this->date=date("Y-m-d", $month);
    $this->date_unix_stamp=$month;
  }
  public function addYear(string $year) {
      $year=(strtotime($year . " year", $this->date_unix_stamp));
      $this->date=date("Y-m-d", $year);
      $this->date_unix_stamp=$year;
  }
  public function subYear(string $year) {
    $year=(strtotime("-" . $year . " year", $this->date_unix_stamp));
    $this->date=date("Y-m-d", $year);
    $this->date_unix_stamp=$year;
  }
  public function format(string $format) {
    return date($format, $this->date_unix_stamp);
  }
  public function __toString() {
    return $this->date;
  }
}

class Interval {

    public function __construct(Date $date1, $date2) {
        $this->date1=$date1;
        $this->date2=$date2;
    }
  
    public function DataTimetoDays() {
      $date1=new DateTime($this->date1->date);
      $date2=new DateTime($this->date2->date);
      // var_dump($result = $date1->diff($date2));
      $result = $date1->diff($date2);
      return $result->days;
    }
    public function DataTimetoMonth() {
      $date1=new DateTime($this->date1->date);
      $date2=new DateTime($this->date2->date);
      // var_dump($result = $date1->diff($date2));
      $result = $date1->diff($date2);
      return $result->m;
    }
    public function DataTimetoYear() {
      $date1=new DateTime($this->date1->date);
      $date2=new DateTime($this->date2->date);
      // var_dump($result = $date1->diff($date2));
      $result = $date1->diff($date2);
      return $result->y;
    }
  
    // public function toDays() {
    //   $date1=$this->date1->date_unix_stamp;
    //   $date2=$this->date2->date_unix_stamp;
    //   var_dump($date1);
    //   var_dump($date2);
    //   return ($date2-$date1);
    //   // return ($date2-$date1)/(60*60*24);
    // }
    // public function toMonth() {
    //   $date1=$this->date1->date_unix_stamp;
    //   $date2=$this->date2->date_unix_stamp;
    //   if($date1<$date2) {
    //     return ($date2-$date1)/(60*60*24*29.3);
    //   }
    //   return ($date1-$date2)/(60*60*24);
    // }
    // public function toYear() {
    //   $date1=$this->date1->date_unix_stamp;
    //   $date2=$this->date2->date_unix_stamp;
    //   if($date1<$date2) {
    //     return ($date2-$date1)/(60*60*24*29.3*365);
    //   }
    //   return ($date1-$date2)/(60*60*24);
    // }
  }