<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/BandModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: index.php?page=login');
    exit();
}

$recordId = $_GET['record_id'];

$bandResult = getAllBands($connectDatabase, $recordId);

require __DIR__ . '/../views/bandlist.php';
