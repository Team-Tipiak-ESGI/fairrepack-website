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

if (isset($_POST["name"])) {
    $name        = $_POST["name"];
    $description = $_POST["description"] ?? NULL;
    $address     = $_POST["address"]     ?? NULL;
    $image       = $_POST["image"]       ?? NULL;

    $accept = [
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png',
        'image/jfif',
    ];

    $base64 = explode(";base64,", $image);
    $mime = substr($base64[0], 5);

    if (in_array($mime, $accept)) {
        $image = base64_decode($base64[1]);
    } else {
        $image = NULL;
    }

    $id = insertAssociation($name, $description, $address, $image, $mime);
    echo json_encode(getAssociationById($id));
} else {
    http_response_code(400);
}
