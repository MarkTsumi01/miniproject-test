<?php

function getUserByUserName(mysqli $connectDatabase, string $userName)
{
    $selectUserByUsername = '
        SELECT 
            id, 
            password 
        FROM users 
        WHERE username = ?
    ';
    
    $statement = $connectDatabase->prepare($selectUserByUsername);
    $statement->bind_param('s', $userName);
    $statement->execute();
    $result = $statement->get_result()->fetch_assoc();
    $statement->close();
    
    return $result;
}

function addUser(mysqli $connectDatabase, string $userName, string $hashedPassword): int
{
    $insertUser = '
        INSERT INTO users 
            (username, password)
        VALUES 
            (?, ?)
    ';
    
    $statement = $connectDatabase->prepare($insertUser);
    $statement->bind_param('ss', $userName, $hashedPassword);
    $statement->execute();
    $newUserId = $connectDatabase->insert_id;
    $statement->close();
    
    return $newUserId;
}
