<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) ) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
    if ($_SESSION['role'] == "admin") {
        $todaydue_task = count_tasks_due_today($conn);
        $overdue_task = count_tasks_overdue($conn);
        $nodeadline_task = count_tasks_NoDeadline($conn);
        $num_task = count_tasks($conn);
        $num_users = count_users($conn);
        $pending = count_pending_tasks($conn);
        $in_progress = count_in_progress_tasks($conn);
        $completed = count_completed_tasks($conn);
	}else {
        $num_my_task = count_my_tasks($conn, $_SESSION['id']);
        $overdue_task = count_my_tasks_overdue($conn, $_SESSION['id']);
        $nodeadline_task = count_my_tasks_NoDeadline($conn, $_SESSION['id']);
        $pending = count_my_pending_tasks($conn, $_SESSION['id']);
        $in_progress = count_my_in_progress_tasks($conn, $_SESSION['id']);
        $completed = count_my_completed_tasks($conn, $_SESSION['id']);
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
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
			<?php if ($_SESSION['role'] == "admin") { ?>
				<div class="dashboard">
					<div class="dashboard-item">
						<i class="fa-solid fa-users"></i>
						<span><?=$num_users?> Employee</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-tasks"></i>
						<span><?=$num_task?> All Tasks</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-rectangle-xmark"></i>
						<span><?=$overdue_task?> Overdue</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-clock"></i>
						<span><?=$nodeadline_task?> No Deadline</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-exclamation-triangle"></i>
						<span><?=$todaydue_task?> Due Today</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-square"></i>
						<span><?=$pending?> Pending</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-spinner"></i>
						<span><?=$in_progress?> In progress</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-check-square"></i>
						<span><?=$completed?> Completed</span>
					</div>
				</div>
			<?php }else{ ?>
				<div class="dashboard">
					<div class="dashboard-item">
						<i class="fa fa-tasks"></i>
						<span><?=$num_my_task?> My Tasks</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-rectangle-xmark"></i>
						<span><?=$overdue_task?> Overdue</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-clock"></i>
						<span><?=$nodeadline_task?> No Deadline</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-square"></i>
						<span><?=$pending?> Pending</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-spinner"></i>
						<span><?=$in_progress?> In progress</span>
					</div>
					<div class="dashboard-item">
						<i class="fa-solid fa-check-square"></i>
						<span><?=$completed?> Completed</span>
					</div>
				</div>
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