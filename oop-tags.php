<?php

interface iTag {
  // сеттер тега(конструктор)
  // public function __construct($tag);

  // сеттер атрибута(ов)
  public function setAttr($attr, $value=null);
  public function setAttrs(array $attrs);
  public function deleteAttr($attr);
  // сеттер текста
  public function setText($text);
  // сеттеры атрибута class
  public function addClass($className);
  public function deleteClass($className);

  // геттер тега
  public function getTag();
  // геттер атрибута(ов)
  public function getAttrs();
  public function getAttr($tag);
  
  // открытие/закрытие тега
  public function open();
  public function close();
  public function show();
}

class Tag implements iTag {
  public $tag;
  public $text;
  public $attrs=[];

  public function __construct($tag) {
    $this->tag=$tag;
  }
  
  public function setAttr($attr, $value=null) {
    if(isset($value)) {
      $this->attrs[$attr]=$value;
      return $this;
    } else {
      $this->attrs[$attr]="";
      return $this;
    }
  }
  public function setAttrs(array $attrs) {
    foreach($attrs as $attr=>$value) {
      $this->attrs[$attr]=$value;
    }
    return $this;
  }
  public function deleteAttr($attr) {
    unset($this->attrs[$attr]);
    return $this;
  }
  
  public function setText($text) {
    $this->text=$text;
    return $this;
  }
  
  public function addClass($className) {
    if(array_key_exists("class",$this->attrs)) {
      $result=$this->attrs["class"] . " $className";
      $arr_class=explode(" ", $this->attrs["class"]);
      if(!in_array($className, $arr_class)) {
        $this->attrs["class"] = $result;
      }
      return $this;
    } else {
      $this->setAttr("class", $className);
      return $this;
    }
  }
  public function deleteClass($className) {
    $result=explode(" ", $this->attrs["class"]);
    $search=array_search($className, $result);
    unset($result[$search]);
    $result=implode(" ", $result);
    $this->attrs["class"]=$result;
    if($this->attrs["class"]=="") {
      $this->deleteAttr("class");
    }
    return $this;
  }
  
  public function getTag() {
    return $this->tag;
  }
  public function getAttr($tag) {
    if(array_key_exists($tag,$this->attrs)) {
      return $this->attrs[$tag];
    } elseif($tag=="all") {
      return $this->attrs;
    }
    else {
      return null;
    }
  }
  public function getAttrs() {
    return $this->attrs;
  }
  
  public function open() {
    if(isset($this->attrs) && (!isset($this->text)))  {
      $attrs = $this->getAttrTag();
      return "<$this->tag $attrs>";
    } elseif((isset($this->attrs)) && (isset($this->text))) {
      $attrs = $this->getAttrTag();
      return "<$this->tag $attrs>" . $this->text;
    } else {
      return "<$this->tag>";
    }
  }
  public function close() {
    return "</$this->tag>";
  }
  public function show() {
    return $this->open() . $this->close();
  }
  public function openAll() {
    foreach($this->tag as $key=>$value) {
      if(isset($this->attrs) && (!isset($this->text)))  {
        $attrs = $this->getAttrTag();
        echo "<" . $this->tag[$key] . $attrs . ">";
      } elseif((isset($this->attrs)) && (isset($this->text))) {
        $attrs = $this->getAttrTag();
        echo "<".$this->tag[$key].$attrs.">".$this->text;
      } else {
        echo "<".$this->tag[$key].">";
      }
    }
  }

  protected function getAttrTag() {
    $result;
    foreach($this->attrs as $key=>$value) {
      $result .= "$key=\"$value\" \n";
    }
    return $result;
  }
}

class Img extends Tag{
  public function __construct() {
    parent::__construct("img");
    
    $this->setAttr("src");
    $this->setAttr("alt");
  }

  public function open() {
    // if(!array_key_exists("src", $this->attrs)) {
    //   $this->setAttr("src");
    // } elseif (!array_key_exists("alt", $this->attrs)) {
    //   $this->setAttr("alt");
    // }
    if(isset($this->attrs) && (!isset($this->text)))  {
      $attrs = $this->getAttrTag();
      return "<$this->tag $attrs>";
    } elseif((isset($this->attrs)) && (isset($this->text))) {
      $attrs = $this->getAttrTag();
      return "<$this->tag $attrs>" . $this->text;
    } else {
      return "<$this->tag>";
    }
  }
  // public function __toString() { // метод, который вызывается при попытке преобразовать объект в строку
  //   return parent::open();
  // }
}

