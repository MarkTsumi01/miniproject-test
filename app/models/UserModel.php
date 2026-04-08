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

function addUser(string $username, string $hashedpassword): int
{
    global $connectDatabase;

    $sql = '
        INSERT INTO users 
            (username, password)
        VALUES 
            (?, ?)
    ';
    
    $statement = $connectDatabase->prepare($sql);
    $statement->bind_param('ss', $username, $hashedpassword);
    $statement->execute();
    $newUserid = $connectDatabase->insert_id;
    $statement->close();
    
    return $newUserid;
}
