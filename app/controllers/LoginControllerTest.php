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
    $password = ($_POST['password']);

    $errorMessage = [];

    if (empty($username)) {
        $errorMessage['username'] = 'Username is required';
    }

    if (empty($password)) {
        $errorMessage['password'] = 'Password is required';
    }

    $user = getUserByUsername($username);

    $isUserValid = (!empty($user));

    if ($isUserValid) {
        $hashPassword = $user['password'];
    }

    $isPasswordValid = password_verify($password, $hashPassword);

    if (!$isPasswordValid) {
        $errorMessage['credential'] = 'Invalid username or password';
    }

    if (empty($errorMessage)) {
        $userId = $user['id'];
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        
        header('Location: index.php?page=recordlist');
    }    
}

require __DIR__ . '/../views/login.php';