class Link extends Tag {
  const FORCLASS="active";

  public function __construct() {
    parent::__construct("a");

    $this->setAttr("href");
  }

  public function activeSelf() {
    $result = substr($_SERVER["REQUEST_URI"],11,10);
    // var_dump($result);
    if($result===$this->getAttr("href")) {
        $this->addClass($this::FORCLASS);
    }
    return $this;
  }
}

class HtmlList extends Tag {
  private $li_arr=[];

  public function __construct($tag) {
    $this->tag=$tag;
  }

  public function addItem(ListItem $item) {
    $this->li_arr[]= $item;
    return $this;
  }

  public function show() {
    // echo $this->open();
    // for($i=0;$i<count($this->li_arr);$i++) {
    //   $this->li_arr[$i]->show();
    // }
    // echo $this->close();
    for($i=0;$i<count($this->li_arr);$i++) {
      $result .= $this->li_arr[$i]->show();
    }
    return $this->open() . $result . $this->close();
  }
}

class ListItem extends Tag {
  public function __construct($text) {
    parent::__construct("li");
    $this->setText($text);
  }
}

class Form extends Tag {
  public function __construct() {
    parent::__construct("form");
  }

}

class Input extends Tag {
  public function __construct($type=null) {
    parent::__construct("input");
    if(isset($type)) {
      $this->setAttr("type",$type);
    }
  }

  public function __toString() {
    return parent::open();
  }

  public function open() {
    if(array_key_exists("name", $this->attrs)) {
      $inputName=$this->getAttr("name");
      $value=$_REQUEST[$inputName];
        if(!isset($value)) {
          var_dump("if");
          return parent::open();
        } 
        else {
          var_dump("else");
          $this->setAttr("value",$value);
          return parent::open();
        }
      } else {
        return parent::open();
      }
  }


}

class Submit extends Tag {
  public function __construct() {
    parent::__construct("input");
    $this->setAttr("type","submit");
  }

  public function __toString() {
    return $this->show();
  }
}

class TextArea extends Tag {

  public function __construct() {
    parent::__construct("textarea");
  }

  public function show() {
    if(isset($_REQUEST["text"])) {
      $this->setText($_REQUEST["text"]);
      return parent::show();
    } else {
      return parent::show();
    }
  }
  

}

class Checkbox extends Tag {
  public function __construct() {
    parent::__construct("input");
    $this->setAttr("type","checkbox");
  }

  public function open() {
    if($_REQUEST[$this->tag] == "on") {
      $this->setAttr("checked");
    }
    return parent::open();
    }

}

class RadioButton extends Tag {
  public function __construct() {
    parent::__construct("input");
    $this->setAttr("type","radio");
  }

}

class Select extends Tag {

  private $option_arr=[];

  public function __construct() {
    parent::__construct("select");
  }

  public function addOption(Option $option) {
    $this->option_arr[]=$option;
    // var_dump($this->option_arr);
    return $this;
  }

  public function show() {
    for($i=0;$i<count($this->option_arr);$i++) {
      $result .= $this->option_arr[$i]->show();
    }
    return $this->open() . $result . $this->close();

  }
}

class Option extends Tag {
  public function __construct() {
    parent::__construct("option");
  }
}


// $form=new Form();
// echo $form
//   ->setAttr("action","PHP-test.php")
//   ->setAttr("method","GET")
//   ->open();

// echo((new Select())->setAttr("name","list"))
//   ->addOption((new Option())->setText("item1"))
//   ->addOption((new Option())->setText("item2")->setAttr("selected"))
//   ->addOption((new Option())->setText("item3"))
//   ->show();

// echo(new Input("submit"))->open();


// echo $form->close();


// var_dump($_SERVER["QUERY_STRING"]);
// var_dump($_REQUEST);
// var_dump($form->attrs);
// var_dump($input->getAttr("name"));`