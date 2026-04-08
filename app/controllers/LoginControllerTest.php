<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/UserModel.php';

const RECORD_LIST_PAGE = 'index.php?page=recordlist';
const REGISTER_PAGE    = 'index.php?page=register';

function redirect(string $url): void
{
    header("Location: $url");
    exit();
}

function validateLoginInput(string $username, string $password): array
{
    return array_filter([
        'username' => $username ? null : 'Username is required',
        'password' => $password ? null : 'Password is required',
    ]);
}

function attemptLogin(string $username, string $password): bool
{
    $user = getUserByUsername($username);

    if (empty($user) || !password_verify($password, $user['password'])) {

        return false;
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $username;

    return true;
}

if (isset($_SESSION['user_id'])) {
    redirect(RECORD_LIST_PAGE);
}

$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($isPost && isset($_POST['register'])) {
    redirect(REGISTER_PAGE);
}

$errorData = [];

if ($isPost) {
    $username  = trim($_POST['username'] ?? '');
    $password  = $_POST['password'] ?? '';

    $errorData = validateLoginInput($username, $password);

    if (empty($errorData) && !attemptLogin($username, $password)) {
        $errorData['credentials'] = 'Invalid username or password';
    }

    if (empty($errorData)) {
        redirect(RECORD_LIST_PAGE);
    }
}

require __DIR__ . '/../views/login.php';
