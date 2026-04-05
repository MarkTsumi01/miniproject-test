<?php

function getAllBands(mysqli $connectDatabase, int $recordId)
{
    $statement = $connectDatabase->prepare('
        SELECT 
            bands.id, 
            bands.name, 
            COUNT(albums.id) AS album_count
        FROM 
            bands
        LEFT JOIN 
            albums 
            ON albums.band_id = bands.id
        WHERE
            bands.record_id = ?
        GROUP BY 
            bands.id, 
            bands.name
        ORDER BY 
            bands.name ASC
    ');
    
    $statement->bind_param('i', $recordId);
    $statement->execute();
    $bandResult = $statement->get_result();
    $statement->close();
    
    return $bandResult;
}

function checkBand(mysqli $connectDatabase, string $bandName): bool
{
    $statement = $connectDatabase->prepare('
        SELECT 
            id
        FROM
            bands
        WHERE
            name = ?
    ');
    $statement->bind_param('s', $bandName);
    $statement->execute();
    $statement->store_result();
    
    $isFound = ($statement->num_rows > 0) ? true : false;
    
    $statement->close();
    
    return $isFound;
}

function addBand(mysqli $connectDatabase, string $bandName, int $recordId): void
{
    $statement = $connectDatabase->prepare('
        INSERT INTO 
            bands (name, record_id) 
        VALUES 
            (?, ?)
    ');
    
    $statement->bind_param('si', $bandName, $recordId);
    $statement->execute();
    $statement->close();
}

function deleteBand(mysqli $connectDatabase, int $bandId)
{
    $statement = $connectDatabase->prepare('
        DELETE
        FROM
            bands
        WHERE
            id = ?
    ');
    
    $statement->bind_param('i', $bandId);
    $statement->execute();
    $statement->close();
}
