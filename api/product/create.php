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

if (isset($_POST["reference"])) {
    $reference = $_POST["reference"];
    $user = getToken()->getPayload()['uuid'];
    $description = $_POST["description"] ?? NULL;
    $state = $_POST["state"] ?? "registered";
    $quality = $_POST["quality"] ?? NULL;
    $warehouse = $_POST["warehouse"] ?? 1;
    $price = $_POST["price"] ?? NULL;

    $lastProductId = addProduct($reference, $user, $description, $state, $quality, $warehouse, $price);

    if ($lastProductId) {
        $product = getProductbyId($lastProductId);
        if ($product) {
            http_response_code(201); // CREATED
            header("Content-Type: application/json");
            echo json_encode($product);
        } else {
            http_response_code(500); // INTERNAL_SERVER_ERROR
        }
    } else {
        http_response_code(500); // INTERNAL_SERVER_ERROR
    }
} else {
    http_response_code(400); // BAD_REQUEST
}
