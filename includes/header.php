<?php
require_once '../src/Repository/UserRepository.php';

    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}
$repo = new UserRepository();
$user = $repo->findById($_SESSION['user_id']);
$isAdmin = in_array("admin", $user->roles);

?>

<header class="bg-white shadow mb-8">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- LOGO -->
        <a href="../public/dashboard.php"
           class="flex items-center space-x-2 text-green-600 font-bold text-xl">
            <span class="text-2xl">🌱</span>
            <span>Digital Garden</span>
        </a>

        <!-- NAV -->
         
        <nav class="flex items-center space-x-6 text-gray-600 font-medium">
            <?php if(!$isAdmin && $user->status === "approved" ) : ?>
                <a href="../public/themes.php"
               class="hover:text-green-600 transition">
                Themes
            </a>

            <a href="../public/notes.php"
               class="hover:text-green-600 transition">
                Notes
            </a>
            <?php endif ?>
            <!-- LOGOUT -->
            <form method="POST" action="../public/logout.php">
                <button
                    class="bg-red-500 text-white px-4 py-2 rounded-lg
                           hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
        </nav>

    </div>
</header>
