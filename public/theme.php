<?php
session_start();

require_once "../config/Database.php";
require_once "../src/Entity/Theme.php";
require_once "../src/Repository/ThemeRepository.php";


$themeRepo = new ThemeRepository();
$themes = $themeRepo->getAllByUser($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Themes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50">
    <?php
    require_once "../includes/header.php";
    ?>
    <div class="bg-green-50 min-h-screen p-8">
        <div class="max-w-4xl mx-auto">

        <h1 class="text-3xl font-bold text-green-600 mb-6">🌱 My Themes</h1>

        <!-- ADD THEME -->
        <form method="POST" action="../src/service/gardenService.php"
            class="bg-white p-6 rounded-xl shadow mb-8">

            <input type="hidden" name="feature" value="theme">
            <input type="hidden" name="action" value="save">

            <input type="text" name="name" required
                placeholder="Theme name"
                class="w-full mb-4 px-4 py-2 border rounded-lg">

            <input type="color" name="color" value="#22c55e"
                class="w-20 h-10 border rounded mb-4">

            <button class="bg-green-600 text-white px-6 py-2 rounded-lg">
                Add
            </button>
        </form>

        <?php if (empty($themes)): ?>
            <p class="text-gray-600">No themes created yet.</p>
        <?php else: ?>
            <div class="grid md:grid-cols-2 gap-4">
                <?php foreach ($themes as $theme): ?>
                    <div class="p-5 rounded-xl bg-[<?= $theme->color ?>]/40 shadow flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold"><?= htmlspecialchars($theme->name) ?></h3>
                        </div>

                        <!-- DELETE -->
                        <form method="POST" action="../src/service/gardenService.php"
                            onsubmit="return confirm('Delete this theme?')">

                            <input type="hidden" name="feature" value="theme">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $theme->id ?>">

                            <button class="text-red-600">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <a href="dashboard.php"
            class="inline-block mt-6 text-green-600">← Back</a>

    </div>
    </div>
    <div class="max-w-4xl mx-auto">

        <h1 class="text-3xl font-bold text-green-600 mb-6">🌱 My Themes</h1>

        <!-- ADD THEME -->
        <form method="POST" action="../src/service/gardenService.php"
            class="bg-white p-6 rounded-xl shadow mb-8">

            <input type="hidden" name="feature" value="theme">
            <input type="hidden" name="action" value="save">

            <input type="text" name="name" required
                placeholder="Theme name"
                class="w-full mb-4 px-4 py-2 border rounded-lg">

            <input type="color" name="color" value="#22c55e"
                class="w-20 h-10 border rounded mb-4">

            <button class="bg-green-600 text-white px-6 py-2 rounded-lg">
                Add
            </button>
        </form>

        <?php if (empty($themes)): ?>
            <p class="text-gray-600">No themes created yet.</p>
        <?php else: ?>
            <div class="grid md:grid-cols-2 gap-4">
                <?php foreach ($themes as $theme): ?>
                    <div class="p-5 rounded-xl bg-[<?= $theme->color ?>]/40 shadow flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold"><?= htmlspecialchars($theme->name) ?></h3>
                        </div>

                        <!-- DELETE -->
                        <form method="POST" action="../src/service/gardenService.php"
                            onsubmit="return confirm('Delete this theme?')">

                            <input type="hidden" name="feature" value="theme">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $theme->id ?>">

                            <button class="text-red-600">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <a href="dashboard.php"
            class="inline-block mt-6 text-green-600">← Back</a>

    </div>
</body>

</html>