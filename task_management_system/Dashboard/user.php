<?php 
session_start();
if(isset($_SESSION['role'])&&isset($_SESSION['id'])&& $_SESSION['role'] == "admin"){
    include "DB_connection.php";
    include "app/Model/User.php";
    $users=get_all_users($conn);
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
    <title>Manage Users</title>
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
            <h4 class="title">Manage Users<a href="add-user.php">Add Users</a></h4>
            <?php if($users !=0){?>
                <?php if (!empty($successMessage)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $successMessage; ?>
                    </div>
                <?php endif; ?>
                    <table class="main-table">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>role</th>
                            <th>Action</th>
                        </tr>
                        <?php $i=0; foreach ($users as $user){ ?>
                        <tr>
                            <td><?= ++$i?></td>
                            <td><?= $user['full_name']?></td>
                            <td><?= $user['username']?></td>
                            <td><?= $user['role']?></td>
                            <td>
                                <a href="edit-user.php?id=<?=$user['id'];?>" class="edit-btn">Edit</a>
                                <a href="delete-user.php?id=<?=$user['id'];?>" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                <?php } else {?>
                    <h3>Empty</h3>
                <?php }?>
        </section>
    </div>
</body>
</html>
<?php }else {
    header("location:login.php");
    exit();
}
?>