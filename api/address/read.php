<?php

ini_set("display_errors", 1); // affiche les erreurs

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die();
}

// User not authenticated
$token = getToken();
if (!$token->validate()) {
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
}
