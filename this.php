<?php
echo "<b>Псевдопеременная \$this</b><hr>";
class Test {
  public $name="Anatoliy";
  private $age=30;
  const YEAR=1992;

  function getName() {
    return $this->name;
  }
  function show() {
    // $this хранит в себе объект - экземпляр класса; через нее можно обратиться к любому объекту(константе, свойству, методу) класса в контексте класса
    echo $this->getName();
    echo $this->age;
    echo $this::YEAR;
  }

}
$a=new Test();
$a->show();