<?php

require __DIR__ . '/Database.php';

function getUserByUsername(string $username): array
{
    $databaseConnection = getDatabaseConnection();

    $sql = '
        SELECT 
            id, 
            password 
        FROM users 
        WHERE username = ?
    ';
       
    $statement = $databaseConnection->prepare($sql);
    $statement->bind_param('s', $username);
    $statement->execute();
    $result = $statement->get_result()->fetch_assoc();
    $statement->close(); 

    if (empty($result)) {
        return [];
    }

    return $result;
}

function addUser(string $username, string $password): int
{
    $databaseConnection = getDatabaseConnection();

    $sql = '
        INSERT INTO users 
            (username, password)
        VALUES 
            (?, ?)
    ';
    
    $statement = $databaseConnection->prepare($sql);
    $statement->bind_param('ss', $username, $password);
    $statement->execute();
    $newUserid = $databaseConnection->insert_id;
    $statement->close();
    
    return $newUserid;
}
