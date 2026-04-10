<?php

session_start();

require __DIR__ . '/../Models/UserModel.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php?page=recordlist');

    exit();
}

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

if ($isPost) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $errorMessage = [];

    if (empty($username)) {
        $errorMessage['username'] = 'Username is required';
    }

    if (stripos($username, ' ')) {
        $errorMessage['username'] = 'Username must not contain space';
    }

    if (empty($password)) {
        $errorMessage['password'] = 'Password is required';
    }

    if (empty($errorMessage)) {
        $user = getUserByUsername($username);

        $isUserExist = !(empty($user));

        if ($isUserExist) {
            $errorMessage['credential'] = 'Username already exist';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $newUserId = addUser($username, $hashedPassword);

            $_SESSION['user_id'] = $newUserId;
            $_SESSION['username'] = $username;

            header('Location: index.php?page=recordlist');

            exit();
        }
    }
}

require __DIR__ . '/../views/register.php';
