<?php

function getBandsByRecordId(mysqli $connectDatabase, int $recordId)
{
    $selectBandsWithAlbumCount = '
        SELECT 
            bands.id, 
            bands.name, 
            COUNT(albums.id) AS album_count
        FROM bands
            LEFT JOIN albums 
                ON albums.band_id = bands.id
        WHERE bands.record_id = ?
        GROUP BY 
            bands.id, 
            bands.name
        ORDER BY 
            bands.name ASC
    ';

    $statement = $connectDatabase->prepare($selectBandsWithAlbumCount);
    $statement->bind_param('i', $recordId);
    $statement->execute();
    $result = $statement->get_result();
    $statement->close();

    return $result;
}

function isBandExists(mysqli $connectDatabase, string $bandName): bool
{
    $selectBandIdByName = '
        SELECT 
            id
        FROM bands
        WHERE name = ?
    ';

    $statement = $connectDatabase->prepare($selectBandIdByName);
    $statement->bind_param('s', $bandName);
    $statement->execute();
    $statement->store_result();
    $isFound = $statement->num_rows > 0;
    $statement->close();

    return $isFound;
}

function insertBand(mysqli $connectDatabase, string $bandName, int $recordId): void
{
    $insertBandWithRecordId = '
        INSERT INTO 
            bands (name, record_id) 
        VALUES 
            (?, ?)
    ';

    $statement = $connectDatabase->prepare($insertBandWithRecordId);
    $statement->bind_param('si', $bandName, $recordId);
    $statement->execute();
    $statement->close();
}

function deleteBand(mysqli $connectDatabase, int $bandId): void
{
    $deleteBandById = '
        DELETE FROM bands
        WHERE id = ?
    ';

    $statement = $connectDatabase->prepare($deleteBandById);
    $statement->bind_param('i', $bandId);
    $statement->execute();
    $statement->close();
}
