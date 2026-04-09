<?php

session_start();

require __DIR__ . '/../Models/UserModel.php';

const RECORDLIST_PAGE = 'index.php?page=recordlist';
const LOGIN_PAGE = 'index.php?page=login';

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

    if (stripos($username, ' ')) {
        $errorMessage['username'] = 'Username must not contain space';
    }

    if (empty($password)) {
        $errorMessage['password'] = 'Password is required';
    }

    return $errorMessage;
}

function isUserNameExist(string $username): bool
{
    $user = getUserByUsername($username);

    $result = (!empty($user));

    return $result;
}

function register(string $username, string $password): int
{
    $isUsernameExist = isUserNameExist($username);

    if ($isUsernameExist) {
        return 0;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $newUserid = addUser($username, $hashedPassword);

    return $newUserid;
}

if (isset($_SESSION['user_id'])) {
    redirect(RECORDLIST_PAGE);
}

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

if ($isPost && isset($_POST['login'])) {
    redirect(LOGIN_PAGE);
}

if ($isPost) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $errorMessage = getErrorMessage($username, $password);

    if (empty($errorMessage)) {
        $newUserid = register($username, $password);
        $isRegisterSuccess = ($newUserid != 0);

        if ($isRegisterSuccess) {
            $_SESSION['user_id'] = $newUserid;
            $_SESSION['username'] = $username;

            redirect(RECORDLIST_PAGE);
        } else {
            $errorMessage['username'] = 'Username already exists';
        }
    }
}

require __DIR__ . '/../views/register.php';
