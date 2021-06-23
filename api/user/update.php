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
$username = $_POST["username"];
$lastpwd = $_POST["lastpwd"];
$newpwd = $_POST["newpwd"];
$confirmpwd = $_POST["confirmpwd"];
$phone = $_POST["phone"];

//Adresse
$country = $_POST["country"];
$zipcode = $_POST["zipcode"];
$city = $_POST["city"];
$address = $_POST["address"];
$owner_name = $_POST["owner_name"];

//complémentaire
$add_infos = $_POST["add_infos"];

$error = false;
$errors = [];

$set = [];
$params = [];
$set1 = [];
$params1 = [];


if (!empty($email)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $set[] = "email = ?";
        $params[] = $email;
    } else {
        $error = true;
        $errors = ["Format de l'email invalide"];
    }
}


if (!empty($username)) {
    if (strlen($username) > 2 && strlen($username) < 30) {
        $set[] = "username = ?";
        $params[] = $username;
    } else {
        $error = true;
        $errors = ["Nom d'utilisateur invalide"];
    }

}
if (!empty($lastpwd)) {
    $connection = getDatabaseConnection();
    $hashed_password = hash('sha256', $lastpwd . SECRET);
    $sql = "select uuid_user from `user` where uuid_user = ? and password = ?";
    $res = databaseFindOne($connection, $sql, [$uuid, $hashed_password]);
    if (!$res) {
        if (strlen($newpwd) < 6
            || strlen($newpwd) > 30
            || !preg_match("#[A-Z]#", $newpwd)
            || !preg_match("#[a-z]#", $newpwd)
            || !preg_match("#[0-9]#", $newpwd)) {
            $error = true;
            $errors[] = "Le mot de passe doit contenir Majuscules, minuscules et chiffres à minimat.";
        } else {
            if ($newpwd == $confirmpwd) {
                $new_hashed_password = hash('sha256', $newpwd . SECRET);

                $set[] = "password = ?";
                $params[] = $new_hashed_password;

            } else {
                $error = true;
                $errors[] = "les deux nouveaux mots de passe ne correspondent pas.";
            }
        }
    } else {
        $error = true;
        $errors[] = "Le mot de passe d'origine ne correspond pas.";
    }
}
if (!empty($phone)) {
    if (!preg_match("#^0[1-9][0-9]{8}$#", $phone)) {
        $error = true;
        $errors[] = "Numéro incorrect";
    } else {
        $set1[] = "phone_number = ?";
        $params1[] = $phone;
    }
}
if (!empty($country)) {
    if (strlen($country) > 2 && strlen($country) < 20) {
        $set1[] = "state = ?";
        $params1[] = $country;
    } else {
        $error = true;
        $errors = ["nom du pays invalide"];
    }
}
if (!empty($zipcode)) {
    if (strlen($zipcode) > 2 && strlen($zipcode) < 10) {
        $set1[] = "postal_code = ?";
        $params1[] = $zipcode;
    } else {
        $error = true;
        $errors = ["code postal invalide"];
    }
}
if (!empty($city)) {
    if (strlen($city) > 2 && strlen($city) < 30) {
        $set1[] = "city = ?";
        $params1[] = $city;
    } else {
        $error = true;
        $errors = ["Format de ville invalide"];
    }
}
if (!empty($address)) {
    if (strlen($address) > 10 && strlen($address) < 80) {
        $set1[] = "address_line1 = ?";
        $params1[] = $address;
    } else {
        $error = true;
        $errors = ["Mauvais format de l'adresse"];
    }
}
if (!empty($owner_name)) {
    if (strlen($owner_name) > 10 && strlen($owner_name) < 70) {
        $set1[] = "owner_name = ?";
        $params1[] = $owner_name;
    } else {
        $error = true;
        $errors = ["Nom invalide"];
    }
}
if (!empty($add_infos)) {
    if (strlen($add_infos) > 1 && strlen($add_infos) < 1000) {
        $set1[] = "additional_info = ?";
        $params1[] = $add_infos;
    } else {
        $error = true;
        $errors = ["Visiblement on aime pas ce que t'as écrit"];
    }
}


$db = getDatabaseConnection();
if (!empty($params1) && !empty($set1)) {
    var_dump($params1);
    var_dump($set1);
    $address_id = databaseFindOne($db, "SELECT address FROM user WHERE uuid_user = ?", [$uuid])["address"];
    var_dump($address_id);
    if (is_null($address_id)) {
        $sqladdress = "INSERT INTO address SET " . join(", ", $set1);
        var_dump($sqladdress);
        $address_id = databaseInsert($db, $sqladdress, $params1);
        databaseUpdate($db,"update user set address = ? WHERE uuid_user = ?", [$address_id,$uuid]);
    } else {
        $params1[]= $address_id;
        $sqladdress = "UPDATE address SET " . join(", ", $set1) . " WHERE id_address = ?";
        var_dump($sqladdress);
        databaseUpdate($db, $sqladdress, $params1);
    }
}
if (!empty($params) && !empty($set)) {
    $params[] = $uuid;
    var_dump($params);
    var_dump($set);
    $sqluser = "UPDATE user SET " . join(", ", $set) . " WHERE uuid_user = ?";
    var_dump($sqluser);
    $success = databaseUpdate($db, $sqluser, $params);


    if ($success) {
        http_response_code(201); // CREATED
        header("Content-Type: application/json");
    } else {
        http_response_code(400);
    }
}

