<?php
echo "Наследование <hr>";
class ParentClass
{
    const PARENT = "эта константа определена в родителе" . "<br>";
    public $var = "это переменная определена родителе" . "<br>";
    public static $var_static = "эта статическая переменная определена в родителе" . "<br>";

    public function get_fanc() {
        echo "эта функция определена в родителе" . "<br>";
    }
    public function get_static_var() {
        echo self::$var_static; // доступ к статическому свойству класса внутри метода класса с помощью self::
    }
    public function get_this_var() {
        echo "получение доступа к внутреннему свойству класса - ";
        return $this->var; // доступ к свойству класса внутри метода класса с помощью $this
    }
    public static function get_var() {
        echo "получение доступа к статическому внутреннему свойству класса - ";
        return self::$var_static;
    }
}

echo(new ParentClass)::PARENT;
echo(new ParentClass)->var;
echo ParentClass::$var_static;
echo(new ParentClass)->get_fanc();
(new ParentClass)->get_static_var();
echo (new ParentClass)->get_this_var();
echo ParentClass::get_var();

    echo "<hr>";

class DescedantClass extends ParentClass
{
    public $var = "это переменная переопределена в потомке" . "<br>";

    function get_fanc_descedant() {
        echo "эта функция переопределена в потомке - ";
        parent::get_fanc();
        // parent::$var_static; // ? как вызвать статическое свойство через parent::
    }
    public static function get_var_descedant() {
        echo "переопределение статического метода класса - ";
        return self::$var_static;
    }

}

echo (new DescedantClass)->var; // вызов переопределенного в потомке СВОЙСТВА
echo(new DescedantClass)->get_fanc_descedant(); // вызов переопределенной в потомке МЕТОДА 
echo(new DescedantClass)::PARENT; // вызов КОНСТАНТЫ, определенной в родителе (без оператора области видимости ::)
echo DescedantClass::$var_static; // вызов СТАТИЧЕСКОЙ СВОЙСТВА, определенной в родителе (без оператора области видимости ::)
echo DescedantClass::get_var_descedant(); // вызов переопределенного в потомке СТАТИЧЕСКОГО МЕТОДА

echo "области видимости <hr>";
class ParentClass{
    const PARENT = "константа в родителе" . "<br>";
    protected $var = "свойство в родителе" . "<br>";
    public static $var_static = "статическое свойство в родителе" . "<br>";
   
    public function get_fanc() { echo "функция в родителе" . "<br>"; }
    public function get_this_var() {
     echo "доступ к свойству класса - ";
     return $this->var;
    }
    public function get_static_var() {
     echo "доступ к статическому свойству класса - ";
     echo self::$var_static; 
    }
    public static function get_var() {
     echo "доступ к статическому внутреннему свойству класса - ";
     return self::$var_static;
    }
   }
   
   class DescedantClass extends ParentClass {
    public function get_protect_var() {
     return $this->var;
    }
   }
   
   // $a = new ParentClass();
   // echo $a->var;
   $b=new DescedantClass();
//    echo $b->get_protect_var();

echo "Абстрактные классы<hr>";

abstract class AbstractClass // определение абстрактного класса
{
    // абстрактные методы должны быть определены в дочернем классе
    // ! абстрактнй метод не может содержать тело и реализуется в наследуемом классе
    abstract protected function getValue(); 
    abstract public function setValue(int $value);
    // определение общего свойства в родительском классе
    public $value = 100;
    // определение общего метода в родительском классе
    public function summValue() {
        return ($this->value) + ($this->new_value);
    }
}
class ConcreteClass1 extends AbstractClass {
    public $value="100";
    public $new_value;
    // реализация абстрактных методов, определенных в родительском классе
    public function getValue():int {
        return $this->value;
    }
    public function setValue(int $value) {
        return $this->new_value = $value;
    }
    // определение общего метода в классе-потомке
}
$b=new ConcreteClass1();
var_dump($b->value); // первая область видимости - ПОТОМОК (строка), затем область видимости - РОДИТЕЛЬ (число)
var_dump($b->getValue());
var_dump($b->setValue(1000));
echo $b->summValue(); // вызов общего метода из родительского класса



?>