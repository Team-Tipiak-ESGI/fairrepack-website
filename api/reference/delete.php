<?php

require_once __DIR__ . '/../../utils/user.php';

// User not authenticated
if (!getToken()->validate()) {
    http_response_code(401);
    die();
}

require_once __DIR__ . '/../../utils/dao/reference.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);


if(isset($_POST["uuid_reference"]) ) {
    $uuid_reference = $_POST["uuid_reference"];

    $success = deleteReferenceByUUID($uuid_reference);

    if ($success) {
        http_response_code(204); // NO_CONTENT
    } else {
        http_response_code(400); // BAD_REQUEST
    }
} else {
    http_response_code(400); // BAD_REQUEST
}
