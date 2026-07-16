<?php
$path_parts = explode('/', $_SERVER['PHP_SELF']);
$current_page = end($path_parts);
?>
<nav class="side-bar">
    <div class="user-p">
        <img src="images/user.jpg">
        <?php session_start() ?>
        <h4>@<?= $_SESSION['username']?></h4>
    </div>
    <?php 
        if ($_SESSION['role']=="employee"){
    ?>
    <ul>
        <li class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
            <a href="index.php">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="<?= $current_page == 'my_task.php'|| $current_page == 'edit-task-employee.php' ? 'active' : '' ?>">
            <a href="my_task.php">
                <i class="fa-solid fa-tasks"></i>
                <span>My Task</span>
            </a>
        </li>
        <li class="<?= $current_page == 'profile.php'|| $current_page == 'edit_profile.php' ? 'active' : '' ?>">
            <a href="profile.php">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>
        </li>
        <li>
            <a href="logout.php">
                <i class="fa-solid fa-sign-out"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
    <?php }else {?>
        <ul>
            <li class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
                <a href="index.php">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'user.php' || $current_page == 'add-user.php'|| $current_page == 'edit-user.php') ? 'active' : '' ?>">
                <a href="user.php">
                    <i class="fa-solid fa-users"></i>
                    <span>Manage Users</span>
                </a>
            </li>
            <li class="<?= $current_page == 'create_task.php' ? 'active' : '' ?>">
                <a href="create_task.php">
                    <i class="fa-solid fa-plus"></i>
                    <span>Create Task</span>
                </a>
            </li>
            <li class="<?= $current_page == 'tasks.php'|| $current_page == 'edit-task.php' ? 'active' : '' ?>">
                <a href="tasks.php">
                    <i class="fa-solid fa-tasks"></i>
                    <span>All Tasks</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fa-solid fa-sign-out"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    <?php }?>
</nav>