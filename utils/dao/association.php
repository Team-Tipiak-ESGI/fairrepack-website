<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../UUIDv4.php';


function insertAssociation(string $name, ?string $description, string $address){
    $db = getDatabaseConnection();

    $sql_assoc = "INSERT INTO association (uuid_association, name, description) VALUES (?, ?, ?) ";

    $param_assoc = [
        UUIDv4(),
        $name
    ];

    $assoc_id = databaseInsert($db, $sql_assoc, $param_assoc);

    $assoc_uuid = databaseFindOne($db, "select uuid_association from association where id_association = ?",
        [$assoc_id])["uuid_assoc"];
}

function deleteAssociationById(string $id_association):string
{
    $db = getDatabaseConnection();
    $sql = "DELETE FROM association WHERE id_association = ?";
    $params = [$id_association];
    return databaseDelete($db, $sql, $params);
}

function getAssociationById(string $id_association): ?array
{
    $db = getDatabaseConnection();
    $sql = "SELECT name, description, coin, address FROM association WHERE id_association = ?";
    $params = [$id_association];
    return databaseFindOne($db, $sql, $params);
}
