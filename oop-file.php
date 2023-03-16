<?php

interface iFile {
  public function __construct(string $filename); // получить имя файла
  
  public function getPath(); // получить путь к файлу
  public function getDir(); // получить директорию, в которой находится файл
  public function getName(); // получить имя фала
  public function getExt(); // получить расширение файла
  public function getSize(); // получить размер файла

  public function getText(); // получить текст файла
  public function setText(string $text); // создает файл и устанавливает весь текст файла
  public function appendText(string $text); // добавляет текст в конец файла

  public function copy($pathFile); // копирует файл(куда?)
  public function delete($fileName); // удаляет файл
  public function rename($newName); // переименовывает файл
  public function replace($newPath); // перемещает файл
}
  
class File implements iFile {
  public $file_name;
  public $file_path;
  public $file_discr;
  public $file_info;

  public function __construct(string $filename) {
    $this->file_name=$filename;
    $this->file_path=realpath($filename);
    $this->file_discr=fopen($filename, "w+");
    $this->file_info=pathinfo(realpath($filename));
  }
  public function getPath() {
    return $this->file_info["dirname"];
  }
  public function getDir(){
  }
  public function getName(){
    return $this->file_name;
  }
  public function getExt(){
    return $this->file_info["extension"];
  }
  public function getSize(){
    return filesize($this->file_name);
  }
  public function getText(){
    return file_get_contents($this->file_name);
  }
  public function setText(string $text){
    file_put_contents($this->file_name, $text);
  }
  public function appendText(string $text){
    file_put_contents($this->file_name, $text, FILE_APPEND);
    fclose($this->file_discr);
  }
  public function copy($toCopyFileName){
    return copy($this->file_path, $toCopyFileName);
  }
  public function delete($fileName){
    return unlink($fileName);
  }
  public function rename($newName){
    rename($this->file_name, $newName);
    $this->file_name=$newName;
    $this->file_path=realpath($newName);
    $this->file_discr=fopen($newName, "r+");
    $this->file_info=pathinfo(realpath($newName));
  }
  public function replace($newPath) {
    copy($this->file_name, $newPath);
    unlink($this->file_name);
  }   
}

// $file=new File("test-file.txt");

class FileManipulator {

  public function create($filePath) {
    $this->filePath=$filePath;
    if(!file_exists($filePath)) {
      fopen($filePath,"w+");
    }
    return $this;
  }
  public function setText(string $text){
    file_put_contents($this->filePath, $text);
  }
  public function delete($filePath) {
      return unlink($filePath);
  }

  public function rename($newPath) {
    rename($this->filePath, $newPath); 
    $this->filePath=$newPath;
  }

}

// $file_m=new FileManipulator();

// $file_m->create("test.txt");
// $file_m->rename("New-test-1.txt");
// $file_m->rename("New-test-2.txt");




  