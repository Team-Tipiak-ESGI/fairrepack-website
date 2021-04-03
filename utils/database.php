<?php

function getDatabaseConnection(): PDO
{
    $driver = "mysql";
    $host = "localhost";
    $port = 3306; // default 3306
    $db = "fairrepack";
    $user = "root";
    $password = "";
    return new PDO("$driver:host=$host;port=$port;dbname=$db;charset=utf8",
        $user,
        $password);
}

/**
 * Permet d'inserer des data en base
 * @param PDO $db Une reference sur la base
 * @param string $sql La requete
 * @param array $params Le tableau de params
 * @return string|null  null en cas d'erreur sinon l'id de l'élément inséré.
 */
function databaseInsert(PDO $db, string $sql, array $params): ?string
{
    $statement = $db->prepare($sql);
    if ($statement) {
        $success = $statement->execute($params);
        if ($success) {
            return $db->lastInsertId();
        }
    }
    return null;
}

function databaseFindOne(PDO $db, string $sql, array $params): ?array
{
    $statement = $db->prepare($sql);
    if ($statement) {
        $success = $statement->execute($params);
        if ($success) {
            $res = $statement->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                return $res;
            }
        }
    }
    return null;
}

function databaseUpdate(PDO $db, string $sql, array $params): ?bool
{
    $statement = $db->prepare($sql);
    if ($statement) {
        return $statement->execute($params);
    }
    return null;
}

function databaseDelete(PDO $db, string $sql, array $params): ?string
{
    $statement = $db->prepare($sql);
    if ($statement) {
        return $statement->execute($params);
    }
    return null;
}
