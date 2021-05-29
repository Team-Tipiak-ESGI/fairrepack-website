<?php

require_once __DIR__ . '/../../utils/user.php';

// User not authenticated
if (!getToken()->validate()) {
    http_response_code(401);
    die();
}

require_once __DIR__ . '/../../utils/dao/product.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if(isset($_POST["id_product"])) {
    $uuid_product = $_POST["id_product"];

    $product = getProductByUUID($uuid_product);

    // User is not owner of product or not admin
    $payload = getToken()->getPayload();
    if ($product["uuid_user"] !== $payload["uuid"] && $payload["type"] !== "admin") {
        http_response_code(403);
        die();
    }

    $set = [];
    $params = [];
    if (isset($_POST["reference"])) {
        $set[] = "reference = ?";
        $params[] = $_POST["reference"];
    }
    if (isset($_POST["description"])) {
        $set[] = "description = ?";
        $params[] = $_POST["description"];
    }
    if (isset($_POST["state"])) {
        $set[] = "state = ?";
        $params[] = $_POST["state"];
    }
    if (isset($_POST["quality"])) {
        $set[] = "quality = ?";
        $params[] = $_POST["quality"];
    }
    if (isset($_POST["warehouse.php"])) {
        $set[] = "warehouse.php = ?";
        $params[] = $_POST["warehouse.php"];
    }

    $params[] = $uuid_product;

    $db = getDatabaseConnection();
    $sql = "UPDATE product SET " . join(", ", $set) . " WHERE uuid_product = ?";
    $success = databaseUpdate($db, $sql, $params);

    if ($success) {
        $product = getProductbyId($uuid_product);

        http_response_code(201); // CREATED
        header("Content-Type: application/json");
        echo json_encode($product);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400); // BAD_REQUEST
}
