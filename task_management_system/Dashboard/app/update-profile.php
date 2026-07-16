<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
if (isset($_POST['confirm_password']) && isset($_POST['new_password']) && isset($_POST['password']) && isset($_POST['full_name']) && $_SESSION['role'] == 'employee') {
	include "../DB_connection.php";
    $validates = [
        'full_name' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Username invalid, must start with one capital letter and be 7-255 letters.',
            'my_options' => ['options' => ['regexp' => '/^[A-Z][A-Za-z\ ]{6,255}$/']],
        ],
        'password' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Old Password invalid, must be 3-8 letters or digits.',
            'my_options' => ['options' => ['regexp' => '/^[a-zA-Z0-9]{3,8}$/']],
        ],
        'new_password' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'New Password invalid, must be 3-8 letters or digits.',
            'my_options' => ['options' => ['regexp' => '/^[a-zA-Z0-9]{3,8}$/']],
        ],
        'confirm_password' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Confirm Password invalid, must be 3-8 letters or digits.',
            'my_options' => ['options' => ['regexp' => '/^[a-zA-Z0-9]{3,8}$/']],
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
        header('Location:../edit_profile.php');
        exit();
	}else {
        $full_name = $_POST['full_name'];
        $password  = $_POST['password'];
        $new_password =$_POST['new_password'];
        $confirm_password=$_POST['confirm_password'];
        $id=$_SESSION['id'];
        if ($new_password !== $confirm_password) {
            $_SESSION['errors'] = ['confirm_password' => 'The new password and confirm password do not match.'];
            header('Location:../edit_profile.php');
            exit();
        }
        include "Model/User.php";
        $user = get_user_by_id($conn, $id);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $data = array($full_name, $new_password, $id);
                    update_profile($conn, $data);
                    $_SESSION['success'] = "password updated successfully";
            header("Location: ../edit_profile.php?id=" . ($id));
            exit();
                    }else {
                        $em = "Incorrect password";
                    header("Location: ../edit_profile.php?error=$em");
                    exit();
                    }
            }else {
                $em = "Unknown error occurred";
                header("Location: ../edit_profile.php?error=$em");
                exit();
            }
        
        }
}else {
    $em = "Unknown error occurred";
    header("Location: ../edit_profile.php?error=$em");
    exit();
}
}else{ 
    header("Location: ../login.php");
    exit();
}
?>