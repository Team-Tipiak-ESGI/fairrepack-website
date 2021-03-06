<?php

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/user.php";

// User not authenticated and is admin
$token = getToken();
if (!$token->validate() || $token->getPayload()["type"] !== "admin") {
    http_response_code(401);
    die();
}

require_once __DIR__ . "/../../utils/dao/warehouse.php";

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if (isset($_POST["name"]) && isset($_POST["address"])) {
    $name = $_POST["name"];
    $address = $_POST["address"];

    $id = addWarehouse($name, $address);

    echo json_encode(getWarehouseByID($id));
} else {
    http_response_code(400);
}
