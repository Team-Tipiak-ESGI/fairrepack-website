<?php
ini_set("display_errors", 1); // affiche les erreurs

if($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/database.php";

$limit = $_GET["limit"] ?? $_GET["size"] ?? 20;
$page = $_GET["page"] ?? 0;
$offset = $_GET["offset"] ?? $limit * $page;

$where = [];
$params = [];
if(isset($_GET["product"])) {
    $where[] = "product = ?"; // ? ou :var
    $params[] = $_GET["product"];
}
if(isset($_GET["price_min"])) {
    $where[] = "price > ?"; // ? ou :var
    $params[] = $_GET["price_min"];
}
if(isset($_GET["price_max"])) {
    $where[] = "price < ?"; // ? ou :var
    $params[] = $_GET["price_max"];
}
$whereSql = "";
if(count($where) > 0) {
    $whereSql = " WHERE " . join(" AND ", $where);
}

$db = getDatabaseConnection();
$sql = "SELECT id_offer, user, product, price, note FROM offer " . $whereSql . " LIMIT $offset, $limit";
$rows = databaseSelectAll($db, $sql, $params);
header("Content-Type: application/json");

if (!is_null($rows)) {
    $json = json_encode(["items" => $rows, "count" => databaseRowCount($db, "offer")]);
    echo $json;
} else {
    http_response_code(500);
}
