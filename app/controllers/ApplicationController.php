<?php

/**
 * Base controller for the application.
 * Add general things in this controller.
 */
class ApplicationController extends Controller
{
    public function indexAction()
    {
        //$title = "View ALL in GRID"; // We passed $title from the view to the head.php, now we do it through this Controller
        //$this->view->title = $title;
        $this->view->render('view_grid.php'); // Render the specific view, which would be view_grid.php. I modified Controller.php (line 84) to use php instead of html
    }

    public function columnKindAction()
    {
        $title = "View grouped by KIND"; // We passed $title from the view to the head.php, now we do it through this Controller
        $this->view->title = $title;
        $this->view->render('view_column_kind.php'); // Render the specific view, which would be view_grid.php. I modified Controller.php (line 84) to use php instead of html
    }

    public function columnProgressAction()
    {
        $title = "View grouped by PROGRESS"; // We passed $title from the view to the head.php, now we do it through this Controller
        $this->view->title = $title;
        $this->view->render('view_column_progress.php'); // Render the specific view, which would be view_grid.php. I modified Controller.php (line 84) to use php instead of html
    }

    /*
    public function createAction()
    {
        $this->view->render('../crud_task/create.php');
    }
    */

    /*
    public function showAction()
    {
        $this->view->render('../crud_task/show.php');
    }
    */

    /* Moving here createAction() from TaskController didn't work
    public function createAction() {
        
        if (ob_get_level()) {
            ob_end_flush();
        }
        //echo "TaskController reached<br>"; // Debugging (only reached when using commented LINE 3 in header.php : $taskController->execute('create');)
        

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

            // Redirect (refresh) the page
            //header("Location: {$_SERVER['REQUEST_URI']}");
            header("Refresh:0");
            exit();
        }

        // Render the create task form view
        $this->view->render('crud_task/create');

    }
    */

}

?>