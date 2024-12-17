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
        
        if (ob_get_level()) {
            ob_end_flush();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_task'])) {
            $taskId = $_POST['id_task'];
    
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_task'])) {
            $taskId = (int)$_POST['id_task'];
            $updatedData = [
                'task_description' => $_POST['task_name'] ?? '',
                'assigned_programmer' => $_POST['assigned_programmer'] ?? '',
                //'task_status' => isset($_POST['advance_status']) ? 'IN_PROGRESS' : ''
            ];
    
            $taskManager = TaskManager::getInstance();
            $success = $taskManager->updateTask($taskId, $updatedData);
    
            if ($success) {
                echo "Task updated successfully!";
            } else {
                echo "Failed to update the task.";
            }
        }
        $this->view->render('crudtask/update.php');
    }
    
    public function deleteAction() {
        //echo "Delete action triggered<br>";
        //print_r($_POST); // Debugging: Check incoming POST data

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_task'])) {
            $taskId = (int)$_POST['id_task'];
            $confirmation = $_POST['confirmation'] ?? '';
    
            if (strtolower($confirmation) === 'delete') {
                $taskManager = TaskManager::getInstance();
                $success = $taskManager->deleteTask($taskId);
    
                if ($success) {
                    echo "Task deleted successfully!";
                } else {
                    echo "Failed to delete the task.";
                }
            } else {
                echo "Confirmation failed. Task not deleted.";
            }
        }
        $this->view->render('crudtask/delete.php');
    }
    
}
?>