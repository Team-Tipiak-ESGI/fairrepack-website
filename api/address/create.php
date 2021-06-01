<?php

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/user.php";

// User not authenticated
$token = getToken();
if (!$token->validate()) {
    http_response_code(401);
    die();
}

require_once __DIR__ . "/../../utils/dao/address.php";

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if (isset($_POST["name"])) {
    $country = $_POST["country"];
    $owner_name = $_POST["name"];
    $address_line1 = $_POST["address_line1"];
    $address_line2 = $_POST["address_line2"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $postal_code = $_POST["postal_code"];
    $phone_number = $_POST["phone_number"];
    $additional_info = $_POST["additional_info"];
    $type = $_POST["type"];

    $id = addAddress($type, $country, $owner_name, $address_line1, $address_line2, $city, $state, $postal_code, $phone_number, $additional_info);

    echo json_encode(getAddressByID($id));
} else {
    http_response_code(400);
}
