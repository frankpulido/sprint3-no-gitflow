<?php
$title = "View ALL in GRID"; // Failed trying to pass variable through the ApplicationController
include __DIR__ . '/../layouts/head.php';
require_once(ROOT_PATH . '/app/models/task_manager.class.php');
//require_once "../developers_nivel1/app/models/task_manager.class.php";
?>

<body>
    <?php include __DIR__ . '/../layouts/header.php'; ?>

    <section class="grid-container">

        <section class="nested-grid rajdhani-light">
            <?php

                $tasks = TaskManager::getInstance()->getAllTasks();
                foreach ($tasks as $task) {
                    echo '<article class="grid-item">';
                    echo "<p><b>TASK ID</b>  : <b>" . htmlspecialchars($task['id_task']) . "</b> | Project ID : " . htmlspecialchars($task['project_id']) . " | Programmer ID : " . htmlspecialchars($task['programmer_id']) . "</p>";
                    echo "<p><b>" . htmlspecialchars($task['task_kind']) . "</b> | Description : " . htmlspecialchars($task['task_description']) . "</p>";
                    echo "<p>Task progress : " . htmlspecialchars($task['task_status']) . "</p>";
                    
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
                    echo '</article>';
                }
            ?>

            
            <?php
            // Load tasks from JSON file
            /*
            $jsonFile = '../../models/tasks.json'; // IMPORTANT : check right path to JSON file
            
            if (file_exists($jsonFile)) {
                /*
                $jsonData = file_get_contents($jsonFile);
                $tasks = json_decode($jsonData, true); // Decode as an associative array
                */
                /*
                $tasks = TaskManager::getInstance()->getAllTasks();
                foreach ($tasks as $task) {
                    echo '<article class="grid-item">';
                    echo "<p><b>TASK ID</b>  : <b>" . htmlspecialchars($task['id_task']) . "</b> | Project ID : " . htmlspecialchars($task['project_id']) . " | Programmer ID : " . htmlspecialchars($task['programmer_id']) . "</p>";
                    echo "<p><b>" . htmlspecialchars($task['task_kind']) . "</b> | Description : " . htmlspecialchars($task['task_description']) . "</p>";
                    echo "<p>Task progress : " . htmlspecialchars($task['task_status']) . "</p>";
                    
                    if (!empty($task['dateCreated'])) {
                        echo "<p>Pipelined : " . (new DateTime($task['dateCreated']))->format('Y-m-d') . "</p>";
                    }
                    if (!empty($task['dateInit'])) {
                        echo "<p>Started : " . (new DateTime($task['dateInit']))->format('Y-m-d') . "</p>";
                    }
                    if (!empty($task['dateDelivered'])) {
                        echo "<p>Delivered : " . (new DateTime($task['dateDelivered']))->format('Y-m-d') . "</p>";
                    }
                    if (!empty($task['dateApproved'])) {
                        echo "<p>Released : " . (new DateTime($task['dateApproved']))->format('Y-m-d') . "</p>";
                    }
                    
                    echo '</article>';
                }            
            }*/
            
            ?>
            

        </section>
    </section>


    <section>
        <div class="search-results"></div>
    </section>
</body>
</html>