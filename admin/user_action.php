<?php
session_start();

require_once '../src/Repository/UserRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = $_POST['user_id'];
    $action = $_POST['action'];

    $userRepo = new UserRepository();

    if ($action === 'approve') {
        $userRepo->updateStatus($userId, 'approved');
    }

    if ($action === 'block') {
        $userRepo->updateStatus($userId, 'blocked');
    }

    header('Location: dashboard.php');
    exit;
}
