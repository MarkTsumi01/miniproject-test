<?php

session_start();

require __DIR__ . '/../Models/UserModel.php';

const RECORDLIST_PAGE_PATH = 'index.php?page=recordlist';

function redirect($url): void
{
    header('Location: ' . $url);

    exit();
}

if (isset($_SESSION['user_id'])) {
    redirect(RECORDLIST_PAGE_PATH);
}

function getErrorMessage(string $username, string $password): array
{
    $errorMessage = [];

    if (empty($username)) {
        $errorMessage['username'] = 'Username is required';
    }

    if (empty($password)) {
        $errorMessage['password'] = 'Password is required';
    }

    if (empty($errorMessage)) {
        $user = getUserByUsername($username);

        if (!empty($user)) {
            $hashedPassword = $user['password'];
            $isPasswordInvalid = password_verify($password, $hashedPassword);
        }

        if (!$isPasswordInvalid) {
            $errorMessage['credentials'] = 'Invalid username or password';
        }
    }

    return $errorMessage;
}

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

if ($isPost) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $errorMessage = getErrorMessage($username, $password);

    if (empty($errorMessage)) {
        $user = getUserByUsername($username);
        $userId = $user['id'];

        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;

        redirect(RECORDLIST_PAGE_PATH);
    }
}

require __DIR__ . '/../views/login.php';
