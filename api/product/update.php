<?php

require_once __DIR__ . '/../../utils/functions.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if(isset($_POST["id_product"])) {
    $id_product = $_POST["id_product"];

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
    if (isset($_POST["warehouse"])) {
        $set[] = "warehouse = ?";
        $params[] = $_POST["warehouse"];
    }

    $params[] = $id_product;

    $db = getDatabaseConnection();
    $sql = "UPDATE product SET " . join(", ", $set) . " WHERE id_product = ?";
    $success = databaseUpdate($db, $sql, $params);

    if ($success) {
        $product = getProductbyId($id_product);

        http_response_code(201); // CREATED
        header("Content-Type: application/json");
        echo json_encode($product);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400); // BAD_REQUEST
}
