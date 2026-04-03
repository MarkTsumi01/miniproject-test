<?php

session_start();

require __DIR__ . '/../models/Database.php';
require __DIR__ . '/../models/RecordModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    
    header('Location: index.php?page=login');
    exit();
}

$errorList = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recordName = $_POST['record_name'];
    
    if (empty($recordName)) {
        $errorList['record_name'] = 'Record name is required';
    }
    
    if (empty($errorList)) {
       
        $isFounded = checkRecord($connectDatabase, $recordName);
       
        if ($isFounded) {
           $errorList['record_name'] = 'This name already exists';
       } else {
           addRecord($connectDatabase, $recordName);
           
           header('Location: index.php?page=recordlist');
           exit();
       }
   }
}

require __DIR__ . '/../views/addrecord.php';
