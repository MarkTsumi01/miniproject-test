<?php

session_start();

require __DIR__ . '/../models/BandModel.php';
require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/RecordModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    
    header('Location: index.php?page=login');
    exit();
}

$errorList = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bandName = $_POST['band_name'];
    $recordName = $_POST['record_name'];
    
    $recordData = getRecordId($connectDatabase, $recordName);
    
    $recordId = $recordData['id'];
    
    if (empty($bandName)) {
        $errorList['band_name'] = 'Band name is required';
    }
    
    if (empty($errorList)) {
        
        $isFounded = checkBand($connectDatabase, $bandName);
                
        if ($isFounded) {
            $errorList['band_name'] = 'This band name is already exists';
        } else {
            addBand($connectDatabase, $bandName, $recordId);
            
            header('Location: index.php?page=bandlist');
            exit();
        }
    }
}

$recordResult = getAllRecords($connectDatabase);

require __DIR__ . '/../views/addband.php';
