<?php

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

if(isset($_POST["id"]) ) {
    $success = deleteWarehouseByID($_POST["id"]);

    if ($success) {
        http_response_code(204); // NO_CONTENT
    } else {
        http_response_code(400); // BAD_REQUEST
    }
} else {
    http_response_code(400); // BAD_REQUEST
}
