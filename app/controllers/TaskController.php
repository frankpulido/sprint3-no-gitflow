<?php
require_once __DIR__ . '../../../lib/base/Controller.php';

class TaskController extends Controller {

    public function createAction() {
        
        if (ob_get_level()) {
            ob_end_flush();
        }        

        // Ensure that the form data has been submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect the data from the form
            $taskData = [
                'project_id' => $_POST['project_id'],
                'programmer_id' => $_POST['programmer_id'],
                'task_kind' => $_POST['task_kind'],
                'task_description' => $_POST['task_description'] ?? ''
            ];

            //print_r($taskData);

            // Call the TaskManager's createTask method
            $taskManager = TaskManager::getInstance();
            $task = $taskManager->createTask($taskData);
            
            // Store the created task in a session (or pass it via query string)
            $_SESSION['created_task'] = $task;

            // Redirect (refresh) the page
            //header("Location: {$_SERVER['REQUEST_URI']}");
            //header("Location: create.php");
            header("Refresh:0");
            exit();
        }
        

        // Render the create task form view
        $this->view->render('crudtask/create.php');
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
    
}
?>