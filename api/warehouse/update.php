<?php

require_once __DIR__ . "/../../utils/user.php";

// User not authenticated and is not admin
$token = getToken();
if (!$token->validate() || $token->getPayload()["type"] !== "admin") {
    http_response_code(401);
    die();
}

require_once __DIR__ . "/../../utils/dao/warehouse.php";

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if(isset($_POST["id"])) {
    $id = $_POST["id"];

    $set = [];
    $params = [];
    if (isset($_POST["name"])) {
        $set[] = "name = ?";
        $params[] = $_POST["name"];
    }
    if (isset($_POST["address"])) {
        $set[] = "address = ?";
        $params[] = $_POST["address"];
    }

    $params[] = $id;

    $db = getDatabaseConnection();
    $sql = "UPDATE warehouse SET " . join(", ", $set) . " WHERE id_warehouse = ?";
    $success = databaseUpdate($db, $sql, $params);

    if ($success) {
        $product = getWarehouseByID($id);

        http_response_code(201); // CREATED
        header("Content-Type: application/json");
        echo json_encode($product);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400); // BAD_REQUEST
}
