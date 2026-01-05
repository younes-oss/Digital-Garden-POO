<?php
require_once "../src/Entity/Note.php";
session_start();

require_once "../config/Database.php";

require_once "../src/Repository/NoteRepository.php";
require_once "../src/Entity/Theme.php";
require_once "../src/Repository/ThemeRepository.php";


$userId = $_SESSION['user_id'];

$noteRepo  = new NoteRepository();
$themeRepo = new ThemeRepository();

$themes = $themeRepo->getAllByUser($userId);

if (isset($_SESSION['notes'])) {
    $notes = $_SESSION['notes'];
} else {
    $notes = $noteRepo->getAllByUser($userId);
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>My Notes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>



<body class="bg-green-50">
    <?php
    require_once "../includes/header.php";
    ?>
    <div class="bg-green-50 min-h-screen p-8">
        <div class="max-w-5xl mx-auto ">

            <h1 class="text-3xl font-bold text-green-600 mb-6">🍃 My Notes</h1>

            <!-- FILTER -->
            <form method="POST" action="../src/service/gardenService.php"
                class="bg-white p-4 rounded-xl shadow mb-6 grid md:grid-cols-4 gap-4">
                <input type="hidden" name="feature" value="note">
                <input type="hidden" name="action" value="filter">
                <select name="theme_id" class="border rounded px-3 py-2">
                    <option value="">All Themes</option>
                    <?php foreach ($themes as $t): ?>
                        <option value="<?= $t->id ?>"
                            <?= ($_POST['theme_id'] ?? '') == $t->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button id="filter" class="bg-green-600 text-white rounded-lg px-4 py-2">
                    Filter
                </button>
            </form>

            <!-- add -->
            <form method="POST" action="../src/service/gardenService.php"
                class="bg-white p-6 rounded-xl shadow">

                <input type="hidden" name="feature" value="note">
                <input type="hidden" name="action" value="save">

                <input type="text" name="title"
                    class="w-full mb-4 border px-3 py-2 rounded"
                    placeholder="Title" required>

                <textarea name="content"
                    class="w-full mb-4 border px-3 py-2 rounded"
                    placeholder="Content" required></textarea>

                <select name="theme_id"
                    class="w-full mb-4 border px-3 py-2 rounded" required>
                    <?php foreach ($themes as $t): ?>
                        <option value="<?= $t->id ?>"><?= htmlspecialchars($t->name) ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="importance"
                    class="w-full mb-4 border px-3 py-2 rounded">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>">Importance <?= $i ?></option>
                    <?php endfor; ?>
                </select>

                <button class="bg-green-600 text-white px-6 py-2 rounded">
                    Save Note
                </button>
            </form>


            <?php if (empty($notes)): ?>
                <p class="text-gray-600">No notes found.</p>
            <?php endif; ?>

            <div class="space-y-4">
                <?php foreach ($notes as $note): ?>
                    <div class="bg-white p-5 rounded-xl shadow">

                        <h3 class="font-semibold"><?= htmlspecialchars($note->title) ?></h3>
                        <p class="text-gray-600 mt-2"><?= htmlspecialchars($note->content) ?></p>

                        <div class="mt-3 flex justify-between items-center">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                Importance <?= $note->importance ?>
                            </span>

                            <!-- DELETE -->
                            <form method="POST" action="../src/service/gardenService.php">
                                <input type="hidden" name="feature" value="note">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $note->id ?>">
                                <button class="text-red-600">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <a href="../public/dashboard.php"
                class="inline-block mt-6 text-green-600">← Back</a>

        </div>
    </div>
    <script>
        window.addEventListener('beforeunload', () => {
            <?php unset($_SESSION['notes']) ?>
        })
    </script>
</body>

</html>