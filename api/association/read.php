<?php

ini_set("display_errors", 1); // affiche les erreurs

if($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405); // BAD RESQUEST
    die();
}

require_once __DIR__ . "/../../utils/database.php";

$db = getDatabaseConnection();
$sql = "SELECT id_association, name, address, coin, description FROM association";
$rows = databaseSelectAll($db, $sql);
header("Content-Type: application/json");

