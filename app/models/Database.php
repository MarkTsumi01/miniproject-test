<?php

$serverName = 'mysql';
$userName = 'root';
$password = 'root';
$databaseName = 'mini_test';

$connectDatabase = new mysqli($serverName, $userName, $password, $databaseName);

if ($connectDatabase->connect_error) {
    error_log('Connection failed: ' . $connectDatabase->connect_error);
    
    die('Something went wrong. Please try again later.');
}
