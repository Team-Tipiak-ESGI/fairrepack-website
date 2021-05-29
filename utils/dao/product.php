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
    $sql_product = "INSERT INTO product (uuid_product, user, description, state, quality, warehouse.php, reference)
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

/**
 * Return columns state, quality, description, reference, warehouse.php, p.created, user, uuid_user FROM product
 * @param string $uuid
 * @return array|null
 */
function getProductByUUID(string $uuid): ?array
{
    $db = getDatabaseConnection();
    $sql = "select state, quality, description, p.created, uuid_user, uuid_reference,
                   price as last_price, ifnull(image_count, 0) as image_count, ifnull(offer_count, 0) as offer_count
                from product p
                left join user u on u.id_user = p.user
                left join reference r on r.id_reference = p.reference
                left join (select product, id_image, count(id_image) as image_count from image group by product) i on p.id_product = i.product
                left join (select product, id_offer, count(id_offer) as offer_count from offer group by product) o on p.id_product = o.product
                left join (select product, price from (
                        select o.product, o.price, row_number() over (partition by o.product order by o.created desc) as rn
                    from offer o) as r where rn = 1) lo on lo.product = p.id_product
                where uuid_product = ?";
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

function getProductsImageUrls(string $uuid): array
{
    $db = getDatabaseConnection();
    $sql = "SELECT ifnull(image_count, 0) as image_count FROM product p
            left join (select product, id_image, count(id_image) as image_count from image group by product) i on p.id_product = i.product
            WHERE uuid_product = ?";
    $params = [$uuid];

    $image_count = databaseFindOne($db, $sql, $params)["image_count"];

    $urls = [];

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    for ($i = 0; $i < $image_count; $i++) {
        $urls[] = $protocol . $_SERVER["SERVER_NAME"] . "/image/$uuid/$i";
    }

    return $urls;
}

function getProductImage(string $product_id, string $row): ?array
{
    $sql = "select r.image, r.mime
        from (select row_number() over(partition by p.id_product) as row_num, image, mime
              from product p
	          join image i on p.id_product = i.product
              where p.uuid_product = ?) r
        where r.row_num = ?";

    $con = getDatabaseConnection();
    return databaseFindOne($con, $sql, [$product_id, $row]);
}
