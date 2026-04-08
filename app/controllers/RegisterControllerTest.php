<?php

session_start();

require __DIR__ . '/../Models/UserModel.php';

const RECORDLIST_PAGE = 'index.php?page=recordlist';
const LOGIN_PAGE = 'index.php?page=login';

function redirect(string $url): void
{
    header("Location: $url");

    exit();
}

function validateRegisterInput(string $username, string $password): array
{
    $errorData = array_filter([
        'username' => !$username ? 'Username is required'
            : (stripos($username, ' ') !== false ? 'Username must not contain space' : null),
        'password' => $password ? null : 'Password is required',
    ]);

    return $errorData; 
}

function handleRegister(string $username, string $password): bool
{
    $user = getUserByUsername($username);
    if (!empty($user)) {

        return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $newUserId = addUser($username, $hashedPassword);
    $_SESSION['user_id'] = $newUserId;
    $_SESSION['username'] = $username;

    return true;
}

if (isset($_SESSION['user_id'])) {
    redirect(RECORDLIST_PAGE);
}

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

if ($isPost && isset($_POST['login'])) {
    redirect(LOGIN_PAGE);
}

$errorData = [];

if ($isPost) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $errorData = validateRegisterInput($username, $password);

    if (empty($errorData) && !handleRegister($username, $password)) {
        $errorData['username'] = 'Username already exists';
    }

    if (empty($errorData)) {
        redirect(RECORDLIST_PAGE);
    }
}

require __DIR__ . '/../views/register.php';
