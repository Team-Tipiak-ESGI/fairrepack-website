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
        r.name as name, r.brand as brand, product.created, count(o.id_offer) as offer_count
        FROM product
        RIGHT JOIN offer o on product.id_product = o.product
        JOIN user u on product.user = u.id_user
        JOIN reference r on r.id_reference = product.reference "
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
    $json = json_encode(["items" => $rows, "count" => databaseRowCount($db, "product")]);
    echo $json;
} else {
    http_response_code(500);
}
