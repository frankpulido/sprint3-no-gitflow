<?php
declare(strict_types = 1);
require_once 'task_kind.class.php';
require_once 'task_status.class.php';
require_once 'project.class.php';
require_once 'programmer.class.php';
require_once 'task.class.php';

final class TaskManager {
    private static $instance;
    private string $filePathTasks = __DIR__ . '/tasks.json';
    private string $filePathProgrammers = __DIR__ . '/programmers.json';
    private string $filePathProjects = __DIR__ . '/projects.json';
    //private string $filePathTasks = 'tasks.json';
    //private string $filePathProgrammers = 'programmers.json';
    //private string $filePathProjects = 'projects.json';
    private $tasks = []; // array for pouring content from json persistence file $filePath

    private function __construct(){}

    public static function getInstance() : TaskManager {
        if (!isset(self::$instance)) { // https://www.w3schools.com/php/func_var_isset.asp
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __clone() {
        // Having it empty disables cloning. https://www.php.net/manual/en/language.oop5.cloning.php#object.clone
    }

    public function __wakeup() {
        /* Having it empty disables unserialize.
        unserialize() checks for the presence of a function with the magic name __wakeup(). If present, this function can reconstruct any resources that the object may have. 
        https://www.php.net/manual/en/language.oop5.magic.php#object.wakeup
        */
    }

    /* ********************************* HELPER METHODS TO LOAD AND SAVE JSON FILES AND ID GENERATION ********************************* */

    // Load data from JSON files

    private function loadData(string $filePath): array {
        if (!file_exists($filePath)) return []; // If json file doesn't exist it returns an empty array
        $data = file_get_contents($filePath);
        return json_decode($data, true) ?? [];
    }

    // Save data to JSON files

    private function saveData(array $data, string $filePath): bool {
        return file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT)) !== false;
    }

    // Generate unique IDs based on existing entries in JSON files

    /*
    private function generateUniqueId(string $filePath, string $idKey): int {
        $data = $this->loadData($filePath);
        return count($data) ? (int) max(array_column($data, $idKey)) + 1 : 1;
    }
    */

    private function generateUniqueId(string $filePath, string $idKey): int {
        $data = $this->loadData($filePath);
        if (!empty($data)) {
            $ids = array_map(fn($task) => (int)$task[$idKey], $data);
            $maxId = max($ids); // Find the highest ID
            return $maxId + 1;  // Increment by 1
        }
        return 1; // Start from 1 if no data exists
    }
    

    /* ********************************* TASK CRUD ********************************* */

    // Helper method to load tasks

    private function loadTasks(): array {
        return $this->loadData($this->filePathTasks); // I am using generic LOAD HELPER previous section
    }
    
    // Helper method to save tasks

    private function saveTasks(array $tasks): bool {
        return $this->saveData($tasks, $this->filePathTasks); // I am using generic SAVE HELPER previous section
    }
    

    // CREATE : Add a new task to tasks.json

    public function createTask(array $taskData) { // $task data is an array with json object attributes
        $this->tasks = $this->loadTasks();

        // Validate ENUM-like fields (e.g., task_kind and task_status)
        $validTaskKinds = array_map(fn($case) => $case->value, TaskKind::cases());
        if (!in_array($taskData['task_kind'], $validTaskKinds)) {
            throw new InvalidArgumentException("Invalid task kind");
        }
        /*
        if (!in_array($taskData['task_kind'], TaskKind::cases())) {
            throw new InvalidArgumentException("Invalid task kind");
        }
        */
        
        // Initialize new task
        $task = new Task(
            (int) $taskData['project_id'],
            (int) $taskData['programmer_id'],
            TaskKind::from($taskData['task_kind']),
            $taskData['task_description'] ?? '',
        );

        // generate unique ID
        $uniqueId = $this->generateUniqueId($this->filePathTasks, 'id_task');
        $task->setIdTask($uniqueId);

        // Add the task to the tasks array but not as an instance of Task
        $this->tasks[] = $task->toArray();

        // Add the task to the JSON persistence file
        $this->saveTasks($this->tasks);
        return $task;
    }

    // READ : Retrieve a single task by ID...

    public function getTaskById(int $id_task): ?array {
        $tasks = $this->loadTasks();
        foreach ($tasks as $task) {
            if ($task['id_task'] === $id_task) {
                return $task;
            }
        }
        return null;  // Task not found
    }
    
    // READ : Retrieve ALL tasks. : SAME THAN loadTasks()
    public function getAllTasks(): array {
        return $this->loadTasks();
    }
    
    // UPDATE : Update an existing task by ID.

    public function updateTask(int $id_task, array $updatedData): bool {
        $tasks = $this->loadTasks();
        foreach ($tasks as &$task) {
            if ($task['id_task'] === $id_task) {
                /*
                $task = array_merge($task, $updatedData);  // Overwrite task data with updates (object/document with $task_id = $taskId)
                return $this->saveTasks($tasks);
                */
                foreach ($updatedData as $key => $value) {
                    if (array_key_exists($key, $task)) {
                        $task[$key] = $value;
                    }
                }
                return $this->saveTasks($tasks);
            }
        }
        return false;  // Task not found
    }

