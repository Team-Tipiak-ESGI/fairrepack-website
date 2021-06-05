<?php
require_once __DIR__ . '/../../utils/user.php';

$err = verifyAccess("POST", true, "admin");
if (!is_null($err)) {
    http_response_code($err);
    die();
}

require_once __DIR__ . '/../../utils/dao/association.php';

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if(isset($_POST["id"]) ) {
    $uuid_association = $_POST["id"];

    $success = deleteAssociationByUUID($uuid_association);

    if ($success) {
        http_response_code(204); // NO_CONTENT
    } else {
        http_response_code(400); // BAD_REQUEST
    }
} else {
    http_response_code(400); // BAD_REQUEST
}
