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
$sql = "SELECT id_offer, username as user, user as user_id, product, price, note FROM offer
        join user " . $whereSql . " LIMIT $offset, $limit";
$rows = databaseSelectAll($db, $sql, $params);
header("Content-Type: application/json");

if (!is_null($rows)) {
    $count_sql = "select count(id_offer) as count from offer r $whereSql";
    $total = databaseFindOne($db, $count_sql, $params)["count"];
    echo json_encode(["items" => $rows, "count" => $total]);
} else {
    http_response_code(500);
}
