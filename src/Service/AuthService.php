<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["type"] === "login") {
    $login = trim($_POST["login"]);
    $password = $_POST["password"];

    if (empty($login) || empty($password)) {
        $error = "All fields are required";
     } else {

        $userRepo = new UserRepository();
        $user = $userRepo->findByEmail($login);
        $isAdmin = false;
        if(!is_null($user)){

            if (password_verify($password, $user->password)) {

                $_SESSION["user_id"] = $user->id;
                $_SESSION["username"] = $user->username;
                $_SESSION["login_time"] = time();

                foreach ($user->roles as $role) {
                if($role->title === "admin") $isAdmin = true;

                if($isAdmin){
                header("Location: ../admin/dashboard.php");
                
             }
             else{
                header("Location: ../public/dashboard.php");
             }
             exit;
            }

            } else {
                $error = "Invalid credentials";
            }

             
        }
     }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["type"] === "register") {
    echo '<h1>register</h1>';
    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm  = $_POST["confirm"];

    //validation
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

    //Check if username or email already exists
    // if (empty($errors)) {
    //     $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
    //     $stmt = mysqli_prepare($conn, $sql);
    //     mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    //     mysqli_stmt_execute($stmt);
    //     mysqli_stmt_store_result($stmt);

    //     if (mysqli_stmt_num_rows($stmt) > 0) {
    //         $errors[] = "Username or email already exists";
    //     }
    // }

    // //Insert user
    // if (empty($errors)) {
    //     $hashed = password_hash($password, PASSWORD_DEFAULT);

    //     $sql = "INSERT INTO users (username, email, password)
    //             VALUES (?, ?, ?)";
    //     $stmt = mysqli_prepare($conn, $sql);
    //     mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed);

    //     if (mysqli_stmt_execute($stmt)) {
    //         $_SESSION["user_id"] = mysqli_insert_id($conn);
    //         $_SESSION["username"] = $username;
    //         $_SESSION["login_time"] = date("Y-m-d H:i:s");

    //         header("Location: dashboard.php");
    //         exit;
    //     } else {
    //         $errors[] = "Registration failed";
    //     }
    // }
}

