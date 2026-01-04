<?php

class Note{

    private $id;
    private $title;
    private $content;
    private $importance;
    private $created_at;
    private $theme_id;


    public function __construct($id,$title,$content,$importance,$theme_id)
    {
       $this->id =$id;
       $this->title = $title;
       $this->content = $content;
       $this->importance = $importance;
       $this->theme_id = $theme_id;

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