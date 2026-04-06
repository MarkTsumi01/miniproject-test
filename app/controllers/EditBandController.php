<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/BandModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: index.php?page=login');
    
    exit();
}

$bandId = (int) $_GET['band_id'];
$recordId = $_GET['record_id'];

$band = getBandByBandId($connectDatabase, $bandId);

$errorList = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bandName = $_POST['band_name'];
    
    if (empty($bandName)) {
        $errorList['band_name'] = 'Band name is required';
    }
    
    if (empty($errorList)) {
        if ($bandName === $band['name']) {
            updateBand($connectDatabase, $bandName, $bandId);
            header('Location: index.php?page=bandlist&record_id=' . $recordId);
            
            exit();
        }
        
        $isBandAlreayExists = isBandExists($connectDatabase, $bandName);
       
        if ($isBandAlreayExists) {
           $errorList['band_name'] = 'This band already exists';
       } else {
           updateBand($connectDatabase, $bandName, $bandId);
           header('Location: index.php?page=bandlist&record_id=' . $recordId);
           
           exit();
       }
   }
}

require __DIR__ . '/../views/editband.php';
