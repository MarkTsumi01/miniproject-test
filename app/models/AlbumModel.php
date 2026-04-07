<?php

function getAlbumsByBandId(mysqli $connectDatabase, int $bandId)
{
    $selectAlbumsQuery = '
        SELECT
            albums.id,
            albums.name,
            COUNT(songs.id) AS song_count
        FROM albums
            LEFT JOIN songs
                ON songs.album_id = albums.id
        WHERE albums.band_id = ?
        GROUP BY
            albums.id,
            albums.name
        ORDER BY
            albums.name ASC
    ';
    
    $statement = $connectDatabase->prepare($selectAlbumsQuery);
    $statement->bind_param('i', $bandId);
    $statement->execute();
    $result = $statement->get_result();
    $statement->close();
    
    return $result;
}

function addAlbum(mysqli $connectDatabase, string $albumName, int $bandId): void
{
    $addAlbumQuery = '
        INSERT INTO albums
            (name, band_id)
        VALUES
            (?,?)
    ';
    
    $statement = $connectDatabase->prepare($addAlbumQuery);
    $statement->bind_param('si', $albumName, $bandId);
    $statement->execute();
    $statement->close();
}



function deleteAlbum(mysqli $connectDatabase, int $bandId): void
{
    $deleteAlbumQuery = '
        DELETE FROM albums
        WHERE id = ?    
    ';
    
    $statement = $connectDatabase->prepare($deleteAlbumQuery);
    $statement->bind_param('i', $bandId);
    $statement->execute();
    $statement->close();
}