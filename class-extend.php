<?php

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

?>
