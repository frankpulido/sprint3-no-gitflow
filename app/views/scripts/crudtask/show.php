<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// nice for debugging... thanks Gepito!!!
?>

<?php
include __DIR__ . '../../../layouts/head.php'; // This class is not in MODELS folder
require_once __DIR__ . '/../../../controllers/TaskController.php';
require_once __DIR__ . '/../../../models/task_manager.class.php';
// This class IS IN MODELS folder, but autoloader doesn't accept underscores
// All classes in MODELS folder are autoloaded (unless autoloader doesn't like them... e.g. having underscores)
?>

<?php
/*
$taskId = 101; // I am placing this value to prevent having an error in LINE 15
$taskManager = TaskManager::getInstance();
$task = $taskManager->getTaskById($taskId); // Assuming $taskId is passed to this view
*/
?>

<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
} // To retrieve the session variable that returns the Task created by TaskManager through the controller TaskController

// Instantiate either class OR controller (not both... We are supposed to use TaskController, but I cannot make it work)
$taskManager = TaskManager::getInstance();
//$taskController = new TaskController();

// Get all tasks using the TaskManager singleton OR TaskController
$tasks = $taskManager->getAllTasks(); // This will return an array of tasks
//$tasks = $taskController->getAllAction();

// Get first task given that it will be the default option of the dropdown menu
$task = $_SESSION['selected_task'] ?? $tasks[0];
/*
$taskId = $tasks[0]['id_task'];
$task = $taskManager->getTaskById($taskId); // Assuming $taskId is passed to this view
*/
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

<h2 class="rajdhani-light" style="margin-left: 15px;">SEARCH->UPDATE/DELETE TASK</h2>

<form action="/crud_task/show" method="POST">
    <div style="margin: 0px 0px 5px 15 px;">
        <label for="id_task" class="rajdhani-light">Choose a task:</label>
        <select name="id_task" id="id_task" class="rajdhani-light">

            <?php foreach ($tasks as $item): ?>
                <option value="<?= $item['id_task']; ?>" <?= $task['id_task'] == $item['id_task'] ? 'selected' : '' ?>>
                    <?= $item['id_task'] . ' - ' . htmlspecialchars($item['task_description']); ?>
                </option>
            <?php endforeach; ?>

            <!--
            <?//php foreach ($tasks as $task): ?>
                <option value="<?//= $task['id_task']; ?>">
                    <?//= $task['id_task'] . ' - ' . htmlspecialchars($task['task_description']); ?>
                </option>
            <?//php endforeach; ?>
            -->

        </select>
        <!--<button type="submit" class="rajdhani-light" style="padding: 8px 20px; margin: 0px 0px 0px 15px">VIEW TASK</button>-->
    </div>
    <button type="submit" class="rajdhani-light" style="align-self: flex-start; padding: 10px 20px; margin: 0px 0px 25px 15px;">VIEW TASK</button>
</form>

<div class="rajdhani-light" style="margin-left: 10px;">
    <?php if ($task):
    //$taskId = $tasks[0]['id_task'];
    //$task = $taskManager->getTaskById($taskId); // Assuming $taskId is passed to this view

    echo '<article class="grid-item">';
        echo "<p><b>TASK ID</b>  : <b>" . htmlspecialchars($task['id_task']) . "</b> | Project ID : " . htmlspecialchars($task['project_id']) . " | Programmer ID : " . htmlspecialchars($task['programmer_id']) . "</p>";
        echo "<p><b>" . htmlspecialchars($task['task_kind']) . "</b> | Description : " . htmlspecialchars($task['task_description']) . "</p>";
        echo "<p>Task progress : " . htmlspecialchars($task['task_status']) . "</p>";
        
        if (!empty($task['dateCreated'])) {
            echo "<p>Pipelined : " . htmlspecialchars($task['dateCreated']) . "</p>";
        }
        if (!empty($task['dateInit'])) {
            echo "<p>Started : " . htmlspecialchars($task['dateInit']) . "</p>";
        }
        if (!empty($task['dateDelivered'])) {
            echo "<p>Delivered : " . htmlspecialchars($task['dateDelivered']) . "</p>";
        }
        if (!empty($task['dateApproved'])) {
            echo "<p>Released : " . htmlspecialchars($task['dateApproved']) . "</p>";
        }
    echo '</article>';
    endif;
    ?>
</div>

<div class="rajdhani-light" style="display: flex; align-items: flex-start; padding: 0px 10px 20px 15px;">
    <!-- UPDATE FORM -->
    <form action="<?php echo WEB_ROOT; ?>/task/update" method="post">
        <input type="hidden" name="id_task" value="<?= htmlspecialchars($task['id_task']); ?>">
        <button type="submit" class="rajdhani-light" style="padding: 10px 20px; margin: 0px 10px 20px 0px;">UPDATE TASK</button>
    </form>
    <!-- DELETE FORM -->
    <form action="<?php echo WEB_ROOT; ?>/task/delete" method="post">
        <input type="hidden" name="id_task" value="<?= htmlspecialchars($task['id_task']); ?>">
        <button type="submit" class="rajdhani-light" style="padding: 10px 20px; margin: 0px 10px 20px 0px;">DELETE TASK</button>
    </form>
</div>

<!--
<div class="rajdhani-light" style="margin-bottom: 5px;">
    <p>Task ID: <?//= $task['id_task']; ?></p>
    <p>Description: <?//= $task['task_description']; ?></p>
    <button onclick="location.href='/crud_task/update/<?//= $taskManager->getTaskById($taskId); ?>'">Update</button>
    <button onclick="location.href='/crud_task/delete/<?//= $taskManager->getTaskById($taskId) ?>'">Delete</button>
</div>
