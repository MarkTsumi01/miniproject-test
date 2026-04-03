<?php

session_start();

require __DIR__ . '/../models/BandModel/php';
require __DIR__ . '/../models/Database.php';

if (isset($_SESSION['user_id'])) {
    session_write_close();
    
    header('Location : index.php?page=login');
    exit();
}

$errorList = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bandName = $_POST['band_name'];
    
    if (empty($bandName)) {
        $errorList = ['Band name is required'];
    }
    
    if (empty($errorList)) {
        
        $isFounded = checkBand($connectDatabase, $bandName);
        
        if ($isFounded) {
            $errorList = ['This band name is already exists'];
        } else {
            addBand($connectDatabase, $bandName);
            
            header('Location : index.php?page=bandlist');
            exit();
        }
    }
}
