<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/RecordModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: index.php?page=login');

    exit();
}

$isPostRequest = $_SERVER['REQUEST_METHOD'] === 'POST';
$isDeleteRecord = isset($_POST['delete_record_id']);
$isLogout = isset($_POST['logout']);

if ($isPostRequest && $isDeleteRecord) {
    $recordId = (int) $_POST['delete_record_id'];
    
    deleteRecord($connectDatabase, $recordId);
    
    header('Location: index.php?page=recordlist');

    exit();
}

if ($isPostRequest && $isLogout) {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
    header('Location: index.php?page=login');

    exit();
}

$recordsResult = getRecordsWithBandCount($connectDatabase);

session_write_close();

require __DIR__ . '/../views/recordlist.php';
