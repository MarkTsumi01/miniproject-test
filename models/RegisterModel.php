<?php

function register(mysqli $db, string $userName, string $hashedPassword): int
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
