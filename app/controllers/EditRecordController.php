<?php

session_start();

require __DIR__ . '/../Models/RecordModel.php';

const RECORDLIST_PAGE_PATH = 'index.php?page=recordlist';
const LOGIN_PAGE_PATH = 'index.php?page=login';

function redirect(string $url): void
{
    header('Location: ' . $url);

    exit();
}

if (!isset($_SESSION['user_id'])) {
    redirect(LOGIN_PAGE_PATH);
}

$errorList = [];

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

if ($isPost) {
    $recordName = $_POST['record_name'];
    $recordId = (int) $_GET['record_id'];

    if (empty($recordName)) {
        $errorList['record_name'] = 'Record name is required';
    }

    $record = getRecordById($recordId);

    if (empty($errorList)) {
        if ($recordName === $record['name']) {
            updateRecord($recordName, $recordId);
            header('Location: index.php?page=recordlist');

            exit();
        }

        $isRecordAlreadyExists = isRecordExists($recordName);

        if ($isRecordAlreadyExists) {
            $errorList['record_name'] = 'This name already exists';
        } else {
            updateRecord($recordName, $recordId);
            header('Location: index.php?page=recordlist');

            exit();
        }
    }
}

require __DIR__ . '/../views/editrecord.php';
