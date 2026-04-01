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

    if (isset($_POST['register'])) {
        header('Location: index.php?page=register');
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
        $user = findUserByUsername($connectDatabase, $userName);
        
        if (!isset($user) || !passwordVerify($password, $user['password'])) {
            $errorList['credentials'] = 'Invalid username or password';
        } else {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $userName;
            session_write_close();
            header('Location: index.php?page=recordlist');
            exit();
        }
    }
}

require __DIR__ . '/../views/login.php';
