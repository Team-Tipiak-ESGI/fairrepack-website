<?php

require_once __DIR__ . "/../../utils/user.php";

$uuid = getToken()->getPayload()["uuid"];

$body = file_get_contents("php://input"); // Récupère le corps de la requête
$_POST = json_decode($body, true); // Décode je JSON du corps de la requête et le place dans la variable POST

$username = $_POST["username"]; // Récupère le "username" entré dans le formulaire



?>