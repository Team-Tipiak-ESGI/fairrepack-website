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


// All fields are required
if (isset($_POST["brand"]) && isset($_POST["name"]) && isset($_POST["value"]) && isset($_POST["type"])) {
    $brand = $_POST["brand"] ?? NULL;
    $name = $_POST["name"] ?? NULL;
    $value = $_POST["value"] ?? NULL;
    $type = $_POST["type"] ?? NULL;

    $lastReference = addReference($brand,$name,$value,$type);

    if($lastReference) {
        $reference = getReferenceByID($lastReference);
        if ($reference) {


            http_response_code(201); // CREATED
            header("Content-Type: application/json");
        }else {
            http_response_code(500); // INTERNAL_SERVER_ERROR
        }
    }else {
        http_response_code(500); // INTERNAL_SERVER_ERROR
    }

} else {
    http_response_code(400); // BAD_REQUEST
}





