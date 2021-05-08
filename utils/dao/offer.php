<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../UUIDv4.php';
require_once __DIR__ . '/product.php';

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
    $sql = "SELECT user, product, price, note FROM offer WHERE id_offer = ?";
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