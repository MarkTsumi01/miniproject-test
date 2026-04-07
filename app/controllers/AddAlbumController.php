<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/AlbumModel.php';
require __DIR__ . '/../models/BandModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: index.php?page=login');

    exit();
}

$errorList = [];

$isPostRequest = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($isPostRequest) {
    $albumName = trim($_POST['album_name'] ?? '');

    if (empty($albumName)) {
        $errorList['album_name'] = 'Album name is required';
    }

    if (empty($errorList)) {
        $album = getAlbumByAlbumName($connectDatabase, $albumName);
        $isBandAlreadyExists = isBandExists($connectDatabase, $albumName);

        if ($isBandAlreadyExists) {
            $errorList['band_name'] = 'This band name already exists';
        } else {
            addAlbum($connectDatabase, $bandName, $recordId);
            header('Location: index.php?page=bandlist&record_id=' . $recordId);

            exit();
        }
    }
}

$recordResult = getRecordsWithBandCount($connectDatabase);

session_write_close();

require __DIR__ . '/../views/addband.php';
