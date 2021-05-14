<?php
ini_set("display_errors", 1); // affiche les erreurs

if($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/database.php";

$limit = intval($_GET["limit"] ?? $_GET["size"] ?? 20);
$page = intval($_GET["page"] ?? 0);
$offset = intval($_GET["offset"] ?? $limit * $page);

$where = [];
$params = [];
if(isset($_GET["reference"])) {
    $where[] = "r.uuid_reference = ?"; // ? ou :var
    $params[] = $_GET["reference"];
}
if(isset($_GET["state"])) {
    $where[] = "state = ?"; // ? ou :var
    $params[] = $_GET["state"];
}
if(isset($_GET["quality"])) {
    $where[] = "quality = ?"; // ? ou :var
    $params[] = $_GET["quality"];
}
if(isset($_GET["id"])) {
    $where[] = "uuid_product = ?"; // ? ou :var
    $params[] = $_GET["id"];
}
if(isset($_GET["user"])) {
    $where[] = "product.user = (SELECT id_user FROM user WHERE uuid_user = ?)"; // ? ou :var
    $params[] = $_GET["user"];
}
$whereSql = "";
if(count($where) > 0) {
    $whereSql = " WHERE " . join(" AND ", $where);
}
$db = getDatabaseConnection();

// Get products
$sql = "SELECT uuid_product as id, uuid_user as user, r.uuid_reference as reference, description, quality, state,
        r.name as name, r.brand as brand, product.created, ifnull(offer_count, 0) as offer_count, ifnull(image_count, 0) as image_count
        FROM product
        left join (select product, id_offer, count(id_offer) as offer_count from offer group by product) o on product.id_product = o.product
        left join (select product, id_image, count(id_image) as image_count from image group by product) i on product.id_product = i.product
        join user u on product.user = u.id_user
        join reference r on r.id_reference = product.reference "
        . $whereSql . " GROUP BY id_product LIMIT $offset, $limit";

$rows = [];

if (isset($_GET["id"])) {
    $rows = databaseFindOne($db, $sql, $params);

    // Get offers
    $sql = "SELECT uuid_user as user, price, note, offer.created FROM offer
        JOIN user u on offer.user = u.id_user
        WHERE product = (SELECT id_product FROM product WHERE uuid_product = ?)
        ORDER BY created DESC
        LIMIT $offset, $limit";

    $offers = databaseSelectAll($db, $sql, [$_GET["id"]]);
    $rows["offers"] = $offers;
} else {
    $rows = databaseSelectAll($db, $sql, $params);
}

header("Content-Type: application/json");
if (!is_null($rows)) {
    $count_sql = "select count(id_product) as count from product
                join reference r on r.id_reference = product.reference " . $whereSql;

    $total = databaseFindOne($db, $count_sql, $params)["count"];

    $json = json_encode(["items" => $rows, "count" => $total]);
    echo $json;
} else {
    http_response_code(500);
}
