<?php

ini_set("display_errors", 1); // affiche les erreurs

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/database.php";

$limit = $_GET["limit"] ?? $_GET["size"] ?? 20;
$page = $_GET["page"] ?? 0;
$offset = $_GET["offset"] ?? $limit * $page;

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
if (isset($_GET["state"])) {
    $where[] = "p.state = ?"; // ? ou :var
    $params[] = $_GET["state"];
}
if (isset($_GET["id"])) {
    $where[] = "r.uuid_reference = ?"; // ? ou :var
    $params[] = $_GET["id"];
}

$whereSql = "";
if (count($where) > 0) {
    $whereSql = " where " . join(" and ", $where);
}

$db = getDatabaseConnection();

$sql = "select r.uuid_reference as id, brand, r.name, value, t.name as type_name, c.name as category_name,
        s.stocks, count(p.id_product) as count, p.created
        from reference r
        left join (select count(p.id_product) as stocks, reference, id_product
                    from product p
                    where state = 'in_stock'
                    group by reference) s
                on r.id_reference = s.reference
        left join product p on r.id_reference = p.reference
        join type t on t.id_type = r.type
        join category c on c.id_category = t.category "
        . $whereSql .
        " group by r.id_reference
        limit $offset, $limit";

$rows = null;

if (isset($_GET["id"])) {
    $rows = databaseFindOne($db, $sql, $params);
} else {
    $rows = databaseSelectAll($db, $sql, $params);
}

header("Content-Type: application/json");
if (!is_null($rows)) {
    $count_sql = "select count(*) as count from (select count(*) from reference r
        left join (select count(p.id_product) as stocks, reference, id_product
                    from product p
                    where state = 'in_stock'
                    group by reference) s
                on r.id_reference = s.reference
        left join product p on r.id_reference = p.reference
        join type t on t.id_type = r.type
        join category c on c.id_category = t.category "
        . $whereSql . " group by r.id_reference) a";

    $total = databaseFindOne($db, $count_sql, $params)["count"];

    $json = json_encode(["items" => $rows, "count" => $total]);
    echo $json;
} else {
    http_response_code(500);
}
