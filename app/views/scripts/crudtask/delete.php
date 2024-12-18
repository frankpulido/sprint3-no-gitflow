<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Nice for debugging... thanks Gepito!
?>

<?php
include __DIR__ . '../../../layouts/head.php';
require_once __DIR__ . '/../../../controllers/TaskController.php';
require_once __DIR__ . '/../../../models/task_manager.class.php';
// This class IS IN MODELS folder, but autoloader doesn't accept underscores
// All classes in MODELS folder are autoloaded (unless autoloader doesn't like them... e.g. having underscores)
?>

<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
} // Ensure session variables are accessible
$task = $_SESSION['selected_task'] ?? null; // Retrieve the selected task
?>

<form action="<?php echo WEB_ROOT; ?>/task/delete" method="POST">
    <!-- Delete Confirmation -->
    <div class="rajdhani-light" style="margin-bottom: 5px; display: flex; flex-direction: column; align-items: flex-start;">
        <p><b><?= htmlspecialchars("TASK ID:" . $task['id_task']); ?></b> - <?= htmlspecialchars($task['task_description']); ?></p>

        <label for="confirmation" class="rajdhani-light">CONFIRM DELETE:</label>
        <input type="text" id="confirmation" name="confirmation" placeholder="Type 'delete'" required>
    </div>

    <!-- Hidden ID Field -->
    <input type="hidden" name="id_task" value="<?= htmlspecialchars($task['id_task'] ?? ''); ?>">

    <!-- Submit Button -->
    <div class="rajdhani-light" style="margin-bottom: 5px;">
        <button type="submit" class="rajdhani-light" style="align-self: flex-start; padding: 10px 20px; margin: 0px 0px 20px 0px;">DELETE TASK</button>
    </div>
</form>
