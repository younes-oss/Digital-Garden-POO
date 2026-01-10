<?php
require_once "../src/Entity/Note.php";
if (!isset($_SESSION['share'])) return;

require_once "../src/Repository/UserRepository.php";

$userRepo = new UserRepository();
$users = $userRepo->getGardeners(); // only gardeners

    $noteId = $_SESSION["share"]["note_id"];
?>

<!-- OVERLAY -->
<div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">

    <!-- MODAL -->
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-green-600">
                🌱 Share Note
            </h2>

        </div>

        <!-- USERS LIST -->
        <form method="POST" action="../src/Service/GardenService.php"
            class="space-y-4">

            <input type="hidden" name="feature" value="note">
            <input type="hidden" name="action" value="share">
            <input type="hidden" name="note_id" value="<?= $noteId ?>">

            <div class="max-h-60 overflow-y-auto space-y-3">

                <?php foreach ($users as $user): ?>
                    <label class="flex items-center gap-3 p-3 rounded-lg
                                  border hover:bg-green-50 cursor-pointer">

                        <input type="checkbox"
                            name="users[]"
                            value="<?= $user->id ?>"
                            class="w-4 h-4 text-green-600 rounded">

                        <div>
                            <p class="font-medium"><?= htmlspecialchars($user->username) ?></p>
                            <p class="text-sm text-gray-500"><?= $user->email ?></p>
                        </div>
                    </label>
                <?php endforeach; ?>

            </div>

            <!-- ACTIONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="submit" name="action" value="closeModal"
                    class="px-4 py-2 rounded-lg border hover:bg-gray-100">
                    Cancel
                </button>

                <button type="submit" name="action" value="submitShare"
                    class="bg-green-600 text-white px-5 py-2 rounded-lg
                           hover:bg-green-700">
                    Share
                </button>
            </div>

        </form>
    </div>
</div>