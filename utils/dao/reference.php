<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../UUIDv4.php';

function addReference(string $brand, string $name, float $value, string $type): string
{
    $db = getDatabaseConnection();
    $sql = "INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES (?,?,?,?,?)";
    $params = [
        UUIDv4(),
        $brand,
        $name,
        $value,
        $type,
    ];

    return databaseInsert($db, $sql, $params);
}

function deleteReferenceByUUID(string $uuid): int
{
    $db = getDatabaseConnection();
    $sql = "DELETE FROM reference WHERE uuid_reference= ?";
    $params = [$uuid];
    return databaseDelete($db, $sql, $params);
}

function getReferenceByID(string $id): ?array
{
    $db = getDatabaseConnection();
    $sql = "SELECT uuid_reference, brand, name, value, type FROM reference WHERE id_reference = ?";
    $params = [$id];
    return databaseFindOne($db, $sql, $params);
}

function getReferenceByUUID(string $uuid): ?array
{
    $db = getDatabaseConnection();
    $sql = "SELECT brand, name, value, type FROM reference WHERE uuid_reference = ?";
    $params = [$uuid];
    return databaseFindOne($db, $sql, $params);
}