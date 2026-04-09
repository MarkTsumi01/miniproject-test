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

function getErrorData(string $username, string $password): array
{
    $errorData = [];

    if (empty($username)) {
        $errorData['username'] = 'Username is required';
    }

    if (stripos($username, ' ')) {
        $errorData['username'] = 'Username must not contain space';
    }

    if (empty($password)) {
        $errorData['password'] = 'Password is required';
    }

    return $errorData;
}

function isUserNameTaken(string $username): bool
{
    $user = getUserByUsername($username);

    $result = (!empty($user)) ? true : false;

    return $result;
}

function getHashedPassword(string $password): string
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    return $hashedPassword;
}

function getNewUserid(string $username, string $password): int
{
    $isUsernameTaken = isUserNameTaken($username);

    if ($isUsernameTaken) {
        return 0;
    }

    $hashedPassword = getHashedPassword($password);

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

    $errorData = getErrorData($username, $password);

    if (empty($errorData)) {
        $newUserid = getNewUserid($username, $password);
        $isRegister = ($newUserid != 0);

        if ($isRegister) {
            $_SESSION['user_id'] = $newUserid;
            $_SESSION['username'] = $username;

            redirect(RECORDLIST_PAGE);
        } else {
            $errorData['username'] = 'Username already exists';
        }
    }
}

require __DIR__ . '/../views/register.php';
