<?php

require_once "../src/Service/AuthService.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | Digital Garden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-green-50">

    <div class="bg-white shadow-lg rounded-xl w-full max-w-md p-8">

        <h1 class="text-2xl font-bold text-center text-green-600 mb-6">
            🌱 Digital Garden
        </h1>

        <form method="POST" class="space-y-4">
            <input hidden type="text" name="type" value="login">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Username or Email
                </label>
                <input type="text" name="login"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input type="password" name="password"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                    required>
            </div>

            <?php if (!empty($error)): ?>
                <div class="text-red-600 text-sm bg-red-100 p-2 rounded">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Don’t have an account?
            <a href="register.php" class="text-green-600 font-medium hover:underline">
                Sign up
            </a>
        </p>
    </div>

</body>

</html>