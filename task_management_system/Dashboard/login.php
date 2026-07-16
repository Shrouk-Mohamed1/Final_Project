<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
} 
$errorList = [];
if (isset($_SESSION['errors'])) {
    $errorList = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Task Management System</title>
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body class="login-body">
    <form class="shadow p-4 bg-white rounded-4" method="post" action="app/login.php">
        <h3 class="display-4 text-center">LOG IN</h3>
        <?php if (!empty($errorList)): ?>
            <?php foreach ($errorList as $error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label" required>User Name</label>
            <input type="text" class="form-control input-1" id="exampleInputEmail1" aria-describedby="emailHelp" name="user_name">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label" required>Password</label>
            <input type="password" class="form-control input-1" id="exampleInputPassword1" name="password">
        </div>
        <button type="submit" class="btn btn-warning w-100">Login</button>
    </form>
</body>
</html>