<?php
session_start();

require_once '../src/Repository/UserRepository.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


$userRepo = new UserRepository();
$user = $userRepo->findById($_SESSION['user_id']);


if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Digital Garden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-green-50 flex items-center justify-center">

<div class="bg-white w-full max-w-xl p-8 rounded-2xl shadow-lg text-center">

    <h1 class="text-3xl font-bold text-green-600 mb-2">
        🌱 Bienvenue <?= htmlspecialchars($user->username) ?>
    </h1>

    <p class="text-gray-600 mb-4">
        Date d’inscription :
        <span class="font-medium">
            <?= date("d/m/Y", strtotime($user->created_at)) ?>
        </span>
    </p>

    <p class="text-gray-600 mb-8">
        Heure de connexion :
        <span class="font-medium">
            <?= date("H:i:s", $_SESSION["login_time"]) ?>
        </span>
    </p>

    <?php if ($user->status === 'blocked'): ?>

        <div class="bg-red-100 text-red-700 p-4 rounded-lg font-semibold">
            🚫 Votre compte a été bloqué par un administrateur.
        </div>

    <?php elseif ($user->status === 'waiting'): ?>

        <div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg font-semibold">
            ⏳ Votre compte est en attente de validation par un administrateur.
        </div>

    <?php else: ?>

        <div class="space-y-4">
            <a href="theme.php"
               class="block w-full bg-green-600 text-white py-3 rounded-lg font-semibold
                      hover:bg-green-700 transition">
                🌱 Gérer mes Thèmes
            </a>

            <a href="Note.php"
               class="block w-full bg-blue-600 text-white py-3 rounded-lg font-semibold
                      hover:bg-blue-700 transition">
                🍃 Gérer mes Notes
            </a>
        </div>

    <?php endif; ?>

    <a href="logout.php"
       class="block w-full mt-6 bg-red-500 text-white py-3 rounded-lg font-semibold
              hover:bg-red-600 transition">
        🚪 Déconnexion
    </a>

</div>

</body>
</html>