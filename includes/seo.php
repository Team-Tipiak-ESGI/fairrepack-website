<?php
require_once __DIR__ . "/../utils/database.php";
require_once __DIR__ . "/../utils/dao/product.php";

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domain = $protocol . $_SERVER["SERVER_NAME"];
$id = $_GET["id"] ?? "";
$site_name = "FairRepack";

switch ($_SERVER["PHP_SELF"]) {
    case "/product.php":
        $product = getProductByUUID($id);
        if ($product === NULL) {
            http_response_code(404);
            break;
        }
        $reference = getReferenceByUUID($product["uuid_reference"]);
        $description = $product["description"];
        $image_url = "$domain/image/$id/1";
        $title = $reference["brand"] . " " . $reference["name"];
        $mime = getProductImage($id, 1)["mime"] ?? "";

        echo "<title>FairRepack - $title</title>";

        echo "<meta name='description' content='$description'>";
        echo "<meta name='og:type' property='og:type' content='product'>";
        echo "<meta name='og:url' property='og:url' content='$domain'>";
        echo "<meta name='og:title' property='og:title' content='$title'>";
        echo "<meta name='og:description' property='og:description' content='$description'>";
        echo "<meta name='og:image' property='og:image' content='$image_url'>";
        echo "<meta name='og:image:type' property='og:image:type' content='$mime'>";

        echo "<meta name='og:site_name' property='og:site_name' content='$site_name'>";
        echo "<meta name='og:locale' property='og:locale' content='en_US'>";

        echo "<meta name='twitter:card' content='summary_large_image'>";
        echo "<meta name='twitter:url' content='$domain'>";
        echo "<meta name='twitter:title' content='$title'>";
        echo "<meta name='twitter:description' content='$description'>";
        echo "<meta name='twitter:image' content='$image_url'>";

        break;
    case "/reference.php":
        $reference = getReferenceByUUID($id);
        if ($reference === NULL) {
            http_response_code(404);
            break;
        }
        $title = $reference["brand"] . " " . $reference["name"];

        echo "<title>FairRepack - $title</title>";

        echo "<meta name='description' content='Shop $title on $site_name!'>";
        echo "<meta name='og:type' property='og:type' content='product'>";
        echo "<meta name='og:url' property='og:url' content='$domain'>";
        echo "<meta name='og:title' property='og:title' content='$title'>";
        echo "<meta name='og:description' property='og:description' content='$title'>";

        echo "<meta name='og:site_name' property='og:site_name' content='$site_name'>";
        echo "<meta name='og:locale' property='og:locale' content='en_US'>";

        echo "<meta name='twitter:card' content='summary'>";
        echo "<meta name='twitter:url' content='$domain'>";
        echo "<meta name='twitter:title' content='$title'>";
        echo "<meta name='twitter:description' content='$title'>";
        break;
    default:
        echo "<title>FairRepack</title>";
        echo "<meta name='description' content='Shop on $site_name!'>";
        break;
}

if (http_response_code() === 404) {
    header("Location: /404.php");
    http_response_code(404);
}
