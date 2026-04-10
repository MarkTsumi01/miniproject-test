<?php

require __DIR__ . '/Database.php';

function getRecordsWithBandCount(): mysqli_result
{
    $databaseConnection = getDatabaseConnection();

    $sql = '
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

    $statement = $databaseConnection->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    $statement->close();

    return $result;
}

function getRecordById(int $recordid): array
{
    $databaseConnection = getDatabaseConnection();

    $sql = '
        SELECT 
            id, 
            name 
        FROM records 
        WHERE id = ?
    ';

    $statement = $databaseConnection->prepare($sql);
    $statement->bind_param('i', $recordid);
    $statement->execute();
    $record = $statement->get_result()->fetch_assoc();
    $statement->close();

    return $record;
}

function getRecordIdByName(string $recordname): array
{
    $databaseConnection = getDatabaseConnection();

    $sql = '
        SELECT 
            id
        FROM records
        WHERE name = ?
    ';

    $statement = $databaseConnection->prepare($sql);
    $statement->bind_param('s', $recordname);
    $statement->execute();
    $statement->bind_result($recordId);
    $statement->fetch();
    $statement->close();

    return ['id' => $recordId];
}

function isRecordExists(string $recordname): bool
{
    $databaseConnection = getDatabaseConnection();

    $sql = '
        SELECT 
            id 
        FROM records 
        WHERE name = ?
    ';

    $statement = $databaseConnection->prepare($sql);
    $statement->bind_param('s', $recordname);
    $statement->execute();
    $statement->store_result();
    $isFound = $statement->num_rows > 0;
    $statement->close();

    return $isFound;
}

function addRecord(string $recordname): void
{
    $databaseConnection = getDatabaseConnection();

    $sql = '
        INSERT INTO records 
           (name)
        VALUES 
            (?)
    ';

    $statement = $databaseConnection->prepare($sql);
    $statement->bind_param('s', $recordname);
    $statement->execute();
    $statement->close();
}

function updateRecord(string $recordname, int $recordid): void
{
    $databaseConnection = getDatabaseConnection();

    $sql = '
        UPDATE records
        SET 
            name = ?
        WHERE id = ?
    ';

    $statement = $databaseConnection->prepare($sql);
    $statement->bind_param('si', $recordname, $recordid);
    $statement->execute();
    $statement->close();
}

function deleteRecord(int $recordid): void
{
    $databaseConnection = getDatabaseConnection();

    $sql = '
        DELETE FROM records 
        WHERE id = ?
    ';

    $statement = $databaseConnection->prepare($sql);
    $statement->bind_param('i', $recordid);
    $statement->execute();
    $statement->close();
}
