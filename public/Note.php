<!DOCTYPE html>
<html>
<head>
    <title>My Notes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen p-8">

<div class="max-w-5xl mx-auto">

<h1 class="text-3xl font-bold text-green-600 mb-6">🍃 My Notes</h1>

<!-- filters -->
<form method="GET" class="bg-white p-4 rounded-xl shadow mb-6 grid md:grid-cols-4 gap-4">

    <select name="theme_id" class="border rounded px-3 py-2">
        <option value="">All Themes</option>
        
            <option value="<?= $t["id"] ?>" <?= $theme_id == $t["id"] ? "selected" : "" ?>>
                <?= htmlspecialchars($t["name"]) ?>
            </option>

    </select>

    <select name="importance" class="border rounded px-3 py-2">
        <option value="">All Importance</option>
       
            <option value="" >
                Importance 
            </option>
       
    </select>

    <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>"
           placeholder="Search..."
           class="border rounded px-3 py-2">

    <button class="bg-green-600 text-white rounded-lg px-4 py-2">
        Filter
    </button>
</form>

<a href="create.php"
   class="inline-block mb-4 bg-green-600 text-white px-4 py-2 rounded-lg">
   ➕ Add Note
</a>


    <p class="text-gray-600">No notes found.</p>

<div class="space-y-4">

    <div class="bg-white p-5 rounded-xl shadow">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold">
               
            </h3>
            <span class="text-sm text-gray-500">
               
            </span>
        </div>

        <p class="text-gray-600 mt-2">
        </p>

        <div class="mt-3 flex justify-between items-center">
            <div class="text-sm">
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                    <?= $note["theme_name"] ?>
                </span>
                <span class="ml-2 bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                    Importance <?= $note["importance"] ?>
                </span>
            </div>

            <div class="space-x-2">
                <a href="">Edit</a>
                <a href=""
                   class="text-red-600">
                   Delete
                </a>
            </div>
        </div>
    </div>

</div>


<a href="public/dashboard.php" class="inline-block mt-6 text-green-600">
    ← Back to dashboard
</a>

</div>
</body>
</html>