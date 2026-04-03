<?php

function createUser(mysqli $database, string $userName, string $hashedPassword): int
{
    $statement = $database->prepare('
        INSERT INTO 
            users (username, password) 
        VALUES 
            (?, ?)
    ');
    
    $statement->bind_param('ss', $userName, $hashedPassword);
    $statement->execute();

    $newUserId = $database->insert_id;
    $statement->close();

    return $newUserId;
}

function existsByUsername(mysqli $database, string $userName): bool
{
    $statement = $database->prepare('
        SELECT 
            id 
        FROM 
            users 
        WHERE 
            username = ?
    ');
    
    $statement->bind_param('s', $userName);
    $statement->execute();
    $statement->store_result();

    $isExists = ($statement->num_rows > 0);
    $statement->close();

    return $isExists;
}

function findUserByUsername(mysqli $database, string $userName): ?array 
{
    $statement = $database->prepare('
        SELECT 
            id, password 
        FROM 
            users 
        WHERE 
            username = ?
    ');
    
    if (!$statement) {
        return null; 
    }

    $statement->bind_param('s', $userName);
    $statement->execute();
    $statement->store_result(); 
    
    if ($statement->num_rows === 0) {
        $statement->close();
        
        return null;
    }

    $statement->bind_result($userId, $hashedPassword);
    $statement->fetch(); 
    $statement->close();

    $resultList = ['id' => $userId, 'password' => $hashedPassword];
            
    return $resultList;
}

function passwordVerify(string $password, string $hashedPassword): bool
{
    $isPasswordMatch = password_verify($password, $hashedPassword);
    
    return $isPasswordMatch;
}
