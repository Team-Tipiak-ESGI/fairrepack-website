<?php

require_once __DIR__ . '/../../utils/user.php';

// User not authenticated
if (!getToken()->validate()) {
    http_response_code(401);
    die();
}

require_once __DIR__ . '/../../utils/functions.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if(isset($_POST["user"]) && isset($_POST["product"]))
{
    $user = $_POST["user"];
    $product = $_POST["product"];
    $price = $_POST["price"]??NULL;
    $note = $_POST["note"]??NULL;

    $lastOfferId = addOffer($user,$product, $price, $note);
    if($lastOfferId) {
        $offer = getOfferbyId($lastOfferId);
        if($offer) {
            http_response_code(201); // CREATED
            header("Content-Type: application/json");
            echo json_encode($offer);
        } else {
            http_response_code(500); // INTERNAL_SERVER_ERROR
        }
    } else {
        http_response_code(500); // INTERNAL_SERVER_ERROR
    }
} else {
    http_response_code(400); // BAD_REQUEST
}



