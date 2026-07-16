<?php
session_start();
include "../DB_connection.php";
if(isset($_SESSION['role'])&&isset($_SESSION['id'])){
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])&&isset($_POST['status']) && $_SESSION['role']=='employee') {
    $validates = [
        'status' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Invalid status.',
            'my_options' => ['options' => ['regexp' => '/^(in_progress|pending|completed)$/']],
        ],
        'id' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Invalid user id.',
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
        header('Location:../edit-task-employee.php?id=' .$_POST['id']);
        exit();
    }
    else {
    $status = $_POST['status'];
    $task_id = $_POST['id'];
    $employee_id = $_SESSION['id'];
    include "Model/Task.php";
    $task = get_task_by_id($conn, $task_id);
    if ($task && $task['assigned_to'] == $employee_id) {
        $data = array($status, $task_id);
        update_task_status($conn, $data);
        $_SESSION['success'] = "Task updated successfully";
        header("Location: ../edit-task-employee.php?id=" . $task_id);
        exit();
    } else {
        $_SESSION['errors'] = ["You do not have permission to edit this task"];
        header("Location: ../edit-task-employee.php?id=" . $task_id);
        exit();
    }
    }
}else {
    $_SESSION['errors'] = ["Unknown error occurred"];
    header("Location: ../edit-task-employee.php");
    exit();
    }
    }else{ 
    $_SESSION['errors'] = ["First login"];
    header("Location: ../login.php");
    exit();
    }
}