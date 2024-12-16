<?php
$title = "View grouped by KIND"; // Failed trying to pass variable through the ApplicationController
include __DIR__ . '/../layouts/head.php';
require_once(ROOT_PATH . '/app/models/task_manager.class.php');
?>

<body>
    <?php include __DIR__ . '/../layouts/header.php'; ?>

    <?php
    // Load tasks from JSON file
    //$jsonFile = '../../models/tasks.json'; // IMPORTANT : check right path to JSON file - View grouped by KIND
    //if (file_exists($jsonFile)) {
        /*
        $jsonData = file_get_contents($jsonFile);
        $tasks = json_decode($jsonData, true); // Decode as an associative array
        */
        $tasks = TaskManager::getInstance()->getAllTasks();

    // Initialize the task categories
    $categorizedTasks = [
        'FRONTOFFICE' => [],
        'BACKOFFICE' => [],
        'DATABASE' => []
    ];

    // Categorize tasks by status
    foreach ($tasks as $task) {
        $kind = $task['task_kind'];
        if (isset($categorizedTasks[$kind])) {
            $categorizedTasks[$kind][] = $task;
        }
    }
    ?>

<section class="grid-container-cases-3">
    <?php foreach ($categorizedTasks as $kind => $tasks): ?>
        <section class="nested-grid-cases rajdhani-light">
            <h2><?= ucfirst(strtoupper($kind)) ?></h2>
            <?php if (!empty($tasks)): ?>
                <?php foreach ($tasks as $task): ?>
                    <article class="grid-item">
                        <p><b>TASK ID</b>  : <b><?= htmlspecialchars($task['id_task']) ?></b> | Project ID : <?= htmlspecialchars($task['project_id']) ?> | Programmer ID : <?= htmlspecialchars($task['programmer_id']) ?></p>
                        <p><b><?= htmlspecialchars($task['task_kind']) ?></b> | Description : <?= htmlspecialchars($task['task_description']) ?></p>
                        <p>Task progress : <?= htmlspecialchars($task['task_status']) ?></p>
                        
                        <?php
                        if (!empty($task['dateCreated'])) {
                            echo "<p>Pipelined : " . htmlspecialchars($task['dateCreated']) . "</p>"; // Don't want to "create" a new Date to change format
                            //echo "<p>Pipelined : " . (new DateTime($task['dateCreated']))->format('Y-m-d') . "</p>";
                        }
                        if (!empty($task['dateInit'])) {
                            echo "<p>Started : " . htmlspecialchars($task['dateInit']) . "</p>";
                            //echo "<p>Started : " . (new DateTime($task['dateInit']))->format('Y-m-d') . "</p>";
                        }
                        if (!empty($task['dateDelivered'])) {
                            echo "<p>Delivered : " . htmlspecialchars($task['dateDelivered']) . "</p>";
                            //echo "<p>Delivered : " . (new DateTime($task['dateDelivered']))->format('Y-m-d') . "</p>";
                        }
                        if (!empty($task['dateApproved'])) {
                            echo "<p>Released : " . htmlspecialchars($task['dateApproved']) . "</p>";
                            //echo "<p>Released : " . (new DateTime($task['dateApproved']))->format('Y-m-d') . "</p>";
                        }
                        ?>
                        
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No tasks in this status.</p>
            <?php endif; ?>
        </section>
    <?php endforeach; ?>
</section>

            <?php //} else { echo "<p>Error loading tasks file.</p>"; } ?>

</body>
</html>