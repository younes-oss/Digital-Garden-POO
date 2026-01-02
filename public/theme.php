<!DOCTYPE html>
<html>

<head>
    <title>My Themes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50 min-h-screen p-8">

    <div class="max-w-4xl mx-auto">

        <h1 class="text-3xl font-bold text-green-600 mb-6">
            🌱 My Themes
        </h1>

        <!-- ➕ Add Theme -->
        <form method="POST" class="bg-white p-6 rounded-xl shadow mb-8">
            <h2 class="text-xl font-semibold mb-4">Add Theme</h2>

            <div class="mb-4">
                <input type="text" name="name" placeholder="Theme name"
                    class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <input type="color" name="color" value="#22c55e"
                    class="w-20 h-10 border rounded">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Tags (optional)</label>
                <input type="text" name="tags"
                    placeholder="work, ideas, personal"
                    class="w-full mb-4 border px-3 py-2 rounded
              focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Add
            </button>
        </form>

      
        
            <p class="text-gray-600">No themes created yet.</p>
            <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-xl shadow flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold"><?= htmlspecialchars($theme["name"]) ?></h3>
                            <span class="inline-block mt-1 px-3 py-1 text-white text-sm rounded">
                                notes
                            </span>
                            
                                <div class="flex flex-wrap gap-2 mt-2">
                    
                                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">
                                            
                                        </span>
                                   
                                </div>
                            
                        </div>

                        <div class="space-x-2">
                            <a href="edit.php?id=<?= $theme["id"] ?>"
                                class="text-blue-600 hover:underline">
                                Edit
                            </a>
                            <a href="delete.php?id=<?= $theme["id"] ?>"
                                class="text-red-600 hover:underline"
                                onclick="return confirm('Delete this theme?')">
                                Delete
                            </a>
                        </div>
                    </div>
               
            </div>

        <a href="public/dashboard.php"
            class="inline-block mt-6 text-green-600 hover:underline">
            ← Back to dashboard
        </a>

    </div>
</body>

</html>