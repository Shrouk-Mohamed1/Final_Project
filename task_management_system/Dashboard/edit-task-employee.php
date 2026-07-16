<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
    if (!isset($_GET['id'])) {
        header("Location: tasks.php");
        exit();
    }
    $id = $_GET['id'];
    $task = get_task_by_id($conn, $id);
    if ($task['assigned_to'] !== $_SESSION['id']) {
    header("Location: my_task.php");
    exit();
}
    if ($task == 0) {
        header("Location: tasks.php");
        exit();
    }
    $users = get_all_users($conn);
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
<html>
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
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Edit Task <a href="my_task.php">Tasks</a></h4>
			<form class="form-1"
                method="POST"
                action="app/update-task-employee.php">
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
					<p><b>Title: </b><?=$task['title']?></p>
				</div>
				<div class="input-holder">
					<p><b>Description: </b><?=$task['description']?></p>
				</div><br>
            <div class="input-holder">
					<label>Status</label>
					<select name="status" class="input-1">
						<option 
						<?php if( $task['status'] == "pending") echo"selected"; ?> >pending</option>
						<option <?php if( $task['status'] == "in_progress") echo"selected"; ?>>in_progress</option>
						<option <?php if( $task['status'] == "completed") echo"selected"; ?>>completed</option>
					</select><br>
				</div>
				<input type="text" name="id" value="<?=$task['id']?>" hidden>
				<button class="edit-btn">Update</button>
			</form>
		</section>
	</div>
</body>
</html>
<?php }else{ 
    header("Location: login.php");
    exit();
}
?>