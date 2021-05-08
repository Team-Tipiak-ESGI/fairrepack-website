<?php

require_once __DIR__ . '/../../utils/user.php';

// User not authenticated
if (!getToken()->validate()) {
    http_response_code(401);
    die();
}

require_once __DIR__ . '/../../utils/dao/reference.php';
require_once __DIR__ . '/../../utils/dao/product.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if (isset($_POST["uuid_reference"])) {
    $uuid_reference = $_POST["uuid_reference"];

    $set = [];
    $params = [];

    if (isset($_POST["brand"])) {
        $set[] = "brand";
        $params[] = "brand";
    }
    if (isset($_POST["name"])) {
        $set[] = "name";
        $params[] = "name";
    }
    if (isset($_POST["value"])) {
        $set[] = "value";
        $params[] = "value";
    }
    if (isset($_POST["type"])) {
        $set[] = "type";
        $params[] = "type";
    }

    $params[] = $uuid_reference;

    $db = getDatabaseConnection();
    $sql = "UPDATE product SET " . join(", ", $set) . " WHERE uuid_reference = ?";
    $success = databaseUpdate($db, $sql, $params);

    if ($success) {
        $reference = getProductbyId($uuid_reference);

        http_response_code(201); // CREATED
        header("Content-Type: application/json");
        echo json_encode($reference);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400); // BAD_REQUEST
}



