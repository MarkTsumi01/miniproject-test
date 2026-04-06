<?php

function getRecordsWithBandCount(mysqli $connectDatabase)
{
    $selectRecordsWithBandCount = '
        SELECT 
            records.id, 
            records.name, 
            COUNT(bands.id) AS band_count
        FROM records
            LEFT JOIN bands 
                ON bands.record_id = records.id
        GROUP BY 
            records.id, 
            records.name
        ORDER BY 
            records.name ASC
    ';

    $statement = $connectDatabase->prepare($selectRecordsWithBandCount);
    $statement->execute();
    $result = $statement->get_result();
    $statement->close();

    return $result;
}

function getRecordById(mysqli $connectDatabase, int $recordId): array
{
    $selectRecordById = '
        SELECT 
            id, 
            name 
        FROM records 
        WHERE id = ?
    ';

    $statement = $connectDatabase->prepare($selectRecordById);
    $statement->bind_param('i', $recordId);
    $statement->execute();
    $record = $statement->get_result()->fetch_assoc();
    $statement->close();

    return $record;
}

function getRecordIdByName(mysqli $connectDatabase, string $recordName): array
{
    $selectRecordIdByName = '
        SELECT 
            id
        FROM records
        WHERE name = ?
    ';

    $statement = $connectDatabase->prepare($selectRecordIdByName);
    $statement->bind_param('s', $recordName);
    $statement->execute();
    $statement->bind_result($recordId);
    $statement->fetch();
    $statement->close();

    return ['id' => $recordId];
}

function isRecordExists(mysqli $connectDatabase, string $recordName): bool
{
    $selectRecordIdByName = '
        SELECT 
            id 
        FROM records 
        WHERE name = ?
    ';

    $statement = $connectDatabase->prepare($selectRecordIdByName);
    $statement->bind_param('s', $recordName);
    $statement->execute();
    $statement->store_result();
    $isFound = $statement->num_rows > 0;
    $statement->close();

    return $isFound;
}

function insertRecord(mysqli $connectDatabase, string $recordName): void
{
    $insertRecord = '
        INSERT INTO records 
            name
        VALUES 
            ?
    ';

    $statement = $connectDatabase->prepare($insertRecord);
    $statement->bind_param('s', $recordName);
    $statement->execute();
    $statement->close();
}

function updateRecord(mysqli $connectDatabase, string $recordName, int $recordId): void
{
    $updateRecordNameById = '
        UPDATE records
        SET 
            name = ?
        WHERE id = ?
    ';

    $statement = $connectDatabase->prepare($updateRecordNameById);
    $statement->bind_param('si', $recordName, $recordId);
    $statement->execute();
    $statement->close();
}

function deleteRecord(mysqli $connectDatabase, int $recordId): void
{
    $deleteRecordById = '
        DELETE FROM records 
        WHERE id = ?
    ';

    $statement = $connectDatabase->prepare($deleteRecordById);
    $statement->bind_param('i', $recordId);
    $statement->execute();
    $statement->close();
}
