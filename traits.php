<?php

echo "<b>Трейты</b> <br>";
// определение трейта с методом
trait Setter {
  private function setInfo (int $id, string $name, string $age) {
    $this->id=$id;
    $this->name=$name;
    $this->age=$age;
  }
}
// определение трейта с одинаковым методом трейта Setter
trait SetterTwo {
  public function setInfo () {
    return "<hr>" . "Info:" . "<br>";
  }
}
// определение трейта
trait SetterThreeOSub {
  public function getInfo() {
    return "<hr>" . "Info:" . "<br>";
  }
}
// определение трейта с абстрактным классом
// использование в трейте другого трейта
trait SetterThreeMain {
  use SetterThreeOSub;

  abstract public function getJob(string $job);
}
// определение трейта
trait Getter {
  public function getId() {
    return $this->id  . "<br>";
  }
  public function getName() {
    return $this->name . "<br>";
  }
  public function getAge() {
    return $this->age . "<br>";
  }
  public function getRegion() {
    return $this->region . "<br>";
  }
}
// использование трейтов
class User {
  use Setter, SetterTwo, Getter { // использование трейтов в классе
    Setter::setInfo insteadOf SetterTwo; // использование метода из трейта Setter вместо метода из трейта SetterTwo
    Setter::setInfo as public; // изменение модификатора доступа для метода из трейта Setter
    SetterTwo::setInfo as setInfoTwo; // устанавливает псевдоним для использования метода setInfo из трейта SetterTwo
  }
}
$a = new User();
$a->setInfo(1, "Anatoliy", "30");
echo $a->setInfoTwo();
echo $a->getId();
echo $a->getName();
echo $a->getAge();
// использование трейтов
class City {
  use SetterTwo, Getter;

  public function __construct (int $id, string $name, string $region) {
    $this->id=$id;
    $this->name=$name;
    $this->region=$region;
  }
}
$b = new City(1, "St. Peterburg", "RU");
echo $a->setInfoTwo();
echo $b->getId();
echo $b->getName();
echo $b->getRegion();
// использование трейтов с абстрактным классом
class Employee {
  use SetterThreeMain;
  public function getJob(string $job, string $city) { // обязательная реализация абстрактного класса; сигнатура метода может быть изменена
    return $this->job=$job . " - " . $this->city=$city;
  }
}
$c=new Employee();
echo $c->getInfo();
echo $c->getJob("PHP Developer", "SPb");

echo "<hr> <b>Трейты</b> <br>";

trait PropertiesTrait {
  public $var="properte";
}

class PropertiesClass {
  use PropertiesTrait;
  function sayHello() {
    echo $this->var;
  }
}

(new PropertiesClass)->sayHello();

