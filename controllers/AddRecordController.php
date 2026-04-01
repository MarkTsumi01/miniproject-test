<?php

session_start();

include 'connectdatabase.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: login.php');
    exit();
}

$errorList = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recordName = $_POST['record_name'];
    
    if (empty($recordName)) {
        $errorList['record_name'] = 'Record name is required';
    }
    
    if (empty($errorList)) {
       $checkRecordName = $connectDatabase->prepare('SELECT id FROM records WHERE name = ?');
       $checkRecordName->bind_param('s', $recordName);
       $checkRecordName->execute();
       $checkRecordName->store_result();
       
        if ($checkRecordName->num_rows > 0) {
           $errorList['record_name'] = 'This name already exists';
       } else {
           $addRecord = $connectDatabase->prepare('INSERT INTO records (name) VALUES (?)');
           $addRecord->bind_param('s', $recordName);
           $addRecord->execute();
           
           header('Location: recordlist_test.php');
           exit();
       }
   }
   
   $checkRecordName->close();
}
