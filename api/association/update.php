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

if (isset($_POST["id_association"])){

    $id_assoc = $_POST["id_association"];
    $set = [];
    $params = [];
    if (isset($_POST["name"])) {
        $set[] = "name = ?";
        $set[] = $_POST["name"];
    }
    if (isset($_POST["description"])){
        $set[] = "description = ?";
        $params[] = $_POST["description"];
    }
    if (isset($_POST["address"])){
        $set[] = "address = ?";
        $params[] = $_POST["address"];
    }
    if (isset($_POST["coin"])){
        $set[] = "coin = ?";
        $params[] = $_POST["coin"];
    }
    if (isset($_POST["image"])){
        $set[] = "image = ?";
        $params[] = $_POST["image"];
    }

    $params[] = $id_assoc;
    $db = getDatabaseConnection();
    $sql = "UPDATE association SET" . join(", ", $set);
    $success = databaseUpdate($db, $sql, $params);

    if ($success){
        $assoc = getAssociationById($id_assoc);

        http_response_code(201); // Created
        header("Content-Type: application/json");
        echo json_encode($assoc);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400); // BAD REQUEST
}