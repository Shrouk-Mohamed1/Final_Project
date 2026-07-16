<?php
session_start();
include "../DB_connection.php";
if(isset($_SESSION['role'])&&isset($_SESSION['id'])){
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['full_name']) && $_SESSION['role']=='admin') {
    $validates = [
        'user_name' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Username invalid, must start with only one capital letter and be 3-9 letters.',
            'my_options' => ['options' => ['regexp' => '/^[A-Z][a-z]{2,8}$/']],
        ],
        'password' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Password invalid, must be 3-9 letters or digits.',
            'my_options' => ['options' => ['regexp' => '/^[a-zA-Z0-9]{3,8}$/']],
        ],
        'full_name' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Full name invalid, must start with one capital letter and be 7-256 letters.',
            'my_options' => ['options' => ['regexp' => '/^[A-Z][A-Za-z\ ]{6,255}$/']],
        ]
    ];
    $errors = [];
    foreach ($validates as $validate_name => $validate_value) {
        $value = filter_input(
            INPUT_POST,
            $validate_name,
            $validate_value['filters'],
            $validate_value['my_options'] ?? null
        );
        if (empty($_POST[$validate_name])) {
            $errors[$validate_name] = "You must fill $validate_name";
        } elseif ($value === false) {
            $errors[$validate_name] = $validate_value['error'];
        }
    }
    if ($errors) {
        $_SESSION['errors'] = $errors;
        header('Location:../add-user.php');
        exit();
    }
    else {
        $user_name = $_POST['user_name'];
        $password  = $_POST['password'];
        $fullname =$_POST['full_name'];
    include "Model/User.php";
    $password = password_hash($password,PASSWORD_DEFAULT);
    $data=array($fullname,$user_name,$password,"employee");
    insert_user($conn,$data);
        $_SESSION['success'] = "User created successfully";
    header("Location: ../add-user.php");
    exit();
        }
    }else {
    $_SESSION['errors'] = ["Unknown error occurred"];
    header("Location: ../add-user.php");
    exit();
    }
    }else {
        $_SESSION['errors'] = ["First login"];
        header("location:../login.php");
        exit();
    }
}
