<?php

session_start();
require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/UserModel.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php?page=recordlist');

    exit();
}

$errorList = [];

$isPostRequest = $_SERVER['REQUEST_METHOD'] === 'POST';
$isRegister = isset($_POST['register']);

if ($isPostRequest) {
    if ($isRegister) {
        header('Location: index.php?page=register');

        exit();
    }

    $userName = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($userName)) {
        $errorList['username'] = 'Username is required';
    }

    if (stripos($userName, ' ')) {
        $errorList['username'] = 'Username must not contain space';
    }

    if (empty($password)) {
        $errorList['password'] = 'Password is required';
    }

    if (empty($errorList)) {
        $user = findUserByUsername($connectDatabase, $userName);
        
        $isUserNotFound = ($user === null);
        $isPasswordInvalid = (!password_verify($password, $user['password']));

        if ($isUserNotFound || $isPasswordInvalid) {
            $errorList['credentials'] = 'Invalid username or password';
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $userName;
            session_write_close();
            header('Location: index.php?page=recordlist');

            exit();
        }
    }
}

require __DIR__ . '/../views/login.php';
