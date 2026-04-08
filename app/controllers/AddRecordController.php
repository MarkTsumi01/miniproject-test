<?php

session_start();

require __DIR__ . '/../Models/Database.php';
require __DIR__ . '/../Models/RecordModel.php';

const LOGIN_PAGE = 'index.php?page=login';
const RECORDLIST_PAGE = 'index.php?page=recordlist';

function redirect($url): void
{
    header('Location ' . $url);

    exit();
}

if (!isset($_SESSION['user_id'])) {
    redirect(LOGIN_PAGE);
}

$isPostRequest = ($_SERVER['REQUEST_METHOD'] === 'POST');

if ($isPostRequest) {
    $recordName = trim($_POST['record_name'] ?? '');
    
    $errorList = [];

    if (empty($recordName)) {
        $errorList['record_name'] = 'Record name is required';
    }

    if (empty($errorList)) {
        $isRecordAlreadyExists = isRecordExists($recordName);

        if ($isRecordAlreadyExists) {
            $errorList['record_name'] = 'This name already exists';
        } else {
            addRecord($recordName);

            redirect(RECORDLIST_PAGE);
        }
    }
}

require __DIR__ . '/../views/addrecord.php';
