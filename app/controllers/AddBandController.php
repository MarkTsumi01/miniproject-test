<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/BandModel.php';
require __DIR__ . '/../models/RecordModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: index.php?page=login');

    exit();
}

$errorList = [];
$isPostRequest = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($isPostRequest) {
    $bandName = trim($_POST['band_name'] ?? '');
    $recordName = trim($_POST['record_name'] ?? '');

    if (empty($bandName)) {
        $errorList['band_name'] = 'Band name is required';
    }

    if (empty($errorList)) {
        $recordData = getRecordIdByName($connectDatabase, $recordName);
        $recordId = $recordData['id'];

        $isBandAlreadyExists = isBandExists($connectDatabase, $bandName);

        if ($isBandAlreadyExists) {
            $errorList['band_name'] = 'This band name already exists';
        } else {
            insertBand($connectDatabase, $bandName, $recordId);
            header('Location: index.php?page=bandlist');

            exit();
        }
    }
}

$recordResult = getRecordsWithBandCount($connectDatabase);

session_write_close();

require __DIR__ . '/../views/addband.php';
