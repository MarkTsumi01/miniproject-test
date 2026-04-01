<?php

function createUser(mysqli $db, string $userName, string $hashedPassword): int
{
    $insert = $db->prepare('
        INSERT INTO users (username, password) 
        VALUES (?, ?)
    ');
    
    $insert->bind_param('ss', $userName, $hashedPassword);
    $insert->execute();

    $newUserId = $db->insert_id;
    $insert->close();

    return $newUserId;
}

function existsByUsername(mysqli $db, string $userName): bool
{
    $check = $db->prepare('
        SELECT id 
        FROM users 
        WHERE username = ?
    ');
    $check->bind_param('s', $userName);
    $check->execute();
    $check->store_result();

    $isExists = ($check->num_rows > 0);
    $check->close();

    return $isExists;
}

function findUserByUsername(mysqli $db, string $userName): ?array 
{
    $stmt = $db->prepare('SELECT id, password FROM users WHERE username = ?');
    
    if (!$stmt) {
        return null; 
    }

    $stmt->bind_param('s', $userName);
    $stmt->execute();
    $stmt->store_result(); 
    
    if ($stmt->num_rows === 0) {
        $stmt->close();
        
        return null;
    }

    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch(); 
    $stmt->close();

    $result = ['id' => $userId, 'password' => $hashedPassword];
        
    return $result;
}

function passwordVerify(string $password, string $hashedPassword): bool
{
    return password_verify($password, $hashedPassword);
}