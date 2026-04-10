<?php

session_start();

require __DIR__ . '/../Models/UserModel.php';

const RECORDLIST_PAGE_PATH = 'index.php?page=recordlist';

function redirect(string $url): void
{
    header('Location: ' . $url);

    exit();
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

    return $errorMessage;
}

function isCredentialValid(string $username, string $password): bool
{
    $user = getUserByUsername($username);
    $isUservalid = (!empty($user));
    
    if ($isUservalid) {
        $hashPassword = $user['password'];
        $isPasswordValid = password_verify($password, $hashPassword);
    }

    if ($isPasswordValid) {
        return true;
    }

    return false;
}

if (isset($_SESSION['user_id'])) {
    redirect(RECORDLIST_PAGE_PATH);
}

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

if ($isPost) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $errorMessage = getErrorMessage($username, $password);
    $isCredentialValid = isCredentialValid($username, $password);

    if (!$isCredentialValid) {
        $errorData['credentials'] = 'Invalid username or password';
    }

    if (empty($errorMessage)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;

        redirect(RECORDLIST_PAGE_PATH);
    }
}

require __DIR__ . '/../views/login.php';
