<form action="/crud_task/update/<?= $task->getId(); ?>" method="POST">
    <label for="task_name">Task Name:</label>
    <input type="text" id="task_name" name="task_name" value="<?= $task->getTaskDescription(); ?>" required>

    <label for="assigned_programmer">Assigned Programmer:</label>
    <select id="assigned_programmer" name="assigned_programmer">
        <!-- Populate with existing programmer options -->
    </select>

    <label for="task_status">Current Status: <?= $task->getStatus(); ?></label>
    <button type="submit" name="advance_status" value="true">Advance Status</button>
    <button type="submit">Save Changes</button>
</form>