    // DELETE :

    public function deleteTask(int $id_task): bool {
        // Check if the task exists
        $existingTask = $this->getTaskById($id_task);
        if (!$existingTask) {
            return false; // Task not found
        }
    
        // Filter out the task to be deleted
        $tasks = $this->loadTasks();
        $tasks = array_filter($tasks, fn($task) => $task['id_task'] !== $id_task);
    
        // Save the updated task list
        return $this->saveTasks(array_values($tasks));
    }


    /* ********************************* PROJECT CRUD ********************************* */

    // Helper method to load projects

    private function loadProjects(): array {
        return $this->loadData($this->filePathProjects); // I am using generic LOAD HELPER previous section
    }
    
    // Helper method to save projects

    private function saveProjects(array $projects): bool {
        return $this->saveData($projects, $this->filePathProjects); // I am using generic SAVE HELPER previous section
    }

    // Check whether a Project exists
    public function projectExists(int $projectId): bool {
        $projects = $this->loadProjects();
        foreach ($projects as $project) {
            if ($project['id_project'] === $projectId) {
                return true;
            }
        }
        return false; // Project not found
    }

    // CREATE: Add a new project
    public function createProject(array $projectData): bool {
        $projects = $this->loadProjects();
        $projectData['id_project'] = $this->generateUniqueId($this->filePathProjects, 'id_project');
        $projects[] = $projectData;
        return $this->saveData($projects, $this->filePathProjects);
    }

    // READ: Retrieve a project by ID
    public function getProject(int $projectId): ?array {
        $projects = $this->loadProjects();
        foreach ($projects as $project) {
            if ($project['id_project'] === $projectId) {
                return $project;
            }
        }
        return null;
    }

    // READ: Retrieve all projects : SAME THAN loadProjects
    public function getAllProjects(): array {
        return $this->loadProjects();
    }

    // UPDATE: Update an existing project by ID
    public function updateProject(int $projectId, array $updatedData): bool {
        $projects = $this->loadProjects();
        foreach ($projects as &$project) {
            if ($project['id_project'] === $projectId) {
                $project = array_merge($project, $updatedData);
                return $this->saveData($projects, $this->filePathProjects);
            }
        }
        return false;
    }

    // DELETE: Remove a project by ID
    public function deleteProject(int $projectId): bool {
        $projects = $this->loadProjects();
        $initialCount = count($projects);
        $projects = array_filter($projects, fn($project) => $project['id_project'] !== $projectId);
    
        if (count($projects) < $initialCount) {
            return $this->saveData(array_values($projects), $this->filePathProjects);
        }
        return false;
    }

    /* ********************************* PROGRAMMER CRUD ********************************* */
    

    // Helper method to load programmer

    private function loadProgrammers(): array {
        return $this->loadData($this->filePathProgrammers); // I am using generic LOAD HELPER previous section
    }
    
    // Helper method to save programmers

    private function saveProgrammers(array $programmers): bool {
        return $this->saveData($programmers, $this->filePathProgrammers); // I am using generic SAVE HELPER previous section
    }

    // Check whether a Programmer exists
    public function programmerExists(int $programmerId): bool {
        $programmers = $this->loadProgrammers();
        foreach ($programmers as $programmer) {
            if ($programmer['id_programmer'] === $programmerId) {
                return true;
            }
        }
        return false; // Programmer not found
    }

    // CREATE: Add a new programmer
    public function createProgrammer(array $programmerData): bool {
        $programmers = $this->loadProgrammers();
        $programmerData['id_programmer'] = $this->generateUniqueId($this->filePathProgrammers, 'id_programmer');
        $programmers[] = $programmerData;
        return $this->saveData($programmers, $this->filePathProgrammers);
    }

    // READ: Retrieve a programmer by ID
    public function getProgrammer(int $programmerId): ?array {
        $programmers = $this->loadProgrammers();
        foreach ($programmers as $programmer) {
            if ($programmer['id_programmer'] === $programmerId) {
                return $programmer;
            }
        }
        return null;
    }

    // READ: Retrieve all programmers : SAME method than loadProgrammers()
    public function getAllProgrammers(): array {
        return $this->loadProgrammers();
    }

    // UPDATE: Update an existing programmer by ID
    public function updateProgrammer(int $programmerId, array $updatedData): bool {
        $programmers = $this->loadProgrammers();
        foreach ($programmers as &$programmer) {
            if ($programmer['id_programmer'] === $programmerId) {
                $programmer = array_merge($programmer, $updatedData);
                return $this->saveData($programmers, $this->filePathProgrammers);
            }
        }
        return false;
    }

    // DELETE: Remove a programmer by ID
    public function deleteProgrammer(int $programmerId): bool {
        $programmers = $this->loadProgrammers();
        $initialCount = count($programmers);
        $programmers = array_filter($programmers, fn($programmer) => $programmer['id_programmer'] !== $programmerId);
    
        if (count($programmers) < $initialCount) {
            return $this->saveData(array_values($programmers), $this->filePathProgrammers);
        }
        return false;
    }
}
?>
    