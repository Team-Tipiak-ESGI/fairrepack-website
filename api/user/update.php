<?php

require_once __DIR__ . '/../../utils/database.php';
require_once __DIR__ . '/../../utils/UUIDv4.php';
require_once __DIR__ . '/../../utils/Token.php';
require_once __DIR__ . "/../../utils/user.php";
require_once __DIR__ . "/../../utils/dao/user.php";


$uuid = getToken()->getPayload()["uuid"];

$body = file_get_contents("php://input"); // Récupère le corps de la requête
$_POST = json_decode($body, true); // Décode je JSON du corps de la requête et le place dans la variable POST

$user_datas = getUserByUUID($uuid);


$email = $_POST["email"];
$username = $_POST["username"]; // Récupère le "username" entré dans le formulaire
$lastpwd = $_POST["lastpwd"];
$newpwd = $_POST["newpwd"];
$confirmpwd = $_POST["confirmpwd"];
$address = $_POST["address"];

$error = false;
$errors = [];

if (!empty($email)){
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
        $datas_to_send = ["email"=>$email];
        $set[] = "email = ?";
        $params[] = $email;
    }else{
        $error = true;
        $errors = ["Format de l'email invalide"];
    }
}
if (!empty($username)){
    if (strlen($username) <2 || strlen($username) >30 ){
        $datas_to_send = ["username"=>$username];
        $set[] = "username = ?";
        $params[] = $username;
    }else{
        $error = true;
        $errors = ["Nom d'utilisateur invalide"];
    }
}
if (!empty($lastpwd)){
    $connection = getDatabaseConnection();
    $hashed_password = hash('sha256', $lastpwd . SECRET);
    $sql = "select uuid_user from `user` where uuid = ? and password = ?";
    $res = databaseFindOne($connection, $sql, [$uuid, $hashed_password]);
    if (!$res){
        if( strlen($newpwd)<6
            || strlen($newpwd)>30
            || !preg_match("#[A-Z]#", $newpwd)
            || !preg_match("#[a-z]#", $newpwd)
            || !preg_match("#[0-9]#", $newpwd)){
            $error = true;
            $errors[] = "Le mot de passe doit contenir Majuscules, minuscules et chiffres à minimat.";
        }else{
            if ( $newpwd == $confirmpwd){
                $new_hashed_password = hash('sha256', $newpwd . SECRET);
                $datas_to_send = ["password"=>$new_hashed_password];
                $set[] = "password = ?";
                $params[] = $new_hashed_password;

            }else{
                $error = true;
                $errors[] = "les deux nouveaux mots de passe ne correspondent pas.";
            }
        }
    }else{
        $error = true;
        $errors[] = "Le mot de passe d'origine ne correspond pas.";
    }
}

if (!empty($address)) {
    if (strlen($address) < 20 || strlen($address) > 200) {
        $datas_to_send = ["address"=>$address];
        $set[] = "address";
        $params[] = $address;
    }else{
        $error = true;
        $errors[] = "Entrez un format d'adresse valide";
    }
}

$db = getDatabaseConnection();
$sql = "UPDATE user SET " . join(", ", $set) . " WHERE uuid_user = ?";
$success = databaseUpdate($db,$sql,$params);

if ($success) {
    http_response_code(201); // CREATED
    header("Content-Type: application/json");
} else {
    http_response_code(400);
}
