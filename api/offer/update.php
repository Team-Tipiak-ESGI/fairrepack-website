<?php

require_once __DIR__ . '/../../utils/user.php';

// User not authenticated
if (!getToken()->validate()) {
    http_response_code(401);
    die();
}

require_once __DIR__ . '/../../utils/dao/offer.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if(isset($_POST["id_offer"])) {
    $id_offer = $_POST["id_offer"];

    $set = [];
    $params = [];
    if (isset($_POST["user"])) {
        $set[] = "user = ?";
        $params[] = $_POST["user"];
    }
    if (isset($_POST["product"])) {
        $set[] = "product = ?";
        $params[] = $_POST["product"];
    }
    if (isset($_POST["price"])) {
        $set[] = "price = ?";
        $params[] = $_POST["price"];
    }
    if (isset($_POST["note"])) {
        $set[] = "note = ?";
        $params[] = $_POST["note"];
    }

    $params[] = $id_offer;

    $db = getDatabaseConnection();
    $sql = "UPDATE offer SET " . join(", ", $set) . " WHERE id_offer = ?";
    $success = databaseUpdate($db, $sql, $params);

    if ($success) {
        $product = getOfferById($id_offer);

        http_response_code(201); // CREATED
        header("Content-Type: application/json");
        echo json_encode($product);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400); // BAD_REQUEST
}
