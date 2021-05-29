<?php

ini_set("display_errors", 1); // affiche les erreurs

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/database.php";

if (isset($_GET["id"])) {
    require_once __DIR__ . "/../../utils/dao/warehouse.php";
    echo json_encode(getWarehouseByID($_GET["id"]));
    die();
}

$limit = $_GET["limit"] ?? $_GET["size"] ?? 20;
$page = $_GET["page"] ?? 0;
$offset = $_GET["offset"] ?? $limit * $page;

$where = [];
$params = [];
if (isset($_GET["name"])) {
    $where[] = "name like ?"; // ? ou :var
    $params[] = "%" . $_GET["name"] . "%";
}
$whereSql = "";
if (count($where) > 0) {
    $whereSql = " WHERE " . join(" AND ", $where);
}

$db = getDatabaseConnection();
$sql = "SELECT id_warehouse, name, address FROM warehouse $whereSql LIMIT $offset, $limit";
$rows = databaseSelectAll($db, $sql, $params);
header("Content-Type: application/json");

if (!is_null($rows)) {
    $count_sql = "select count(id_warehouse) as count from warehouse r $whereSql";
    $total = databaseFindOne($db, $count_sql, $params)["count"];
    echo json_encode(["items" => $rows, "count" => $total]);
} else {
    http_response_code(500);
}
