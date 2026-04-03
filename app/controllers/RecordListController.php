<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/RecordModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: index.php?page=login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_record_id'])) {
    $recordId = $_POST['delete_record_id'];    
    deleteRecord($connectDatabase, $recordId);
    
    header('Location: index.php?page=recordlist');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // $_SESSION = [];
    // $cookieParams = session_get_cookie_params();
    // setcookie(
    //     session_name(),
    //     '',
    //     time() - 3600,
    //     $cookieParams['path'],
    //     $cookieParams['domain'],
    //     $cookieParams['secure'],
    //     $cookieParams['httponly']
    // );
    
    // session_start();
    session_unset(); 
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
    header('Location: index.php?page=login');
    exit();
}

$recordsResult = getAllRecords($connectDatabase);

session_write_close();

require __DIR__ . '/../views/recordlist.php';
