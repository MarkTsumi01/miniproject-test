<?php

session_start();

require __DIR__ . '/../Models/UserModel.php';

const RECORDLIST_PAGE = 'index.php?page=recordlist';
const REGISTER_PAGE = 'index.php?page=register';

function redirect(string $url): void
{
    header('Location: ' . $url);

    exit();
}

function getErrorData(string $username, string $password): array
{
    $errorData = [];

    if (empty($username)) {
        $errorData['username'] = 'Username is required';        
    }

    if (empty($password)) {
        $errorData['password'] = 'Password is required';
    }

    return $errorData;
}

function handleLogin(string $username, string $password): bool
{
    $user = getUserByUsername($username);
    $isUserInvalid = empty($user);
    $isPasswordInvalid = !password_verify($password, $user['password']);

    if ($isUserInvalid || $isPasswordInvalid) {
        return false;
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $username;

    return true;
}

if (isset($_SESSION['user_id'])) {
    redirect(RECORDLIST_PAGE);
}

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

if ($isPost && isset($_POST['register'])) {
    redirect(REGISTER_PAGE);
}

if ($isPost) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $errorData = getErrorData($username, $password);

    if (empty($errorData) && !handleLogin($username, $password)) {
        $errorData['credentials'] = 'Invalid username or password';
    }

    if (empty($errorData)) {
        redirect(RECORDLIST_PAGE);
    }
}

require __DIR__ . '/../views/login.php';
