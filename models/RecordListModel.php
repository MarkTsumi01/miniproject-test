<?php

function deleteByRecordId(mysqli $db,int $recordId): void
{
    $deleteStmt = $db->prepare('DELETE FROM records WHERE id = ?');
    $deleteStmt->bind_param('i', $recordId);
    $deleteStmt->execute();
    $deleteStmt->close();
}

function getAllRecords(mysqli $db)
{
    $stmt = $db->prepare('
        SELECT records.id, records.name, COUNT(bands.id) AS band_count
        FROM records
        LEFT JOIN bands ON bands.record_id = records.id
        GROUP BY records.id, records.name
        ORDER BY records.name ASC
    ');
    
    $stmt->execute();
    $recordResult = $stmt->get_result();
    $stmt->close();
    
    return $recordResult;
}