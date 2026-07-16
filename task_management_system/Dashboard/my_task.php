<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
	$tasks = get_all_tasks_by_id($conn, $_SESSION['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>My Tasks</title>
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
			<h4 class="title">My Tasks</h4>
			<?php if ($tasks != 0) { ?>
			<table class="main-table">
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Description</th>
					<th>Due Date</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php $i=0; foreach ($tasks as $task) { ?>
				<tr>
					<td><?=++$i?></td>
					<td><?=$task['title']?></td>
					<td><?=$task['description']?></td>
					<td><?=$task['due_date']?></td>
					<td><?=$task['status']?></td>
					<td>
						<a href="edit-task-employee.php?id=<?=$task['id']?>" class="edit-btn">Edit</a>
					</td>
				</tr>
				<?php } ?>
			</table>
		<?php }else { ?>
        <div class="alert alert-warning">No tasks assigned to you yet!</div>
		<?php } ?>
		</section>
	</div>
</body>
</html>
<?php }else{ 
	header("Location: login.php");
	exit();
}
?>