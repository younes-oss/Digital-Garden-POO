<?php

class Role{
    private $id;
    private $title;


    public function __construct($id,$title){

        $this->id=$id;
        $this->title=$title;
    }

    public function __get($property){
        return $this->$property;
    }

    public function __set($name, $value)
    {
        $this->$name=$value;
    }
}
?>