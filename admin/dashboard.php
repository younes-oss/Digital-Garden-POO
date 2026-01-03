<?php
session_start();

require_once '../src/Repository/UserRepository.php';

$userRepo = new UserRepository();
$gardeners = $userRepo->getGardeners();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-6xl mx-auto py-10 px-4">
    
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        🌱 Gardeners Management
    </h1>

    <?php if (empty($gardeners)): ?>
        <p class="text-gray-600">No gardeners found.</p>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($gardeners as $user): ?>

            <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        <?= htmlspecialchars($user->username) ?>
                    </h2>

                    <p class="text-sm text-gray-500 mb-3">
                        <?= htmlspecialchars($user->email) ?>
                    </p>

                    <span class="
                        inline-block px-3 py-1 text-sm font-medium rounded-full
                        <?php if ($user->status === 'waiting'): ?>
                            bg-yellow-100 text-yellow-700
                        <?php elseif ($user->status === 'approved'): ?>
                            bg-green-100 text-green-700
                        <?php else: ?>
                            bg-red-100 text-red-700
                        <?php endif; ?>
                    ">
                        <?= ucfirst($user->status) ?>
                    </span>
                </div>

                <div class="mt-6">
                    <?php if ($user->status === 'waiting'): ?>
                        <form method="post" action="user_action.php">
                            <input type="hidden" name="user_id" value="<?= $user->id ?>">
                            <input type="hidden" name="action" value="approve">
                            <button
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition">
                                Approve
                            </button>
                        </form>

                    <?php elseif ($user->status === 'approved'): ?>
                        <form method="post" action="user_action.php">
                            <input type="hidden" name="user_id" value="<?= $user->id ?>">
                            <input type="hidden" name="action" value="block">
                            <button
                                class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg transition">
                                Block
                            </button>
                        </form>

                    <?php else: ?>
                        <button
                            class="w-full bg-gray-300 text-gray-600 py-2 rounded-lg cursor-not-allowed">
                            Blocked
                        </button>
                    <?php endif; ?>
                </div>

            </div>

        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
                        