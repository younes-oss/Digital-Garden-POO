<?php
require_once '../Entity/Note.php';
session_start();

require_once 'C:\laragon\www\Digital-Garden-POO\config\Database.php';
require_once '../Entity/Note.php';
require_once '../Entity/Theme.php';
include_once "../Repository/ThemeRepository.php";
include_once "../Repository/NoteRepository.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$themeRepo = new ThemeRepository();
$noteRepo  = new NoteRepository();

$feature = $_POST['feature'] ?? null;
$action  = $_POST['action'] ?? null;

//THEMES

if ($feature === 'theme') {

    // CREATE / UPDATE
    if ($action === 'save') {

        if (empty($_POST['name'])) {
            die("Theme name is required");
        }

        $theme = new Theme(
            $_POST['id'] ?? null,
            $_POST['name'],
            $_POST['color'] ?? '#22c55e',
            $userId
        );

        $themeRepo->save($theme);

        header("Location: ../../public/themes.php");
        exit;
    }

    // DELETE
    if ($action === 'delete') {

        $theme = new Theme(
            $_POST['id'],
            null,
            null,
            $userId
        );

        $themeRepo->delete($theme);

        header("Location: ../../public/themes.php");
        exit;
    }
}

//NOTES

if ($feature === 'note') {

    // CREATE / UPDATE
    if ($action === 'save') {

        if (empty($_POST['title']) || empty($_POST['content'])) {
            die("Title and content are required");
        }

        $note = new Note(
            $_POST['id'] ?? null,
            $_POST['title'],
            $_POST['content'],
            $_POST['importance'],
            $_POST['theme_id'],
        );

        $noteRepo->save($note, $userId);

        header("Location: ../../public/notes.php");
        exit;
    }

    // DELETE
    if ($action === 'delete') {

        $noteRepo->delete($_POST['id'], $userId);

        header("Location: ../../public/notes.php");
        exit;
    }
    if ($action === 'filter') {

        if (!empty($_POST['theme_id'])) {
            
            $notes = $noteRepo->getByTheme($_POST['theme_id'], $userId);
            // var_dump($notes);
            // exit(0);
            $_SESSION['notes'] = $notes;
        }
        
        header("Location: ../../public/notes.php");
        exit;
    }

    if ($action === 'share') {

        $_SESSION['share'] = [
                'note_id' => $_POST['noteId']
            ];
        
        header("Location: ../../public/notes.php");
        exit;
    }
    if ($action === 'closeModal') {

        unset($_SESSION['share']);
        
        header("Location: ../../public/notes.php");
        exit;
    }
    if ($action === 'submitShare') {
        unset($_SESSION['share']);
        $noteId = $_POST['note_id'];
        $note = $noteRepo->getOne($noteId);
        $users = $_POST['users'];
        foreach ($users as $userId) {
            $noteRepo->share($note->id, $userId, $_SESSION['user_id']);
        }
        header("Location: ../../public/notes.php");
        exit;
    }

}
