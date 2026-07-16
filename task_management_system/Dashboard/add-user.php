<?php 
    session_start();
    if(isset($_SESSION['role'])&&isset($_SESSION['id']) && $_SESSION['role'] == 'admin'){
        include "DB_connection.php";
        include "app/Model/User.php";
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
    <title>Add User</title>
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
        <h4 class="title">Add Users<a href="user.php">Users</a></h4>
        <form class="form-1" method="post" action="app/add-user.php">
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
                <input type="text" name="full_name" class="input-1" placeholder="Full Name"><br>
            </div>
            <div class="input-holder">
                <label>User Name</label>
                <input type="text" name="user_name" class="input-1" placeholder="User Name"><br>
            </div>
            <div class="input-holder">
                <label>Password</label>
                <input type="password" name="password" class="input-1" placeholder="Password"><br>
            </div>
            <button class="edit-btn">Add</button>
        </form>
    </section>
    </div>
</body>
</html>
<?php }else {
    $_SESSION['errors'] = ["First login"];
    header("location:login.php");
    exit();
}
?>