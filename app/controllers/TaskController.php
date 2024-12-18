<?php
require_once __DIR__ . '../../../lib/base/Controller.php';
require_once __DIR__ . '../../models/task_manager.class.php';

class TaskController extends Controller {

    public function createAction() {
        
        //ob_start();       

        // Ensure that the form data has been submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect the data from the form
            $taskData = [
                'project_id' => $_POST['project_id'],
                'programmer_id' => $_POST['programmer_id'],
                'task_kind' => $_POST['task_kind'],
                'task_description' => $_POST['task_description'] ?? ''
            ];

            // Call the TaskManager's createTask method
            $taskManager = TaskManager::getInstance();
            $task = $taskManager->createTask($taskData);
            
            // Store the created task in a session (or pass it via query string)
            $_SESSION['created_task'] = $task;

            //header("Refresh:0");
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        // Render the create task form view
        $this->view->render('crudtask/create.php');
        //ob_end_flush(); // Flush output buffer at the end
    }

    public function getAllAction(){
        if (ob_get_level()) {
            ob_end_flush();
        }

        // Call the TaskManager's getAllTasks method
        $taskManager = TaskManager::getInstance();
        $tasks = $taskManager->getAllTasks();

        // Store the created task in a session (or pass it via query string)
        $_SESSION['all_tasks'] = $tasks;
    }

    public function showAction() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_task'])) {
            $taskId = (int) $_POST['id_task'];
    
            $taskManager = TaskManager::getInstance();
            $task = $taskManager->getTaskById($taskId);
    
            if ($task) {
                $_SESSION['selected_task'] = $task; // Store task for use in show.php
            } else {
                $_SESSION['selected_task'] = null; // Handle case if task not found
            }
        }
    
        // Render the show task view
        $this->view->render('crudtask/show.php');
    }

    public function updateAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_task'], $_POST['assigned_programmer'])) {
            $taskId = (int)$_POST['id_task'];
            $updatedData = [
                'programmer_id' => $_POST['assigned_programmer']
            ];
    
            $taskManager = TaskManager::getInstance();
            $success = $taskManager->updateTask($taskId, $updatedData);
    
            if ($success) {
                $task = $taskManager->getTaskById($taskId);
                $_SESSION['selected_task'] = $task;
                echo "Task updated successfully!";
            } else {
                echo "Failed to update the task.";
            }
        }
        $this->view->render('crudtask/update.php');
    }


    public function deleteAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id_task'])) {
                $taskId = (int)$_POST['id_task'];
                $confirmation = strtolower(trim($_POST['confirmation'] ?? ''));
    
                // Process only if confirmation is provided
                if ($confirmation === 'delete') {
                    $taskManager = TaskManager::getInstance();
                    $success = $taskManager->deleteTask($taskId);
    
                    if ($success) {
                        echo '<p class="rajdhani-light" style="color: green; margin-left: 10px;">Task deleted successfully!</p>';
                    } else {
                        echo '<p class="rajdhani-light" style="color: red; margin-left: 10px;">Task was deleted already.</p>';
                    }
                } elseif (!empty($confirmation)) {
                    echo '<p class="rajdhani-light" style="color: red; margin-left: 10px;">Confirmation failed. Task not deleted.</p>';
                }
            }
        }
    
        // Always render the delete form
        $this->view->render('crudtask/delete.php');
    }
    
    
}
?>