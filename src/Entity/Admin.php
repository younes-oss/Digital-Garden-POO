<?php

include_once 'User.php';

 class Admin extends User {

    public function __construct($id, $username, $email, $password)
    {
        return parent::__construct($id, $username, $email, $password);
        $this->status = parent::APPROVED_STATUS;
    }

    public static  function test(){

    }

}

$user = new Admin(3,'UII','gfhg',"jhg");
$user->test();

?>


