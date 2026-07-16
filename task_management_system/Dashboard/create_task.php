<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";
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
	<title>Create Task</title>
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
			<h4 class="title">Create Task </h4>
		<form class="form-1" method="POST" action="app/add-task.php">
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
					<input type="text" name="title" class="input-1" placeholder="Title"><br>
				</div>
				<div class="input-holder">
					<label>Description</label>
					<textarea type="text" name="description" class="input-1" placeholder="Description"></textarea><br>
				</div>
				<div class="input-holder">
					<label>Due Date</label>
					<input type="date" name="due_date" class="input-1" placeholder="Due Date"></input><br>
				</div>
				<div class="input-holder">
					<label>Assigned to</label>
					<select name="assigned_to" class="input-1">
						<option value="0" disabled selected>Select employee</option>
						<?php if ($users !=0) { 
							foreach ($users as $user) {
						?>
                <option value="<?=$user['id']?>"><?=$user['full_name']?></option>
						<?php } } ?>
					</select><br>
				</div>
				<button class="edit-btn">Create Task</button>
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