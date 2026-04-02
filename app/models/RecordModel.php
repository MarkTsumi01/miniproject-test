<?php

function getAllRecords(mysqli $database)
{
    $statement = $database->prepare('
        SELECT records.id, records.name, COUNT(bands.id) AS band_count
        FROM records
        LEFT JOIN bands ON bands.record_id = records.id
        GROUP BY records.id, records.name
        ORDER BY records.name ASC
    ');
    
    $statement->execute();
    $recordResult = $statement->get_result();
    $statement->close();
    
    return $recordResult;
}

function checkRecordByName(mysqli $database, string $recordName): bool 
{
    $statement = $database->prepare('
        SELECT id 
        FROM records 
        WHERE name = ?
    ');
    
    $statement->bind_param('s', $recordName);
    $statement->execute();
    $statement->store_result();
    
    $isFounded = ($statement->num_rows > 0) ? true : false;
    $statement->close();
    
    return $isFounded;
}

function addRecordById(mysqli $database, string $recordName): void
{
    $statement = $database->prepare('
        INSERT INTO records (name) 
        VALUES (?)
    ');
    
    $statement->bind_param('s', $recordName);
    $statement->execute();
    $statement->close();
}

function deleteByRecordId(mysqli $database,int $recordId): void
{
    $statement = $database->prepare('
        DELETE 
        FROM records 
        WHERE id = ?
    ');
    
    $statement->bind_param('i', $recordId);
    $statement->execute();
    $statement->close();
}
