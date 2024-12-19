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
$taskManager = TaskManager::getInstance();
$programmers = $taskManager->getAllProgrammers(); // Fetch all programmers

$assignedProgrammerName = '';
foreach ($programmers as $programmer) {
    if ($programmer['id_programmer'] == $task['programmer_id']) {
        $assignedProgrammerName = $programmer['programmer_name'];
        break;
    }
}
?>

<div class="rajdhani-light" style="margin: 10px;">
    <!-- Display Task Fields -->
    <p><b>Task ID:</b> <?= htmlspecialchars($task['id_task']); ?></p>
    <p><b>Task Description:</b> <?= htmlspecialchars($task['task_description']); ?></p>
    <p><b>Assigned Programmer:</b> <?= htmlspecialchars("ID : " . $task['programmer_id'] . " | $assignedProgrammerName"); ?></p>
    <p><b>Current Status:</b> <?= htmlspecialchars($task['task_status']); ?></p>
</div>

<!-- Update Programmer Form : I DO NOT WANT TO CHANGE PROJECT OR DESCRIPTION, IT MAKES NO SENSE-->
<form action="<?php echo WEB_ROOT; ?>/task/update" method="POST">
    <div class="rajdhani-light" style="margin-bottom: 10px;">
        <label for="assigned_programmer" class="rajdhani-light">Reassign Programmer:</label>
        <select id="assigned_programmer" name="assigned_programmer" class="rajdhani-light" required>
            <?php foreach ($programmers as $programmer): ?>
                <option value="<?= $programmer['id_programmer']; ?>" <?= $programmer['id_programmer'] == $task['programmer_id'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($programmer['programmer_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <input type="hidden" name="id_task" value="<?= htmlspecialchars($task['id_task']); ?>">

    <div class="rajdhani-light" style="margin-bottom: 0px;">
        <button type="submit" class="rajdhani-light" style="padding: 10px 20px;">SAVE CHANGES</button>
    </div>
</form>

<!-- Advance Progress Form -->
<section style="margin-bottom: 5px;">
    <form action="<?php echo WEB_ROOT; ?>/task/advance" method="POST">
        <input type="hidden" name="id_task" value="<?= htmlspecialchars($task['id_task']); ?>">

        <div class="rajdhani-light" style="margin-bottom: 0px;">
            <button type="submit" name="advance_status" value="true" class="rajdhani-light" style="padding: 10px 20px;">ADVANCE PROGRESS</button>
        </div>
    </form>
</section>

