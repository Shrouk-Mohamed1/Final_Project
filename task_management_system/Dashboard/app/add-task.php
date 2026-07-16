<?php
session_start();
include "../DB_connection.php";
if(isset($_SESSION['role'])&&isset($_SESSION['id'])){
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['assigned_to']) && $_SESSION['role']=='admin'
    && isset($_POST['due_date'])) {
    $validates = [
        'title' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Title invalid, must be 3-100 letters, digits or spaces.',
            'my_options' => ['options' => ['regexp' => '/^[A-Za-z0-9\ ]{3,100}$/']],
        ],
        'description' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Description invalid, must be 10-1000 characters.',
            'my_options' => ['options' => ['regexp' => '/^.{10,1000}$/s']],
        ],
        'assigned_to' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Invalid assigned user.',
            'my_options' => ['options' => ['regexp' => '/^[1-9][0-9]*$/']],
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
            $errors[$validate_name] = "$validate_name is required";
        } elseif ($value === false) {
            $errors[$validate_name] = $validate_value['error'];
        }
    }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            header('Location:../create_task.php');
            exit();
        }
        else {
            $title = $_POST['title'];
            $description  = $_POST['description'];
            $assigned_to =$_POST['assigned_to'];
            $due_date=$_POST['due_date'];
    include "Model/Task.php";
        $data = array($title, $description, $assigned_to,$due_date);
        insert_task($conn, $data);
        $_SESSION['success'] = "Task created successfully";
            header("Location: ../create_task.php");
            exit();
        
        }
    }else {
    $_SESSION['errors'] = ["Unknown error occurred"];
    header("Location: ../create_task.php");
    exit();
    }
    }else{ 
    $_SESSION['errors'] = ["First login"];
    header("Location: ../login.php");
    exit();
    }
}