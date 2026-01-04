<?php
session_start();

include_once "../src/Repository/ThemeRepository.php";
include_once "../src/Entity/Theme.php";


if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.php");
    exit;
}

$errors = [];
$themeRepo = new ThemeRepository();


if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["type"] === "add") {

    $name  = trim($_POST["name"]);
    $color = trim($_POST["color"]);

    if (empty($name) || empty($color)) {
        $errors[] = "All fields are required";
    } else {
        $theme = new Theme(
            null,
            $name,
            $color,
            $_SESSION["user_id"]
        );

        if (!$themeRepo->save($theme)) {
            $errors[] = "Failed to add theme";
        } else {
            header("Location: ../public/themes.php");
            exit;
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["type"] === "update") {

    $id    = $_POST["id"];
    $name  = trim($_POST["name"]);
    $color = trim($_POST["color"]);

    if (empty($id) || empty($name) || empty($color)) {
        $errors[] = "All fields are required";
    } else {
        $theme = new Theme(
            $id,
            $name,
            $color,
            $_SESSION["user_id"]
        );

        if (!$themeRepo->save($theme)) {
            $errors[] = "Failed to update theme";
        } else {
            header("Location: ../public/themes.php");
            exit;
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["delete"])) {

    $id = $_GET["delete"];

    if (!empty($id)) {
        $theme = new Theme(
            $id,
            null,
            null,
            $_SESSION["user_id"]
        );

        $themeRepo->delete($theme);
    }

    header("Location: ../public/themes.php");
    exit;
}
