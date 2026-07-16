<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    include "DB_connection.php";
    include "app/Model/User.php";
    $user=get_user_by_id($conn,$_SESSION['id']);
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
	<title>Edit Profile</title>
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
			<h4 class="title">Edit Profile <a href="profile.php">Profile</a></h4>
            <form class="form-1" method="post" action="app/update-profile.php">
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
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="input-1" placeholder="Full Name" value="<?= $user['full_name'];?>"><br>
                </div>
                <div class="input-holder">
                    <label>Old Password</label>
                    <input type="text" name="password" class="input-1" placeholder="Old Password"><br>
                </div>
                <div class="input-holder">
                    <label>New Password</label>
                    <input type="text" name="new_password" class="input-1" placeholder="New Password" ><br>
                </div>
                <div class="input-holder">
                    <label>Confirm Password</label>
                    <input type="text" name="confirm_password" class="input-1" placeholder="Confirm Password" ><br>
                </div>
                <button class="edit-btn">Change</button>
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