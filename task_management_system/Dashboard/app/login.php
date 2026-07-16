<?php
session_start();
include "../DB_connection.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['user_name']) && isset($_POST['password'])) {
    $validates = [
        'user_name' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Username invalid, must start with only one capital letter and be 3-9 letters.',
            'my_options' => ['options' => ['regexp' => '/^[A-Z][a-z]{3,8}$/']],
        ],
        'password' => [
            'filters'    => FILTER_VALIDATE_REGEXP,
            'error'      => 'Password invalid, must be 3-8 letters or digits.',
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
        header('Location:../login.php');
        exit();
    }
    else {
        $user_name = $_POST['user_name'];
        $password  = $_POST['password'];
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_name]);
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            $usernameDb = $user['username'];
            $passwordDb = $user['password'];
            $role = $user['role'];
            $id = $user['id'];
            if ($user_name === $usernameDb) {
                    if (password_verify($password, $passwordDb)) {
                        if ($role == "admin") {
                            $_SESSION['role'] = $role;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $usernameDb;
                            header("Location: ../index.php");
                            exit();
                        }else if ($role == 'employee') {
                            $_SESSION['role'] = $role;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $usernameDb;
                            header("Location: ../index.php");
                            exit();
                        }else {
                        $_SESSION['errors'] = ["Unknown error occurred"];
                        header("Location: ../login.php");
                        exit();
                        }
                    }else {
                    $_SESSION['errors'] = ["Incorrect username or password"];
                    header("Location: ../login.php");
                    exit();
                }
            }else {
                $_SESSION['errors'] = ["Incorrect username or password"];
                header("Location: ../login.php");
                exit();
            }
        }else {
            $_SESSION['errors'] = ["Incorrect username or password"];
            header("Location: ../login.php");
            exit();
        }
        }
    }else {
    $_SESSION['errors'] = ["Unknown error occurred"];
    header("Location: ../login.php");
    exit();
    }
}