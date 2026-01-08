<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'garden';
    private $username = 'root';
    private $password = '';
    private static $instance = null;
    private $conn;

    public function __construct(){
        try{
            $this->conn = new PDO('mysql:host=localhost;dbname=garden',$this->username , $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }   

    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }

}

?>