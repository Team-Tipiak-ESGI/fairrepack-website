<?php

ini_set("display_errors", 1); // affiche les erreurs

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/database.php";

if (isset($_GET["id"])) {
    require_once __DIR__ . "/../../utils/dao/association.php";
    echo json_encode(getAssociationByUUID($_GET["id"]));
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
if (isset($_GET["description"])) {
    $where[] = "description like ?"; // ? ou :var
    $params[] = "%" . $_GET["description"] . "%";
}
$whereSql = "";
if (count($where) > 0) {
    $whereSql = " WHERE " . join(" AND ", $where);
}

$db = getDatabaseConnection();
$sql = "SELECT uuid_association, name, description, coins, address FROM association $whereSql LIMIT $offset, $limit";
$rows = databaseSelectAll($db, $sql, $params);
header("Content-Type: application/json");

if (!is_null($rows)) {
    $count_sql = "select count(id_association) as count from association r $whereSql";
    $total = databaseFindOne($db, $count_sql, $params)["count"];
    echo json_encode(["items" => $rows, "count" => $total]);
} else {
    http_response_code(500);
}
