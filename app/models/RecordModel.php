<?php

function getAllRecords(mysqli $connectDatabase)
{
    $statement = $connectDatabase->prepare('
        SELECT 
            records.id, 
            records.name, 
            COUNT(bands.id) AS band_count
        FROM 
            records
        LEFT JOIN 
            bands 
            ON bands.record_id = records.id
        GROUP BY 
            records.id, 
            records.name
        ORDER BY 
            records.name ASC
    ');
    
    $statement->execute();
    $recordResult = $statement->get_result();
    $statement->close();
    
    return $recordResult;
}

function getRecord(mysqli $connectDatabase, int $recordId): array
{
    $statement = $connectDatabase->prepare('
        SELECT 
            id, 
            name 
        FROM 
            records 
        WHERE 
            id = ?
    ');
    
    $statement->bind_param('i', $recordId);
    $statement->execute();
    
    $record = $statement->get_result()->fetch_assoc();
    $statement->close();
    
    return $record;
}

function checkRecord(mysqli $connectDatabase, string $recordName): bool 
{
    $statement = $connectDatabase->prepare('
        SELECT 
            id 
        FROM 
            records 
        WHERE 
            name = ?
    ');
    
    $statement->bind_param('s', $recordName);
    $statement->execute();
    $statement->store_result();
    
    $isFounded = ($statement->num_rows > 0) ? true : false;
    
    $statement->close();
    
    return $isFounded;
}

function addRecord(mysqli $connectDatabase, string $recordName): void
{
    $statement = $connectDatabase->prepare('
        INSERT INTO 
            records (name) 
        VALUES 
            (?)
    ');
    
    $statement->bind_param('s', $recordName);
    $statement->execute();
    $statement->close();
}

function editRecord(mysqli $connectDatabase, string $recordName, int $recordId): void 
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $statement = $connectDatabase->prepare('
        UPDATE 
            records
        SET 
            name = ?
        WHERE 
            d = ?
    ');
    
    $statement->bind_param('si', $recordName, $recordId);
    $statement->execute();
    $statement->close();
}

function deleteRecord(mysqli $connectDatabase,int $recordId): void
{
    $statement = $connectDatabase->prepare('
        DELETE 
        FROM 
            records 
        WHERE 
            id = ?
    ');
    
    $statement->bind_param('i', $recordId);
    $statement->execute();
    $statement->close();
}
