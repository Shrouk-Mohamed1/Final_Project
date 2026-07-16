<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";
    if (!isset($_GET['id'])) {
        header("Location: user.php");
        exit();
    }
    $id = $_GET['id'];
    $user = get_user_by_id($conn, $id);
    if ($user == 0) {
        header("Location: user.php");
        exit();
    }
        $data = array($id, "employee");
        delete_user($conn, $data);
        $_SESSION['success'] = "User is deleted successfully";
        header("Location: user.php");
        exit();
}else{ 
    header("Location: login.php");
    exit();
}
?>