<?php 
session_start();
if(isset($_SESSION['role'])&&isset($_SESSION['id'])&& $_SESSION['role'] == 'admin') {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
    if(!isset($_GET['id'])){
        header("location:tasks.php");
        exit();
    }
    $id=$_GET['id'];
    $task=get_task_by_id($conn,$id);
    if($task==0){
        header("location:tasks.php");
        exit();
    }
    $users=get_all_users($conn);
    $errorList = [];
    if (isset($_SESSION['errors'])) {
        $errorList = $_SESSION['errors'];
        unset($_SESSION['errors']);
    }
    $successMessage = null;
    if (isset($_SESSION['success'])) {
        $successMessage = $_SESSION['success'];
        unset($_SESSION['success']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="CSS/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php"?>
    <div class="body">
        <?php include "inc/nav.php"?>
    <section class="section-1">
        <h4 class="title">Edit Task<a href="tasks.php">Tasks</a></h4>
        <form class="form-1" method="post" action="app/update-task.php">
            <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($errorList)): ?>
            <?php foreach ($errorList as $error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
            <div class="input-holder">
                <label>Title</label>
                <input type="text" name="title" class="input-1" placeholder="Title" value="<?= ($task['title']);?>"><br>
            </div>
            <div class="input-holder">
                <label>Description</label>
                <textarea name="description" rows="5" class="input-1" placeholder="Description"><?= ($task['description']);?></textarea><br>
            </div>
            <div class="input-holder">
                <label>Due Date</label>
                <input type="date" name="due_date" class="input-1" placeholder="snooze" value="<?= ($task['due_date']);?>"><br>
            </div>
                <div class="input-holder">
					<label>Assigned to</label>
					<select name="assigned_to" class="input-1">
						<option value="0">Select employee</option>
						<?php if ($users !=0) { 
							foreach ($users as $user) {
						?>
                <option value="<?=$user['id']?>" <?= $user['id'] == $task['assigned_to'] ? 'selected' : '' ?>><?=($user['full_name'])?></option>
						<?php } } ?>
					</select><br>
				</div>
            <input type="text" name="id" value="<?= $task['id'];?>" hidden>
            <button class="edit-btn">Update</button>
        </form>
    </section>
    </div>
</body>
</html>
<?php }else {
    header("location:login.php");
    exit();
}
?>