<?php
ini_set("display_errors", 1); // affiche les erreurs

if($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/database.php";

$limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 20;
$offset = isset($_GET["offset"]) ? intval($_GET["offset"]) : 0;

$where = [];
$params = [];
if(isset($_GET["reference"])) {
    $where[] = "reference = ?"; // ? ou :var
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
$whereSql = "";
if(count($where) > 0) {
    $whereSql = " WHERE " . join(" AND ", $where);
}
$db = getDatabaseConnection();
$sql = "SELECT uuid_product as id, reference, description, quality, state, r.name as name, r.brand as brand FROM product
    JOIN reference r on r.id_reference = product.reference"
    . $whereSql . " LIMIT $offset, $limit";

$rows = databaseSelectAll($db, $sql, $params);
header("Content-Type: application/json");
if (!is_null($rows)) {
    $json = json_encode($rows); // transforme le tableau en JSON
    echo $json;
} else {
    http_response_code(500);
}
