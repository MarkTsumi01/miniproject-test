<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/AlbumModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: index.php?page=login');

    exit();
}

$bandId = (int) $_GET['band_id'];
$isPostRequest = $_SERVER['REQUEST_METHOD'] === 'POST';
$isDeleteAlbum = isset($_POST['delete_album']);

if ($isPostRequest && $isDeleteAlbum) {
    $albumId = (int) $_POST['delete_album'];

    deleteAlbum($connectDatabase, $albumId);
    header('Location: index.php?page=albumlist&band_id=' . $bandId);

    exit();
}

$albumResult = getAlbumsByBandId($connectDatabase, $bandId);

session_write_close();

require __DIR__ . '/../views/albumlist.php';
