<?php

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die();
}

require_once __DIR__ . "/../../utils/database.php";
require_once __DIR__ . "/../../utils/user.php";

if (isset($_GET["id"])) {
    $uuid = $_GET["id"];
    $token = getToken();
    $token_uuid = NULL;

    if (!is_null($token))
        $token_uuid = $token->getPayload()['uuid'];
    $same = strcmp($token_uuid, $uuid) === 0;


    $db = getDatabaseConnection();
    header("Content-Type: application/json");

    $sql = NULL;

    if ($same)
        $sql = "select username, email, language, user_type, created
                    from user
                    where uuid_user = ?";
    else
        $sql = "select username, language, user_type, created
                from user
                where uuid_user = ?";
    $user = databaseFindOne($db, $sql, [$_GET["id"]]);

    if ($same) {
        $sql = "select country, owner_name, address_line1, address_line2, city, state, postal_code, phone_number, additional_info
                    from user
                    join address a on user.address = a.id_address
                    where user.uuid_user = ?";
        $address = databaseFindOne($db, $sql, [$_GET["id"]]);
    }

    $sql = "select uuid_product, state, quality, description, p.created,
                r.brand, r.name,
                t.name as type, c.name as category
                from user
                join product p on user.id_user = p.user
                join reference r on p.reference = r.id_reference
                join type t on r.type = t.id_type
                join category c on t.category = c.id_category
                where user.uuid_user = ?";
    $products = databaseSelectAll($db, $sql, [$_GET["id"]]);

    $sql = "select uuid_product, note, price, o.created
                from user
                join product p on user.id_user = p.user
                join offer o on user.id_user = o.user and p.id_product = o.product
                where user.uuid_user = ?";
    $offers = databaseSelectAll($db, $sql, [$_GET["id"]], PDO::FETCH_GROUP);

    $sql = "select uuid_product, r.note, r.content, r.date
                from user
                join product p on user.id_user = p.user
                join review r on user.id_user = r.user and p.id_product = r.product
                where user.uuid_user = ?";
    $reviews = databaseSelectAll($db, $sql, [$_GET["id"]], PDO::FETCH_GROUP);

    echo json_encode([
        "information" => $user,
        "address" => $address ?? [],
        "products" => $products,
        "offers" => $offers,
        "reviews" => $reviews,
    ]);

    /*$sql = "select user.id_user, user.uuid_user, user.username, user.password, user.email, user.language, user.address, user.user_type, user.created,
               hl.id_history_login, hl.user, hl.date, hl.useragent, hl.ip, hu.id_history_useragent, hu.useragent, hi.id_history_ip, hi.ip,
               a.id_address, a.country, a.owner_name, a.address_line1, a.address_line2, a.city, a.state, a.postal_code, a.phone_number, a.additional_info,
               o.id_offer, o.user, o.product, o.price, o.note, o.created,
               p.id_product, p.uuid_product, p.user, p.state, p.quality, p.description, p.reference, p.warehouse, p.created,
               r.user, r.product, r.date, r.content, r.note
               from user
               right join history_login hl on user.id_user = hl.user
               right join history_useragent hu on hu.id_history_useragent = hl.useragent
               right join history_ip hi on hi.id_history_ip = hl.ip
               right join address a on a.id_address = user.address
               right join offer o on user.id_user = o.user
               right join product p on o.product = p.id_product
               right join review r on user.id_user = r.user
               where uuid_user = ?";*/
} else {
    http_response_code(400); // BAD_REQUEST
}
