<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/UserModel.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php?page=recordlist');
    
    exit();
}

$isPostRequest = ($_SERVER['REQUEST_METHOD'] === 'POST');
$isRegister = isset($_POST['register']);

if ($isPostRequest) {
    if ($isRegister) {
        header('Location: index.php?page=register');
        
        exit();
    }

    $errorData = [];

    $userName = trim($_POST['username'] ?? '');
    $password = ($_POST['password'] ?? '');

    if (empty($userName)) {
        $errorData['username'] = 'Username is required';
    }

    if (empty($password)) {
        $errorData['password'] = 'Password is required';
    }

    if (empty($errorData)) {
        $user = getUserByUserName($connectDatabase, $userName);

        $isUserNotFound = ($user === null);
        $isPasswordInvalid = !password_verify($password, $user['password']);
        $isInValidCredential = ($isUserNotFound || $isPasswordInvalid);

        if ($isInValidCredential) {
            $errorData['credentials'] = 'Invalid username or password';
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $userName;
        }

        header('Location: index.php?page=recordlist');

        exit();
    }
}

require __DIR__ . '/../views/login.php';
