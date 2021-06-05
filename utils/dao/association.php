<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../UUIDv4.php';


function insertAssociation(string $name, ?string $description, ?string $address, ?string $image, ?string $mime){
    $db = getDatabaseConnection();

    $sql_assoc = "INSERT INTO association (uuid_association, name, description, address, image, mime) VALUES (?, ?, ?, ?, ?, ?)";

    $param_assoc = [
        UUIDv4(),
        $name,
        $description,
        $address,
        $image,
        $mime,
    ];

    return databaseInsert($db, $sql_assoc, $param_assoc);
}

function deleteAssociationByUUID(string $uuid):string
{
    $db = getDatabaseConnection();
    $sql = "DELETE FROM association WHERE uuid_association = ?";
    $params = [$uuid];
    return databaseDelete($db, $sql, $params);
}

function getAssociationById(string $id_association): ?array
{
    $db = getDatabaseConnection();
    $sql = "SELECT name, description, coin, address FROM association WHERE id_association = ?";
    $params = [$id_association];
    return databaseFindOne($db, $sql, $params);
}

function getAssociationByUUID(string $uuid): ?array
{
    $db = getDatabaseConnection();
    $sql = "SELECT name, description, coin, address FROM association WHERE uuid_association = ?";
    $params = [$uuid];
    return databaseFindOne($db, $sql, $params);
}
