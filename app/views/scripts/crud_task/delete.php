<form action="/crud_task/delete/<?= $task->getId(); ?>" method="POST">
    <p>Are you sure you want to delete this task? Type "delete" to confirm:</p>
    <input type="text" name="confirmation" required>
    <button type="submit">Delete</button>
</form>