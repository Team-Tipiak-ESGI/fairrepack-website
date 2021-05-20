<?php

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die();
}

require_once __DIR__ . '/../../utils/user.php';

// User not authenticated
if (!getToken()->validate()) {
    http_response_code(401);
    die();
}

require_once __DIR__ . '/../../utils/dao/offer.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

$user = getToken()->getPayload()["uuid"];

if (isset($_POST["product"])) {
    $product = $_POST["product"];
    $price = $_POST["price"] ?? NULL;
    $note = $_POST["note"] ?? NULL;

    // Verify that product `state` column is `registered` or `sent`
    $productState = getProductByUUID($product)["state"];
    if ($productState == 'registered' || $productState == 'sent'){
        $lastOfferId = addOffer($user, $product, $price, $note);
        if ($lastOfferId) {
            $offer = getOfferbyId($lastOfferId);
            if ($offer) {
                http_response_code(201); // CREATED
                header("Content-Type: application/json");
                echo json_encode($offer);
            } else {
                http_response_code(500); // INTERNAL_SERVER_ERROR
            }
        } else {
            http_response_code(500); // INTERNAL_SERVER_ERROR
        }
    }else{
        http_response_code(400); // BAD_REQUEST
    }
} else {
    http_response_code(400); // BAD_REQUEST
}



