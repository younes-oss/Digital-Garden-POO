<?php

include_once 'User.php';

 class Gardener extends User {

    public function __construct($id, $username, $email, $password)
    {
        return parent::__construct($id, $username, $email, $password);
    }

    

}




?>