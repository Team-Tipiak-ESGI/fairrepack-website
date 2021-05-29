<?php

require_once __DIR__ . "/../../utils/database.php";

$warehouse = $_GET['warehouse.php'] ?? NULL;

$db = getDatabaseConnection();
$sql = "SELECT r.id_reference as reference, r.brand, r.name, count(r.id_reference) AS count FROM product
        JOIN reference r ON r.id_reference = product.reference "
        . (!empty($warehouse) ? " WHERE warehouse.php = ? " : " ") .
        " GROUP BY r.id_reference";

$params = !empty($warehouse) ? [$warehouse] : [];

$rows = databaseSelectAll($db, $sql, $params);

$xml = new SimpleXMLElement('<stocks/>');

foreach ($rows as $row) {
    $reference = $xml->addChild("reference");
    $reference->addAttribute("id", $row['reference']);
    $reference->addAttribute("amount", $row['count']);
    $reference->addAttribute("brand", $row['brand']);
    $reference->addAttribute("name", $row['name']);
}

header('Content-Type: application/xml');

echo $xml->asXML();
