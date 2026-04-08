<?php

session_start();

require __DIR__ . '/../Models/Database.php';
require __DIR__ . '/../Models/RecordModel.php';

if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header('Location: index.php?page=login');
    
    exit();
}

$recordId = (int) $_GET['record_id'];
$record = getRecordById($connectDatabase, $recordId);

$errorList = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recordName = $_POST['record_name'];
    $recordId = (int) $_GET['record_id'];
    
    if (empty($recordName)) {
        $errorList['record_name'] = 'Record name is required';
    }
    
    if (empty($errorList)) {
        if ($recordName === $record['name']) {
            updateRecord($connectDatabase, $recordName, $recordId);
            header('Location: index.php?page=recordlist');
            
            exit();
        }
        
        $isRecordAlreadyExists = isRecordExists($connectDatabase, $recordName);
       
        if ($isRecordAlreadyExists) {
           $errorList['record_name'] = 'This name already exists';
       } else {
           updateRecord($connectDatabase, $recordName, $recordId);
           header('Location: index.php?page=recordlist');
           
           exit();
       }
   }
}

require __DIR__ . '/../views/editrecord.php';
