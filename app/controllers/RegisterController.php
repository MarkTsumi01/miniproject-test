<?php

session_start();

require __DIR__ . '/../Models/UserModel.php';

const RECORDLIST_PAGE_PATH = 'index.php?page=recordlist';

function redirect(string $url): void
{
    header('Location: ' . $url);

    exit();
}

if (isset($_SESSION['user_id'])) {
    redirect(RECORDLIST_PAGE_PATH);
}

function register(string $username, string $hashedPassword): int
{
    $newUserId = addUser($username, $hashedPassword);

    return $newUserId;
}

function getErrorMessage(string $username, string $password): array
{
    $errorMessage = [];

    if (empty($username)) {
        $errorMessage['username'] = 'Username is required';
    }

    if (stripos($username, ' ')) {
        $errorMessage['username'] = 'Username must not contain space';
    }

    $user = getUserByUsername($username);

    if (!empty($user)) {
        $errorMessage['username'] = 'Username already exists';
    }

    if (empty($password)) {
        $errorMessage['password'] = 'Password is required';
    }

    return $errorMessage;
}

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

if ($isPost) {
    $username = trim($_POST['username']);
    $password = ($_POST['password']);

    $errorMessage = getErrorMessage($username, $password);

    if (empty($errorMessage)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $newUserId = register($username, $hashedPassword);

        $_SESSION['user_id'] = $newUserId;
        $_SESSION['password'] = $username;

        redirect(RECORDLIST_PAGE_PATH);
    }
}

require __DIR__ . '/../views/register.php';
