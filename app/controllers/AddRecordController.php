<?php

session_start();

require __DIR__ . '/../Models/Database.php';
require __DIR__ . '/../Models/RecordModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: index.php?page=login');

    exit();
}

$errorList = [];
$isPostRequest = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($isPostRequest) {
    $recordName = trim($_POST['record_name'] ?? '');

    if (empty($recordName)) {
        $errorList['record_name'] = 'Record name is required';
    }

    if (empty($errorList)) {
        $isRecordAlreadyExists = isRecordExists($connectDatabase, $recordName);

        if ($isRecordAlreadyExists) {
            $errorList['record_name'] = 'This name already exists';
        } else {
            insertRecord($connectDatabase, $recordName);
            header('Location: index.php?page=recordlist');

            exit();
        }
    }
}

session_write_close();

require __DIR__ . '/../views/addrecord.php';
