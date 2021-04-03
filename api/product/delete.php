<?php

require_once __DIR__ . '/../../utils/functions.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if(isset($_POST["id_product"]) ) {
    $id_product = $_POST["id_product"];

    $success = deleteProductById($id_product);

    if ($success) {
        http_response_code(204); // NO_CONTENT
    } else {
        http_response_code(400); // BAD_REQUEST
    }
} else {
    http_response_code(400); // BAD_REQUEST
}