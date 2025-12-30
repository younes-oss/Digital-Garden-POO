<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'garden';
    private $username = 'root';
    private $password = '';

    public function connect(){
        try{
            $conn = new PDO('mysql:host=localhost;dbname=garden',$this->username , $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch (PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
            

    }

}

?>