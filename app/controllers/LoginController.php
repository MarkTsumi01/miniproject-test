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

function passwordVerify(string $password, string $hashPassword): bool
{
    $isPasswordvalid = password_verify($password, $hashPassword);

    if ($isPasswordvalid) {
        return true;
    }

    return false;
}

function isCredentialCorrect(string $username, string $password): bool
{
    $user = getUserByUsername($username);
    $isUservalid = !empty($user);
    
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
    redirect(RECORDLIST_PAGE);
}

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

if ($isPost && isset($_POST['register'])) {
    redirect(REGISTER_PAGE);
}

if ($isPost) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $errorMessage = getErrorMessage($username, $password);
    $isCredentialCorrect = isCredentialCorrect($username, $password);

    if (empty($errorMessage) && !$isCredentialCorrect) {
        $errorData['credentials'] = 'Invalid username or password';
    }

    if (empty($errorMessage)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;

        redirect(RECORDLIST_PAGE);
    }
}

require __DIR__ . '/../views/login.php';
