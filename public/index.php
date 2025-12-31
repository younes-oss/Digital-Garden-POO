<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Digital Garden</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-green-100">

    <div class="bg-white p-10 rounded-2xl shadow-xl text-center max-w-lg w-full">

        <h1 class="text-4xl font-extrabold text-green-600 mb-4">
            🌱 Digital Garden
        </h1>

        <p class="text-gray-600 mb-8">
            Organize your thoughts, ideas, and projects in a calm and
            personal digital space.  
            Your garden, your rules.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="register.php"
               class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold
                      hover:bg-green-700 transition">
                Sign Up
            </a>

            <a href="login.php"
               class="px-6 py-3 border-2 border-green-600 text-green-600 rounded-lg
                      font-semibold hover:bg-green-50 transition">
                Login
            </a>
        </div>

    </div>

</body>
</html>