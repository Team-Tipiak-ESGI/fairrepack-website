<?php

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/user.php";

// User not authenticated and is admin
$token = getToken();
if (!$token->validate() || $token->getPayload()["type"] !== "admin") {
    http_response_code(401);
    die();
}

require_once __DIR__ . "/../../utils/dao/type.php";

$body = file_get_contents("php://input");
$_POST = json_decode($body, true);

if (isset($_POST["name"]) && isset($_POST["category"])) {
    $name = $_POST["name"];
    $category = $_POST["category"];

    $id = addType($name, $category);

    echo json_encode(getTypeByID($id));
} else {
    http_response_code(400);
}
