<?php

require __DIR__ . '/Database.php';

function getUserByUsername(string $username): array
{
    global $connectDatabase;

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

function addUser(string $username, string $hashedPassword): int
{
    global $connectDatabase;

    $sql = '
        INSERT INTO users 
            (username, password)
        VALUES 
            (?, ?)
    ';
    
    $statement = $connectDatabase->prepare($sql);
    $statement->bind_param('ss', $username, $hashedPassword);
    $statement->execute();
    $newUserId = $connectDatabase->insert_id;
    $statement->close();
    
    return $newUserId;
}
