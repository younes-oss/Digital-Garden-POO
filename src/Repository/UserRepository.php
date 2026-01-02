<?php

require_once "./config/Database.php";
require_once "./src/Entity/User.php";
require_once "./src/Entity/Gardener.php";

class UserRepository{

    private PDO $conn;


    public function __construct(){

        $this->conn = (new Database())->connect();
    }

    public function saveUser(User $user){

        $sql = "INSERT into users(username,email,password) Values(:nom , :email , :password)";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([":nom"=>$user->username , 
                        ":email"=>$user->email,
                        ":password"=>$user->password]);
    }

    public function findByEmail($email) : ?User{

        $sql = "SELECT * from users where email= :email";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([":email"=>$email]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result){
            return $this->rowToEntity($result);
        }else{
            return null;
        }
    }

    public function findAll() {
        $sql = "SELECT * from users";

        $stmt =$this->conn->prepare($sql);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO :: FETCH_ASSOC);

        $array_users = [] ;

        foreach($results as $result){
            
            array_push($array_users,$this->rowToEntity($result));
        }
        return $array_users;

    }

    public function rowToEntity(array $row) : User{
        return new Gardener($row["id"],
                        $row["username"],
                        $row["email"],
                        $row["password"],
                        $row["status"]);
    }
}


// $user1 =new Gardener(null,"younes","younes@gmail.com","1234");
$repo = new UserRepository();

var_dump($repo->findByEmail("younes@gmail.com"));

?>