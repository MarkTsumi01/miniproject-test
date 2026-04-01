<?php

function getAllRecords(mysqli $db)
{
    $stmt = $db->prepare('
        SELECT records.id, records.name, COUNT(bands.id) AS band_count
        FROM records
        LEFT JOIN bands ON bands.record_id = records.id
        GROUP BY records.id, records.name
        ORDER BY records.name ASC
    ');
    
    $stmt->execute();
    $recordResult = $stmt->get_result();
    $stmt->close();
    
    return $recordResult;
}

function checkRecordByName(mysqli $db, string $recordName): bool 
{
    $checkRecordName = $db->prepare('SELECT id FROM records WHERE name = ?');
    $checkRecordName->bind_param('s', $recordName);
    $checkRecordName->execute();
    $checkRecordName->store_result();
    
    $isFounded = ($checkRecordName->num_rows > 0) ? true : false;
    $checkRecordName->close();
    
    return $isFounded;
}

function addRecordById(mysqli $db, string $recordName): void
{
    $statement = $db->prepare('INSERT INTO records (name) VALUES (?)');
    $statement->bind_param('s', $recordName);
    $statement->execute();
    $statement->close();
}

function deleteByRecordId(mysqli $db,int $recordId): void
{
    $deleteStmt = $db->prepare('DELETE FROM records WHERE id = ?');
    $deleteStmt->bind_param('i', $recordId);
    $deleteStmt->execute();
    $deleteStmt->close();
}

