<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/UserModel.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php?page=recordlist');
    
    exit();
}

$isPostRequest = ($_SERVER['REQUEST_METHOD'] === 'POST');
$isLogin = isset($_POST['login']);

if ($isPostRequest) {
    if ($isLogin) {
        header('Location: index.php?page=login');
        
        exit();
    }

    $errorData = [];

    $userName = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($userName)) {
        $errorData['username'] = 'Username is required';
    }

    if (stripos($userName, ' ') !== false) {
        $errorData['username'] = 'Username must not contain space';
    }

    if (empty($password)) {
        $errorData['password'] = 'Password is required';
    }

    if (empty($errorData)) {
        $user = getUserByUserName($connectDatabase, $userName);

        $isUserNotFound = ($user === null);
        
        if (!$isUserNotFound) {
            $errorData['username'] = 'Username is already exists';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $newuserId = addUser($connectDatabase, $userName, $hashedPassword);

            $_SESSION['user_id'] = $newuserId;
            $_SESSION['username'] = $userName;
        }

        header('Location: index.php?page=recordlist');

        exit();
    }
}

require __DIR__ . '/../views/register.php';
