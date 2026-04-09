<?php

// require __DIR__ . '/Database.php';
require __DIR__ . '/Databasetest.php';

function getUserByUsername(string $username): array
{
    $connectDatabase = getDatabase();

    $sql = '
        SELECT 
            id, 
            password 
        FROM users 
        WHERE username = ?
    ';
       
    $statement = $connectDatabase->prepare($sql);
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
    $connectDatabase = getDatabase();

    $sql = '
        INSERT INTO users 
            (username, password)
        VALUES 
            (?, ?)
    ';
    
    $statement = $connectDatabase->prepare($sql);
    $statement->bind_param('ss', $username, $password);
    $statement->execute();
    $newUserid = $connectDatabase->insert_id;
    $statement->close();
    
    return $newUserid;
}
