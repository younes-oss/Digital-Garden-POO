<?php

class Theme{
     private $id;
     private $name;
     private $color;


     public function __construct($id,$name,$color){
        $this->name=$name;
        $this->color=$color;

     }

     public function __get($property) {
        return $this->$property;
     }

     public function __set($name, $value)
     {
        $this->$name = $value;
     }



}
?>