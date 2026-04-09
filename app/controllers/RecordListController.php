<?php

session_start();

require __DIR__ . '/../Models/RecordModel.php';

const LOGIN_PAGE = 'index.php?page=login';
const RECORDLIST_PAGE = 'index.php?page=recordlist';

function redirect(string $url): void
{
    header('Location: ' . $url);

    exit();
}

if (!isset($_SESSION['user_id'])) {
    redirect(LOGIN_PAGE);
}

$isPostRequest = $_SERVER['REQUEST_METHOD'] === 'POST';
$isDeleteRecord = isset($_POST['delete_record_id']);
$isLogout = isset($_POST['logout']);

if ($isPostRequest && $isDeleteRecord) {
    $recordId = (int) $_POST['delete_record_id'];
    
    deleteRecord($recordId);

    redirect(RECORDLIST_PAGE);
}

if ($isPostRequest && $isLogout) {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');

    redirect(LOGIN_PAGE);
}

$recordsResult = getRecordsWithBandCount($connectDatabase);

require __DIR__ . '/../views/recordlist.php';
