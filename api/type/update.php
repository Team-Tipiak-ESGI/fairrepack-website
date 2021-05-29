<?php

require_once __DIR__ . "/../../utils/user.php";

// User not authenticated and is not admin
$token = getToken();
if (!$token->validate() || $token->getPayload()["type"] !== "admin") {
    http_response_code(401);
    die();
}

require_once __DIR__ . "/../../utils/dao/type.php";

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
    if (isset($_POST["category"])) {
        $set[] = "category = ?";
        $params[] = $_POST["category"];
    }

    $params[] = $id;

    $db = getDatabaseConnection();
    $sql = "UPDATE type SET " . join(", ", $set) . " WHERE id_type = ?";
    $success = databaseUpdate($db, $sql, $params);

    if ($success) {
        $product = getTypeByID($id);

        http_response_code(201); // CREATED
        header("Content-Type: application/json");
        echo json_encode($product);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400); // BAD_REQUEST
}
