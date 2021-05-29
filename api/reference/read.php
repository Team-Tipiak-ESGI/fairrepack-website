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
if (isset($_GET["search"])) {
    $where[] = "concat(lower(brand), lower(r.name)) LIKE ?"; // ? ou :var
    $params[] = "%" . strtolower($_GET["search"]) . "%";
} else {
    if (isset($_GET["brand"])) {
        $where[] = "brand LIKE ?"; // ? ou :var
        $params[] = "%" . $_GET["brand"] . "%";
    }
    if (isset($_GET["name"])) {
        $where[] = "r.name LIKE ?"; // ? ou :var
        $params[] = "%" . $_GET["name"] . "%";
    }
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
        s.stocks, c.count, p.created, image_url
        from reference r
        -- In stocks count
        left join (select count(p.id_product) as stocks, reference
                    from product p
                    where state = 'in_stock'
                    group by reference) s
                on r.id_reference = s.reference
        -- Total count
        left join (select count(p.id_product) as count, reference
                    from product p
                    group by reference) c
                on r.id_reference = c.reference
        left join product p on r.id_reference = p.reference
        -- Random reference image
        left join (select image, mime, concat(uuid_product, '/', row_number() over (partition by p.id_product)) as image_url, reference
                   from product p
                            join image i on p.id_product = i.product
                order by rand()) i on r.id_reference = i.reference
        join type t on t.id_type = r.type
        join category c on c.id_category = t.category "
        . $whereSql .
        " group by r.id_reference order by stocks desc, count desc
        limit $offset, $limit";

$rows = null;

if (isset($_GET["id"])) {
    $rows = databaseFindOne($db, $sql, $params);
} else {
    $rows = databaseSelectAll($db, $sql, $params);
}

header("Content-Type: application/json");
if (!is_null($rows)) {
    $count_sql = "select count(id_reference) as count from reference r " . $whereSql;
    $total = databaseFindOne($db, $count_sql, $params)["count"];
    echo json_encode(["items" => $rows, "count" => $total]);
} else {
    http_response_code(500);
}
