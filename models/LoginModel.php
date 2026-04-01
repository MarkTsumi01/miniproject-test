<?php

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