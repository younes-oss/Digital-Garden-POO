<?php

abstract class User {
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $status;
    protected $created_at;
    protected $roles=[];
    protected const WAITING_STATUS = 'waiting';
    protected const APPROVED_STATUS = 'approved';
    protected const BLOCKED_STATUS = 'blocked';

    public function __construct($id,$username,$email,$password,$status = self::WAITING_STATUS)
    {   
        $now = new DateTime();
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $now->format("Y-m-d H:i:s");
        $this->status = $status;
    }

    public function addRole($role){
        array_push($this->roles,$role);
    }

}



?>