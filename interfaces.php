<?php
// определение интерфейса-родителя
interface Figure {
  const CALC="Калькулятор:"; // необязательна для реализации; не может быть переопределена в классе
  public function __construct(string $name, int $value1=0, int $value2=0);
  public function getSquare();
  public function getPerimeter();
}
// наследование интерфейса-родителя и определение дополнительного метода
interface OutputFigure extends Figure {
  public function outputSquare();
}
// класс, реализующий интерфейс-родитель
// ! должен реализовывать все методы, описанные в интерфейсе-родителе и придерживаться сигнатуры определенных методов при их реализации 
class Quad implements Figure {
  public $value1;
  public $value2;

  public function __construct(string $name, int $value1=0, int $value2=0) {
    $this->value1=$value1;
    $this->value2=$value2;
  }
  public function getSquare() {
    return ($this->value1) * ($this->value2);
  }
  public function getPerimeter() {
    return ($this->value1) + ($this->value2) + ($this->value1) + ($this->value2);
  }
}
// класс, реализующий интерфейс потомок
// ! должен реализовывать все методы интерфейса родителя, а также методы, описанные в интерфейсе потомка
class QuadExtend implements OutputFigure {
  // public $name;
  // public $value1;
  // public $value2;

  public function __construct(string $name, int $value1=0, int $value2=0) { // переменные, указанные в теле функции, будут созданы автоматически (динамическое присвоение)
    $this->name=$name;
    $this->value1=$value1;
    $this->value2=$value2;
  }
    public function getSquare() {
    return ($this->value1)*($this->value2);
  }
  public function getPerimeter() {
    return ($this->value1)+($this->value2)+($this->value1)+($this->value2);
  }
  public function outputSquare() {
    return "Площадь " . $this->name . "a" . " равна " . $this->getSquare();
  }
}
echo(new QuadExtend(''))::CALC;
echo(new QuadExtend('прямоугольник',4,3))->outputSquare();

// обычный класс, реализующий какую-то функциональность
class FiguresCollection {
  public $figures=[];
  //указываем, что параметр метода addFigure может принимать только объекты определенного класса(и его потомков)
  public function addFigure(Figure $figure) { // в параметр метода передается объект класса, реализующий интерфейс Figure
    $this->figures[]=$figure;
  }
  // после передачи объекта и добавления объекта в массив текущего класса мы можем использовать его методы
  public function showSquare() {
    $sum=$this->figures;
    foreach ($sum as $result) {
        $result = $result->getSquare(4,3);
        return $result;
    }
  }
}
// $a=new FiguresCollection();
// $a->addFigure(new Quad(4,3));
// var_dump($a->figures);
// echo $a->showSquare();

echo "<br> одновременнное наследование класса и реализация интерфейса <hr>";
// определение обычного класса
class Employee {
  public $name;
  public $age;

  public function __construct(string $name, string $age) {
      $this->name=$name;
      $this->age=$age;
  }
}
interface EmployeeInfo {
  public function getName();
  public function getAge();
}
// родительский класс и реализуемый интерфейс имеют одно пространство имен
// порядок ключевых слов ВАЖЕН: с начала "extends", затем "implements"
class Call extends Employee implements EmployeeInfo {
  public function getName() {
      return $this->name;
  }
  public function getAge() {
      return $this->age;
  }
}
// вызов методов без создания объекта
echo(new Call("Anatolij", 30))->getName();
echo(new Call("Anatolij", 30))->getAge();

echo "<br> использование интерфейсов с абстрактными классами <hr>";
interface A {
  public function foo(string $str): string;
  public function bar(int $i): int;
}
// абстрактный класс может реализовывать только часть методов интерфейса, но классы-потомки должны реализовывать остальные методы
abstract class B implements A {
  public function foo(string $s):string {
      return $s;
  }
}
// наследование и реализация метода интерфейса, не реализованного в абстрактном классе
class C extends B {
  public function bar(int $int): int {
      return $int;
  }
}
echo(new C)->foo("hello ");
echo(new C)->bar(10);



?>