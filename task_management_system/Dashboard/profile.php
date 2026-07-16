<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    include "DB_connection.php";
    include "app/Model/User.php";
    $user=get_user_by_id($conn,$_SESSION['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile</title>
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
			<h4 class="title">Profile <a href="edit_profile.php">Edit Profile</a></h4>
            <div class="profile-card">
                <table class="profile-table">
                    <tr>
                        <td>Full Name</td>
                        <td><?=$user['full_name'];?></td>
                    </tr>
                    <tr>
                        <td>User Name</td>
                        <td><?=$user['username'];?></td>
                    </tr>
                    <tr>
                        <td>Joined At</td>
                        <td><?=$user['created_at'];?></td>
                    </tr>
                </table>
        </div>
		</section>
	</div>
</body>
</html>
<?php }else{ 
    header("Location: login.php");
    exit();
}
?>