<?php

require_once __DIR__ . '/../database.php';

function addType(string $name, string $category): string
{
    $db = getDatabaseConnection();
    $sql = "INSERT INTO type (name, category) VALUES (?, ?)";
    $params = [ $name, $category ];

    return databaseInsert($db, $sql, $params);
}

function deleteTypeByID(string $id): int
{
    $db = getDatabaseConnection();
    $sql = "DELETE FROM type WHERE id_type= ?";
    $params = [$id];
    return databaseDelete($db, $sql, $params);
}

function getTypeByID(string $id): array
{
    $db = getDatabaseConnection();
    $sql = "SELECT name, category FROM type WHERE id_type = ?";
    $params = [$id];
    return databaseFindOne($db, $sql, $params);
}
