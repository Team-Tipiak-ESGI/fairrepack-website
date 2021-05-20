<?php

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die();
}

require_once __DIR__ . '/../../utils/user.php';
require_once __DIR__ . '/../../utils/dao/association.php';

if (!getToken()->validate()){
    http_response_code(401);
    die();
}

if(getToken()->getPayload()["type"] !== "admin"){
    http_response_code(403);
    die();
}

if (isset($_POST["name"])) {
    $name = $_POST["name"];
    $description = $_POST["description"] ?? NULL;
} else {
    http_response_code(400);
}
