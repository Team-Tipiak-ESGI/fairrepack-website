<?php

require_once __DIR__ . '/../database.php';

function addCategory(string $name): string
{
    $db = getDatabaseConnection();
    $sql = "INSERT INTO category (name) VALUES (?)";
    $params = [ $name ];

    return databaseInsert($db, $sql, $params);
}

function deleteCategoryByID(string $id): int
{
    $db = getDatabaseConnection();
    $sql = "DELETE FROM category WHERE id_category = ?";
    $params = [$id];
    return databaseDelete($db, $sql, $params);
}

function getCategoryByID(string $id): array
{
    $db = getDatabaseConnection();
    $sql = "SELECT name FROM category WHERE id_category = ?";
    $params = [$id];
    return databaseFindOne($db, $sql, $params);
}