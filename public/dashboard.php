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
            🌱 Bienvenue <?= htmlspecialchars($user["username"]) ?>
        </h1>

        <p class="text-gray-600 mb-4">
            Date d’inscription :
            <span class="font-medium">
                <?= date("d/m/Y", strtotime($user["created_at"])) ?>
            </span>
        </p>

        <p class="text-gray-600 mb-8">
            Heure de connexion :
            <span class="font-medium">
                <?= $_SESSION["login_time"] ?>
            </span>
        </p>

        <div class="space-y-4">

            <a href="../themes/index.php"
               class="block w-full bg-green-600 text-white py-3 rounded-lg font-semibold
                      hover:bg-green-700 transition">
                🌱 Gérer mes Thèmes
            </a>

            <a href="../notes/index.php"
               class="block w-full bg-blue-600 text-white py-3 rounded-lg font-semibold
                      hover:bg-blue-700 transition">
                🍃 Gérer mes Notes
            </a>

            <a href="logout.php"
               class="block w-full bg-red-500 text-white py-3 rounded-lg font-semibold
                      hover:bg-red-600 transition">
                🚪 Déconnexion
            </a>

        </div>

    </div>

</body>
</html>