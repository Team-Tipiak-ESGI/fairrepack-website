<?php
require_once __DIR__ . '/../database.php';

function addCoin(int $amount, string $user){
    $db = getDatabaseConnection();
    $sql = "UPDATE user SET coin = (SELECT coin from user where uuid_user = ?) + ? WHERE uuid_user = ?";

    $params = [
        $user,
        $amount,
        $user
    ];
    return databaseInsert($db, $sql, $params);
}

function giveCoin(int $amount, string $idAssoc, string $user){
    $db = getDatabaseConnection();
}