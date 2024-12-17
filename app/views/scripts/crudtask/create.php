<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// nice for debugging... thanks Gepito!!!
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
} // To retrieve the session variable that returns the Task created by TaskManager through the controller TaskController

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskController = new TaskController();
    $taskController->execute('create');
    exit(); // Optional: to avoid rendering the rest of create.php after execution
}

$taskManager = TaskManager::getInstance();
$projects = $taskManager->getAllProjects(); // Fetch existing projects through TaskManager
$programmers = $taskManager->getAllProgrammers(); // Fetch existing programmers through TaskManager
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="../../../../web/stylesheets/styles.css">
</head>

<body>

<h2 class="rajdhani-light" style="margin-left: 15px;">CREATE NEW TASK</h2>

<form action="<?php echo WEB_ROOT; ?>/task/create" method="post">
<!-- THE FORM ACTION POST TO ITSELF TO EXECUTE IF IN LINE 18 / IF REQUEST = POST THEN $taskController->execute('create'); -->

    <!-- Project Selection Dropdown -->
    <div class="rajdhani-light" style="margin-bottom: 5px;">
        <label for="project_id" class="rajdhani-light">PROJECT :</label>
        <select id="project_id" name="project_id" class="rajdhani-light" required>
            <?php
            // Fetch existing projects through TaskManager
            //$projects = $taskManager->getAllProjects();
            foreach ($projects as $project) {
                echo "<option value=\"{$project['id_project']}\">{$project['project_name']}</option>";
            }
            ?>
        </select>
    </div>

    <!-- Programmer Selection Dropdown -->
    <div class="rajdhani-light" style="margin-bottom: 5px;">
        <label for="programmer_id" class="rajdhani-light" >PROGRAMMER :</label>
        <select id="programmer_id" name="programmer_id" class="rajdhani-light" required>
            <?php
            // Fetch existing programmers through TaskManager
            //$programmers = $taskManager->getAllProgrammers();
            foreach ($programmers as $programmer) {
                echo "<option value=\"{$programmer['id_programmer']}\">{$programmer['programmer_name']}</option>";
            }
            ?>
        </select>
    </div>

    <!-- Task Kind Enum Dropdown -->
    <div class="rajdhani-light" style="margin-bottom: 5px;">
        <label for="task_kind" class="rajdhani-light">TASK KIND :</label>
        <select id="task_kind" name="task_kind" class="rajdhani-light" required>
            <?php
            foreach (TaskKind::cases() as $kind) {
                echo "<option value=\"{$kind->name}\">{$kind->name}</option>";
            }
            ?>
        </select>
    </div>

    <!-- Task Description -->
    <div class="rajdhani-light" style="margin-bottom: 5px;">
        <label for="task_description">TASK DESCRIPTION :</label>
        <input type="text" id="task_description" name="task_description" required>
    </div>

    <!-- Task Status Enum Dropdown : NO !!!! all Tasks are created as status PIPELINED -->

    <!-- Submit Button -->
     <div class="rajdhani-light" style="margin-bottom: 5px;">
        <button type="submit" class="rajdhani-light" style="align-self: flex-start; padding: 10px 20px; margin: 0px 0px 20px 0px">CREATE TASK</button>
     </div>
    <!--<button type="submit" class="rajdhani-light" style="align-self: flex-start; padding: 10px 20px; margin: 0px 0px 25px 15px">CREATE TASK</button>-->
</form>

<!-- Display the created task if available -->

<?php
if (isset($_SESSION['created_task'])) {
    $createdTask = $_SESSION['created_task'];
    echo '<article class="grid-item rajdhani-light">';
    echo "<p>Your new task has been successfully created!</p>";
    echo "<p><b>TASK ID</b>  : <b>" . htmlspecialchars($createdTask->getIdTask()) . "</b> | Project ID : " . htmlspecialchars($createdTask->getProjectId()) . " | Programmer ID : " . htmlspecialchars($createdTask->getProgrammerId()) . "</p>";
    echo "<p><b>" . htmlspecialchars($createdTask->getTaskKind()->value) . "</b> | Task Description : " . htmlspecialchars($createdTask->getTaskDescription()) . "</p>";
    echo "<p>Task progress : " . htmlspecialchars($createdTask->getTaskStatus()->value) . "</p>";
    echo '</article>';
    unset($_SESSION['created_task']); // Clear the session variable
}
?>

</body>
</html>