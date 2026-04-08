<?php

require __DIR__ . '/Database.php';

function getRecordsWithBandCount(): mysqli_result
{
    global $connectDatabase;

    $sql= '
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

    $statement = $connectDatabase->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    $statement->close();

    return $result;
}

function getRecordById(int $recordid): array
{
    global $connectDatabase;

    $sql = '
        SELECT 
            id, 
            name 
        FROM records 
        WHERE id = ?
    ';

    $statement = $connectDatabase->prepare($sql);
    $statement->bind_param('i', $recordid);
    $statement->execute();
    $record = $statement->get_result()->fetch_assoc();
    $statement->close();

    return $record;
}

function getRecordIdByName(string $recordname): array
{
    global $connectDatabase;

    $sql = '
        SELECT 
            id
        FROM records
        WHERE name = ?
    ';

    $statement = $connectDatabase->prepare($sql);
    $statement->bind_param('s', $recordname);
    $statement->execute();
    $statement->bind_result($recordId);
    $statement->fetch();
    $statement->close();

    return ['id' => $recordId];
}

function isRecordExists(string $recordname): bool
{
    global $connectDatabase;

    $sql = '
        SELECT 
            id 
        FROM records 
        WHERE name = ?
    ';

    $statement = $connectDatabase->prepare($sql);
    $statement->bind_param('s', $recordname);
    $statement->execute();
    $statement->store_result();
    $isFound = $statement->num_rows > 0;
    $statement->close();

    return $isFound;
}

function addRecord(string $recordname): void
{
    global $connectDatabase;

    $sql = '
        INSERT INTO records 
           (name)
        VALUES 
            (?)
    ';

    $statement = $connectDatabase->prepare($sql);
    $statement->bind_param('s', $recordname);
    $statement->execute();
    $statement->close();
}

function updateRecord(string $recordname, int $recordid): void
{
    global $connectDatabase;

    $sql = '
        UPDATE records
        SET 
            name = ?
        WHERE id = ?
    ';

    $statement = $connectDatabase->prepare($sql);
    $statement->bind_param('si', $recordname, $recordid);
    $statement->execute();
    $statement->close();
}

function deleteRecord(int $recordid): void
{
    global $connectDatabase;

    $sql = '
        DELETE FROM records 
        WHERE id = ?
    ';

    $statement = $connectDatabase->prepare($sql);
    $statement->bind_param('i', $recordid);
    $statement->execute();
    $statement->close();
}
