<?php

require_once 'database.php';
require_once 'UUIDv4.php';


//===================================================PRODUCT============================================================
/**
 * Insert a new product
 * @param string $reference Reference's UUID
 * @param string $user
 * @param string|null $description
 * @param string|null $state
 * @param string|null $quality
 * @param int|null $warehouse
 * @param float|null $price
 * @return string|null
 */

function addProduct(string $reference, string $user, ?string $description, ?string $state,
                    ?string $quality, ?int $warehouse, ?float $price): ?string
{
    $db = getDatabaseConnection();
    $sql_product = "INSERT INTO product (uuid_product, user, description, state, quality, warehouse, reference)
                VALUES (?, (SELECT id_user FROM user WHERE uuid_user = ?), ?, ?, ?, ?, (SELECT id_reference FROM reference WHERE uuid_reference = ?))";

    $params_product = [
        UUIDv4(),
        $user,
        $description,
        $state,
        $quality,
        $warehouse,
        $reference,
    ];

    $product_id = databaseInsert($db, $sql_product, $params_product);

    $product_uuid = databaseFindOne($db, "select uuid_product from product where id_product = ?", [$product_id])["uuid_product"];

    addOffer($user, $product_uuid, $price ?? getReferenceByUUID($reference)["value"] ?? NULL, "First offer.");

    return $product_id;
}

function getProductById(string $id_product): ?array
{
    $db = getDatabaseConnection();
    $sql = "SELECT uuid_product, reference, description, quality, state FROM product WHERE id_product = ?";
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

function getProductByUUID(string $uuid): ?array
{
    $db = getDatabaseConnection();
    $sql = "SELECT state, quality, description, reference, warehouse, created, user FROM product WHERE uuid_product = ?";
    $params = [$uuid];
    return databaseFindOne($db, $sql, $params);
}

//====================================================OFFER=============================================================
/**
 * @param string $user User's uuid
 * @param string $product Product's uuid
 * @param float|null $price
 * @param string|null $note
 * @return string|null
 */
function addOffer(string $user, string $product, ?float $price, ?string $note): ?string
{
    $db = getDatabaseConnection();
    $sql = "INSERT INTO offer (user, product, price, note) VALUES
                ((SELECT id_user FROM user WHERE uuid_user = ?),
                (SELECT id_product FROM product WHERE uuid_product = ?), ?, ?)";

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

//==================================================REFERENCE===========================================================

function createReferenceByUUID(string $brand, string $name, float $value, string $type): string
{
    $db = getDatabaseConnection();
    $sql = "INSERT INTO reference ( uuid_reference,brand, name, value, type) VALUES (?,?,?,?)";
    $params = [
        UUIDv4(),
        $brand,
        $name,
        $value,
        $type
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
    $sql = "SELECT brand, name, value, type FROM reference WHERE id_reference = ?";
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
