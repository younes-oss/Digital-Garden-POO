<?php

abstract class User {
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $status;
    protected $created_at;
    protected $roles=[];

    public function __construct($id,$username,$email,$password)
    {   
        $now = new DateTime();
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->status = "waiting";
        $this->created_at = $now->format("Y-m-d H:i:s");
    }

    public function addRole($role){
        array_push($this->roles,$role);
    }

}




?>