<?php

require_once __DIR__ . '/../database.php';

function addAddress(string $country, string $owner_name, string $address_line1, string $address_line2, string $city,
                    string $state, string $postal_code, string $phone_number, string $additional_info): string
{
    $db = getDatabaseConnection();
    $sql = "INSERT INTO address (country, owner_name, address_line1, address_line2, city, state, postal_code, phone_number, additional_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [
        $country,
        $owner_name,
        $address_line1,
        $address_line2,
        $city,
        $state,
        $postal_code,
        $phone_number,
        $additional_info
    ];

    return databaseInsert($db, $sql, $params);
}

function deleteAddressByID(string $id): int
{
    $db = getDatabaseConnection();
    $sql = "DELETE FROM address WHERE id_address = ?";
    $params = [$id];
    return databaseDelete($db, $sql, $params);
}

function getAddressByID(string $id): array
{
    $db = getDatabaseConnection();
    $sql = "SELECT country, owner_name, address_line1, address_line2, city, state, postal_code, phone_number, additional_info FROM address WHERE id_address = ?";
    $params = [$id];
    return databaseFindOne($db, $sql, $params);
}