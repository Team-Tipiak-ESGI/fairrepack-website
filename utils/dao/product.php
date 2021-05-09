<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../UUIDv4.php';
require_once __DIR__ . '/offer.php';
require_once __DIR__ . '/reference.php';

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
    $sql = "SELECT state, quality, description, reference, warehouse, p.created, user, uuid_user FROM product p
            JOIN user u on p.user = u.id_user
            WHERE uuid_product = ?";
    $params = [$uuid];
    return databaseFindOne($db, $sql, $params);
}

function addProductImage(string $product_id, string $blob, string $mime): string
{
    $db = getDatabaseConnection();
    $sql = "INSERT INTO image (product, image, mime) VALUES (?, ?, ?)";

    $params = [
        $product_id,
        $blob,
        $mime,
    ];

    return databaseInsert($db, $sql, $params);
}
