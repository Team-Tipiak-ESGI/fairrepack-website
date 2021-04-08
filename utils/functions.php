<?php

require_once 'database.php';

function addProduct(int $reference, string $description, ?string $state, ?string $quality, ?int $warehouse ): ?string
{
    $db = getDatabaseConnection();
    $sql = "INSERT INTO PRODUCT (reference , description, state, quality, warehouse) VALUES ( ?, ?, ?, ?, ?)";
    $params = [
        $reference,
        $description,
        $state,
        $quality,
        $warehouse
    ];
    return databaseInsert($db, $sql, $params);
}

function getProductById(string $id_product): ?array
{
    $db = getDatabaseConnection();
    $sql = "SELECT id_product, reference, description, quality, state FROM product WHERE id_product = ?";
    $params = [$id_product];
    return databaseFindOne($db, $sql, $params);
}

function deleteProductById(string $id_product): string
{
    $db = getDatabaseConnection();
    $sql = "DELETE FROM product WHERE id_product = ?";
    $params = [$id_product];
    return databaseDelete($db, $sql, $params);
}

function updateProduct(string $id_product,int $reference, string $description, ?string $state, ?string $quality, ?int $warehouse ): string
{
    $db = getDatabaseConnection();
    $sql = "UPDATE product SET description = ?, state = ?, quality = ?, warehouse = ?, reference = ? WHERE id_product = ?";
    $params = [
        $description,
        $state,
        $quality,
        $warehouse,
        $reference,
        $id_product
    ];
    return databaseUpdate($db, $sql, $params);
}

function addOffer(int $user, int $product, ?float $price, ?string $note ): ?string
{
    $db = getDatabaseConnection();
    $sql = "INSERT INTO offer (user , product, price, note) VALUES ( ?, ?, ?, ?)";
    $params = [
        $user,
        $product,
        $price,
        $note
    ];
    return databaseInsert($db, $sql, $params);
}

function getOfferById(string $id_offer): ?array
{
    $db = getDatabaseConnection();
    $sql = "SELECT id_offer, user, product, price, note FROM offer WHERE id_offer = ?";
    $params = [$id_offer];
    return databaseFindOne($db, $sql, $params);
}

function deleteOfferById(string $id_offer): string
{
    $db = getDatabaseConnection();
    $sql = "DELETE FROM offer WHERE id_offer= ?";
    $params = [$id_offer];
    return databaseDelete($db, $sql, $params);
}

function updateOffer(string $id_offer,int $user, string $product, ?float $price, ?string $note): string
{
    $db = getDatabaseConnection();
    $sql = "UPDATE product SET description = ?, state = ?, quality = ?, warehouse = ?, reference = ? WHERE id_product = ?";
    $params = [
        $id_offer,
        $user,
        $product,
        $price,
        $note
    ];
    return databaseUpdate($db, $sql, $params);
}

