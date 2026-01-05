<?php

require_once "./config/Database.php";
require_once "./src/Entity/User.php";
require_once "./src/Entity/Gardener.php";
require_once "./src/Entity/Admin.php";

class UserRepository
{

    private PDO $conn;


    public function __construct()
    {

        $this->conn = (new Database())->connect();
    }

    public function saveUser($user)
{
    // insert user
    $stmtUser = $this->conn->prepare(
        "INSERT INTO users (username, email, password)
         VALUES (:username, :email, :password)"
    );

    if (!$stmtUser->execute([
        'username' => $user->username,
        'email'    => $user->email,
        'password' => $user->password
    ])) {
        return false;
    }

    $userId = $this->conn->lastInsertId();

    // get gardener role id
    $stmtRole = $this->conn->prepare(
        "SELECT id FROM roles WHERE title = 'gardener' LIMIT 1"
    );
    $stmtRole->execute();

    $roleId = $stmtRole->fetchColumn();

    // insert into user_role
    $stmtPivot = $this->conn->prepare(
        "INSERT INTO user_role (user_id, role_id)
         VALUES (:user_id, :role_id)"
    );

    if (!$stmtPivot->execute([
        'user_id' => $userId,
        'role_id' => $roleId
    ])) {
        return false;
    }

    return $userId;
}


    public function findByEmail($email)
    {
        $sql = "
        SELECT u.*, r.title AS role
        FROM users u
        LEFT JOIN user_role ur ON u.id = ur.user_id
        LEFT JOIN roles r ON r.id = ur.role_id
        WHERE u.email = :email
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        // Create user from first row
        $user = $this->rowToEntity($rows[0]);

        // Add roles
        foreach ($rows as $row) {
            if ($row['role']) {
                $user->addRole($row['role']);
            }
        }

        return $user;
    }

    public function findById($id)
    {
        $sql = "
        SELECT u.*, r.title AS role
        FROM users u
        LEFT JOIN user_role ur ON u.id = ur.user_id
        LEFT JOIN roles r ON r.id = ur.role_id
        WHERE u.id = :id
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        $user = $this->rowToEntity($rows[0]);

        foreach ($rows as $row) {
            if ($row['role']) {
                $user->addRole($row['role']);
            }
        }

        return $user;
    }



    public function findAll()
    {
        $sql = "SELECT u.*, r.title AS role
                FROM users u
                JOIN user_role ur ON u.id = ur.user_id
                JOIN roles r ON r.id = ur.role_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $array_users = [];

        foreach ($results as $result) {

            array_push($array_users, $this->rowToEntity($result));
        }
        return $array_users;
    }

    public function getGardeners()
    {
        $sql = "SELECT u.*, r.title AS role
                FROM users u
                JOIN user_role ur ON u.id = ur.user_id
                JOIN roles r ON r.id = ur.role_id
                where r.title = 'gardener'
    ";

        $stmt = $this->conn->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];

        foreach ($rows as $row) {
            $users[] = $this->rowToEntity($row);
        }

        return $users;
    }

    public function updateStatus($userId, $status)
    {
        $stmt = $this->conn->prepare(
            "UPDATE users SET status = :status WHERE id = :id"
        );

        return $stmt->execute([
            'status' => $status,
            'id' => $userId
        ]);
    }


    public function rowToEntity(array $row)
    {
        if (isset($row['role']) && $row['role'] === 'admin') {
            return new Admin(
                $row['id'],
                $row['username'],
                $row['email'],
                $row['password'],
                $row['status']
            );
        }

        return new Gardener(
            $row['id'],
            $row['username'],
            $row['email'],
            $row['password'],
            $row['status']
        );
    }
}
