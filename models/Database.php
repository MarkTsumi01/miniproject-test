<?php

$serverName = 'mysql';
$userName = 'root';
$password = 'root';
$databaseName = 'mini_test';

$connectDatabase = mysqli_connect(
    $serverName, 
    $userName,
    $password,
    $databaseName
);

if (!$connectDatabase) {
    die('Connection failed: ' . mysqli_connect_error());
}
