<?php

class Theme{
     private $id;
     private $name;
     private $color;
     private $user_id;


     public function __construct($id,$name,$color,$user_id){
      $this->id =$id;
      $this->name=$name;
      $this->color=$color;
      $this->user_id=$user_id;

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