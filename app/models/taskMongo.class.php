<?php
declare(strict_types=1);
require_once "task_kind.class.php";
require_once "task_status.class.php";
require_once "programmer.class.php";
require_once "project.class.php";

final class Task {
    protected Project $project;
    protected Programmer $programmer; // When a task is created it must have a programmer assigned, then this attribute can be changed.
    protected TaskKind $task_kind; // Ojo, el JSON schema debe forzar un ENUM TaskKind
    protected TaskStatus $task_status; // Al crearse se le asigna 
    protected string $task_description;
    protected DateTime $dateInit;
    protected DateTime $dateDelivered; // If not approved this attribute may be overwritten later when delivered for second time.
    protected DateTime $dateApproved;

    public function __construct(Project $project, TaskKind $task_kind, string $task_description, Programmer $programmer) {
        $this->project = $project;
        $this->task_kind = $task_kind;
        $this->task_status = TaskStatus::PIPELINED;
        $this->task_description = $task_description;
        $this->programmer = $programmer;
        $this->dateInit = NULL;
        $this->dateDelivered = NULL;
        $this->dateApproved = NULL;
    }
    
    // Getters
    
    public function getProject() : Project {
        return $this->project;
    }
    public function getTaskKind() : TaskKind {
        return $this->task_kind;
    }

    public function getTaskStatus() : TaskStatus {
        return $this->task_status;
    }

    public function getTaskDescription() : string {
        return $this->task_description;
    }

    public function getProgrammer() : Programmer {
        return $this->programmer;
    }

    public function getDateInit() : DateTime {
        return $this->dateInit;
    }
    
    public function getDateDelivered() : DateTime {
        return $this->dateDelivered;
    }
    
    public function getDateApproved() : DateTime {
        return $this->dateApproved;
    }
    
    // Setters

    public function setProject($project) : void {
        $this->project = $project;
    }
    public function setTaskKind($task_kind) : void {
        $this->task_kind = $task_kind;
    }

    public function setTaskStatus($task_status) : void {
        $this->task_status = $task_status;
    }

    public function setTaskDescription($task_description) : void {
        $this->task_description = $task_description;
    }

    public function setProgrammer($programmer) : void {
        $this->programmer = $programmer;
    }
    
    public function setDateInit($dateInit) : void {
        $this->dateInit = $dateInit;
        $this->task_status = TaskStatus::INIT;
    }
    
    public function setDateDelivered($dateDelivered) : void {
        $this->dateInit = $dateDelivered;
        $this->task_status = TaskStatus::DELIVERED;
    }
    
    public function setDateApproved($dateApproved) : void {
        $this->dateInit = $dateApproved;
        $this->task_status = TaskStatus::RELEASED;
    }
}

?>