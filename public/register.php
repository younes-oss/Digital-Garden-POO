<?php

require_once "../src/Service/AuthService.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Digital Garden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-green-50">

<div class="bg-white w-full max-w-md p-8 rounded-xl shadow-lg">

    <h1 class="text-2xl font-bold text-center text-green-600 mb-6">
        🌱 Create Account
    </h1>

    <form method="POST" class="space-y-4">
        <input hidden type="text" name="type" value="register">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Username
            </label>
            <input type="text" name="username" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Email
            </label>
            <input type="email" name="email" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Password
            </label>
            <input type="password" name="password" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Confirm Password
            </label>
            <input type="password" name="confirm" required
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400">
        </div>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 text-red-600 p-3 rounded text-sm">
                <ul class="list-disc pl-5">
                    <?php foreach ($errors as $err): ?>
                        <li><?= $err ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition">
            Register
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
        Already have an account?
        <a href="login.php" class="text-green-600 hover:underline">
            Login
        </a>
    </p>
</div>

</body>
</html>