<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/BandModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: index.php?page=login');

    exit();
}

$isPostRequest = $_SERVER['REQUEST_METHOD'] === 'POST';
$isDeleteBand = isset($_POST['delete_band']);

if ($isPostRequest && $isDeleteBand) {
    $bandId = (int) $_POST['delete_band'];

    deleteBand($connectDatabase, $bandId);
    header('Location: index.php?page=bandlist');

    exit();
}

$recordId = (int) $_GET['record_id'];
$bandResult = getBandsByRecordId($connectDatabase, $recordId);

session_write_close();

require __DIR__ . '/../views/bandlist.php';
