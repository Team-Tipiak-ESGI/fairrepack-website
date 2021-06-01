<?php

ini_set("display_errors", 1); // affiche les erreurs

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/user.php";

// User not authenticated
$token = getToken();
if (!$token || !$token->validate()) {
    http_response_code(401);
    die();
}

require_once __DIR__ . "/../../utils/database.php";
require_once __DIR__ . "/../../utils/dao/user.php";
require_once __DIR__ . "/../../utils/dao/address.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $address = getAddressByID($id);
    $user = getUserByUUID($token->getPayload()["uuid"]);

    // User is not owner of address
    if ($user["address"] !== $id || $token->getPayload()["type"] !== "admin") {
        http_response_code(401);
        die();
    }

    echo json_encode($address);
} else if ($token->getPayload()["type"] === "admin") {
    $type = $_GET["type"];
    $whereSql = isset($type) ? "where type = ?" : "";

    $sql = "select id_address, country, owner_name, address_line1, address_line2, city, state, postal_code, phone_number, additional_info from address $whereSql";

    $connection = getDatabaseConnection();
    $items = databaseSelectAll($connection, $sql, isset($type) ? [$type] : []);
    $total = databaseFindOne($connection, "select count(*) as count from address")["count"];
    echo json_encode(["items" => $items, "count" => $total]);
} else {
    http_response_code(400);
}
