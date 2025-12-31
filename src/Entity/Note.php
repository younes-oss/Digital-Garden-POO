<?php

class Note{

    private $id;
    private $title;
    private $content;
    private $importance;
    private $created_at;


    public function __construct($id,$title,$content,$importance)
    {
       $this->title = $title;
       $this->content = $content;
       $this->importance = $importance;

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