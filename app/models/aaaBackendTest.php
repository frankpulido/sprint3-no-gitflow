<?php
declare(strict_types=1);

require_once 'task_manager.class.php';
require_once 'task.class.php';
require_once 'project.class.php';
require_once 'programmer.class.php';
require_once 'task_kind.class.php';
require_once 'task_status.class.php';

$taskManager = TaskManager::getInstance();

// Sample Task Data
$taskData = [
    'project_id' => 1,
    'programmer_id' => 1,
    'task_kind' => TaskKind::BACKOFFICE,
    'task_description' => 'Implement feature X',
];


// CREATE a Task
echo PHP_EOL;
$newTask = $taskManager->createTask($taskData);
echo "Created Task ID: " . $newTask->getIdTask() . "\n";
echo PHP_EOL;


// READ all Tasks
$allTasks = $taskManager->getAllTasks();
echo "ALL Tasks in JSON persistence file :";
echo PHP_EOL;
print_r($allTasks);


// READ all Programmers
$allProgrammers = $taskManager->getAllProgrammers();
echo "ALL Programmers in JSON persistence file :";
echo PHP_EOL;
print_r($allProgrammers);


// READ all Projects
$allProjects = $taskManager->getAllProjects();
echo "ALL Projects in JSON persistence file :";
echo PHP_EOL;
print_r($allProjects);


// READ a Task by ID
echo PHP_EOL;
$taskId = $newTask->getIdTask();
$task = $taskManager->getTaskById($taskId);
echo "Retrieved Task: " . $taskId . "\n";
echo "Task " . $taskId . " attributes :" . "\n";
print_r($task);


// UPDATE a Task
echo PHP_EOL;
$updatedData = [
    'task_description' => 'Implement feature X (updated)',
    'task_status' => TaskKind::BACKOFFICE->name,
];
$taskManager->updateTask($taskId, $updatedData);
$task = $taskManager->getTaskById($taskId);
echo "Updated Task ID: " . $taskId . "\n";
echo "Task " . $taskId . " attributes :" . "\n";
print_r($task);


// DELETE a Task
echo PHP_EOL;
$taskManager->deleteTask($taskId);
echo "Deleted Task ID: " . $taskId . "\n";


// Check remaining tasks
echo PHP_EOL;
$remainingTasks = $taskManager->getAllTasks();
echo "Remaining Tasks in JSON persistence file :\n";
echo PHP_EOL;
print_r($remainingTasks);
?>
