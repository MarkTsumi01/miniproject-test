<?php

function addUser(mysqli $database, string $userName, string $hashedPassword): int
{
    $insertUser = '
        INSERT INTO users 
            username, 
            password
        VALUES 
            ?, 
            ?
    ';

    $statement = $database->prepare($insertUser);
    $statement->bind_param('ss', $userName, $hashedPassword);
    $statement->execute();
    $newUserId = $database->insert_id;
    $statement->close();

    return $newUserId;
}

function isUserExistsByUsername(mysqli $connectDatabase, string $userName): bool
{
    $selectUserIdByUsername = '
        SELECT 
            id 
        FROM users 
        WHERE username = ?
    ';

    $statement = $connectDatabase->prepare($selectUserIdByUsername);
    $statement->bind_param('s', $userName);
    $statement->execute();
    $statement->store_result();
    $isExists = $statement->num_rows > 0;
    $statement->close();

    return $isExists;
}

function findUserByUsername(mysqli $database, string $userName): ?array
{
    $selectUserByUsername = '
        SELECT 
            id, 
            password 
        FROM users 
        WHERE username = ?
    ';

    $statement = $database->prepare($selectUserByUsername);
    $statement->bind_param('s', $userName);
    $statement->execute();
    $result = $statement->get_result()->fetch_assoc();
    $statement->close();

    return $result;
}
