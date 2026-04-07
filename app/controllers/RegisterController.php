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
$isLogin = isset($_POST['login']);

if ($isPostRequest) {
    if ($isLogin) {
        header('Location: index.php?page=login');
        
        exit();
    }

    $userName = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($userName)) {
        $errorList['username'] = 'Username is required';
    }

    if (stripos($userName, ' ') !== false) {
        $errorList['username'] = 'Username must not contain space';
    }

    if (empty($password)) {
        $errorList['password'] = 'Password is required';
    }

    if (empty($errorList)) {
        $user = getUserByUserName($connectDatabase, $userName);

        $isUserNotFound = ($user === null);
        
        if ($isUserNotFound) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $newuserId = addUser($connectDatabase, $userName, $hashedPassword);
            
            $_SESSION['user_id'] = $newuserId;
            $_SESSION['username'] = $userName;
            session_write_close();
            header('Location: index.php?page=recordlist');
            
            exit();
        } else {
            $errorList['username'] = 'Username is already exists';    
        }
    }
}

require __DIR__ . '/../views/register.php';
