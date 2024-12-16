<?php
require_once 'vendor/autoload.php'; // Autoload Faker and other dependencies

use Faker\Factory;

$faker = Factory::create();

// Load projects from projects.json
$projectsJson = file_get_contents('projects.json');
$projects = json_decode($projectsJson, true);

$tasks = [];

// Helper function to randomly return either null or a generated date
function randomOrDate($faker, $startDate) {
    return random_int(0, 1) ? null : $faker->dateTimeBetween($startDate, 'now');
}

foreach ($projects as $project) {
    $projectId = $project['id_project']; // Randomly decide how many tasks to create (between 1 and 5)
    $numTasks = random_int(1, 5);

    for ($i = 0; $i < $numTasks; $i++) {
        $dateCreated = $faker->dateTimeThisYear(); // Always set a creation date

        // Conditionally set dates for each stage
        $dateInit = randomOrDate($faker, $dateCreated);
        $dateDelivered = isset($dateInit) ? randomOrDate($faker, $dateInit) : null;
        $dateApproved = isset($dateDelivered) ? randomOrDate($faker, $dateDelivered) : null;

        /* Generate sequential dates
        $dateCreated = $faker->dateTimeThisYear();
        $dateInit = $faker->dateTimeBetween($dateCreated, 'now');
        $dateDelivered = $faker->dateTimeBetween($dateInit, 'now');
        $dateApproved = $faker->dateTimeBetween($dateDelivered, 'now');
        */

        $task = [
            'id_task' => uniqid(), // Unique ID for the task
            'project_id' => $projectId,
            'programmer_id' => $faker->numberBetween(1, 15), // Assuming this corresponds to existing programmer IDs
            'task_kind' => $faker->randomElement(['FRONTOFFICE', 'BACKOFFICE', 'DATABASE']),
            'task_status' => $faker->randomElement(['PIPELINED', 'INIT', 'DELIVERED', 'RELEASED']),
            'task_description' => $faker->sentence(15),
            'dateCreated' => $dateCreated->format(DateTime::ATOM),
            'dateInit' => $dateInit ? $dateInit->format(DateTime::ATOM) : null,
            'dateDelivered' => $dateDelivered ? $dateDelivered->format(DateTime::ATOM) : null,
            'dateApproved' => $dateApproved ? $dateApproved->format(DateTime::ATOM) : null,
        ];
        $tasks[] = $task;
    }
}

// Save to tasks.json
file_put_contents('tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
?>
