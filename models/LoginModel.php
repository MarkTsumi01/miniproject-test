<?php

function findUserByUsername(mysqli $db, string $userName): array
{
    $stmt = $db->prepare('
        SELECT id, password 
        FROM users 
        WHERE username = ?
    ');
    
    $stmt->bind_param('s', $userName);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();

    if ($stmt->num_rows === 0) {
        $stmt->close();
        
        return false;
    }
    
    // if ($stmt->num_rows === 0 )

    $stmt->close();
    
    $result = ['id' => $userId, 'password' => $hashedPassword];
    
    return $result;
}


function passwordVerify() 
{
    
}
