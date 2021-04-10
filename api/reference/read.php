<?php

ini_set("display_errors", 1); // affiche les erreurs

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/database.php";

$limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 20;
$offset = isset($_GET["offset"]) ? intval($_GET["offset"]) : 0;

$where = [];
$params = [];
if (isset($_GET["brand"])) {
    $where[] = "brand LIKE ?"; // ? ou :var
    $params[] = "%" . $_GET["brand"] . "%";
}
if (isset($_GET["name"])) {
    $where[] = "name LIKE ?"; // ? ou :var
    $params[] = "%" . $_GET["name"] . "%";
}
if (isset($_GET["value_min"])) {
    $where[] = "value > ?"; // ? ou :var
    $params[] = $_GET["value_min"];
}
if (isset($_GET["value_max"])) {
    $where[] = "value < ?"; // ? ou :var
    $params[] = $_GET["value_max"];
}
if (isset($_GET["type"])) {
    $where[] = "type = ?"; // ? ou :var
    $params[] = $_GET["type"];
}

$whereSql = "";
if (count($where) > 0) {
    $whereSql = " WHERE " . join(" AND ", $where);
}

$db = getDatabaseConnection();
$sql = "SELECT r.id_reference as id_reference, brand, r.name, value, t.name as type_name, c.name as category_name FROM reference r
    JOIN type t on r.type = t.id_type
    JOIN category c on t.category = c.id_category" . $whereSql . " LIMIT $offset, $limit";

$rows = databaseSelectAll($db, $sql, $params);
header("Content-Type: application/json");
if (!is_null($rows)) {
    $json = json_encode($rows); // transforme le tableau en JSON
    echo $json;
} else {
    http_response_code(500);
}
