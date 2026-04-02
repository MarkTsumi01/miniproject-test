<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/UserModel.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php?page=recordlist');
    exit();
}

$errorList = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        header('Location: index.php?page=login');
        exit();
    }

    $userName = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($userName)) {
        $errorList['username'] = 'Username is required';
    }
    
    if (empty($password)) {
        $errorList['password'] = 'Password is required';
    }

    if (empty($errorList)) {
        if (existsByUsername($connectDatabase, $userName)) {
            $errorList['username'] = 'Username already exists';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $newUserId = createUser($connectDatabase, $userName, $hashedPassword);

            session_regenerate_id(true);
            $_SESSION['user_id'] = $newUserId;
            $_SESSION['username'] = $userName;
            session_write_close();
            header('Location: index.php?page=recordlist');
            exit();
        }
    }
}

require __DIR__ . '/../views/register.php';
