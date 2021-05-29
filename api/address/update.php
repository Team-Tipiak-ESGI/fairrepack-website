<?php

require_once __DIR__ . "/../../utils/user.php";

// User not authenticated and is not admin
$token = getToken();
if (!$token->validate() || $token->getPayload()["type"] !== "admin") {
    http_response_code(401);
    die();
}

require_once __DIR__ . "/../../utils/dao/address.php";

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if(isset($_POST["id"])) {
    $id = $_POST["id"];

    $set = [];
    $params = [];
    if (isset($_POST["country"])) {
        $set[] = "country = ?";
        $params[] = $_POST["country"];
    }
    if (isset($_POST["owner_name"])) {
        $set[] = "owner_name = ?";
        $params[] = $_POST["owner_name"];
    }
    if (isset($_POST["address_line1"])) {
        $set[] = "address_line1 = ?";
        $params[] = $_POST["address_line1"];
    }
    if (isset($_POST["address_line2"])) {
        $set[] = "address_line2 = ?";
        $params[] = $_POST["address_line2"];
    }
    if (isset($_POST["city"])) {
        $set[] = "city = ?";
        $params[] = $_POST["city"];
    }
    if (isset($_POST["state"])) {
        $set[] = "state = ?";
        $params[] = $_POST["state"];
    }
    if (isset($_POST["postal_code"])) {
        $set[] = "postal_code = ?";
        $params[] = $_POST["postal_code"];
    }
    if (isset($_POST["phone_number"])) {
        $set[] = "phone_number = ?";
        $params[] = $_POST["phone_number"];
    }
    if (isset($_POST["additionnal_info"])) {
        $set[] = "additionnal_info = ?";
        $params[] = $_POST["additionnal_info"];
    }

    $params[] = $id;

    $db = getDatabaseConnection();
    $sql = "UPDATE address SET " . join(", ", $set) . " WHERE id_address = ?";
    $success = databaseUpdate($db, $sql, $params);

    if ($success) {
        $product = getAddressByID($id);

        http_response_code(201); // CREATED
        header("Content-Type: application/json");
        echo json_encode($product);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400); // BAD_REQUEST
}
