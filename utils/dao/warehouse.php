<?php

require_once __DIR__ . '/../database.php';

function addWarehouse(string $name, string $address): string
{
    $db = getDatabaseConnection();
    $sql = "INSERT INTO warehouse (name, address) VALUES (?, ?)";
    $params = [ $name, $address ];

    return databaseInsert($db, $sql, $params);
}

function deleteWarehouseByID(string $id): int
{
    $db = getDatabaseConnection();
    $sql = "DELETE FROM warehouse WHERE id_warehouse = ?";
    $params = [$id];
    return databaseDelete($db, $sql, $params);
}

function getWarehouseByID(string $id): array
{
    $db = getDatabaseConnection();
    $sql = "SELECT name, address FROM warehouse WHERE id_warehouse = ?";
    $params = [$id];
    return databaseFindOne($db, $sql, $params);
}