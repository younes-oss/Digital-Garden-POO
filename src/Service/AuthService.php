<?php
session_start();
include_once "../src/Repository/UserRepository.php";
include_once "../src\Entity\User.php";

$error = [];
$userRepo = new UserRepository();

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["type"] === "login") {
    $login = trim($_POST["login"]);
    $password = $_POST["password"];

    if (empty($login) || empty($password)) {
        $error[] = "All fields are required";
     } else {
        $user = $userRepo->findByEmail($login);
        $isAdmin = false;
        if(!is_null($user)){

            if (password_verify($password, $user->password)) {

                $_SESSION["user_id"] = $user->id;
                $_SESSION["username"] = $user->username;
                $_SESSION["login_time"] = time();

                
                $isAdmin = in_array('admin', $user->roles);

                if($isAdmin){
                header("Location: ../admin/dashboard.php");
                
             }
             else{
                header("Location: ../public/dashboard.php");
             }
             exit;
            }

            } else {
                $error[] = "Invalid credentials";
            }

             
        }
     }


if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["type"] === "register") {

    $errors = [];

    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm  = $_POST["confirm"];

    // Validation
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match";
    }

    // Check if email already exists
    if ($userRepo->findByEmail($email)) {
        $errors[] = "Email already registered";
    }

    // If validation passes
    if (empty($errors)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new Gardener(null,$username,$email,$hashedPassword);
        $userId = $userRepo->saveUser($user);

        if ($userId) {

            // Auto-login after register
            $_SESSION["user_id"] = $userId;
            $_SESSION["username"] = $username;
            $_SESSION["login_time"] = time();

            header("Location: ../public/dashboard.php");
            exit;

        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}



