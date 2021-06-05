<?php
require_once __DIR__ . "/../../utils/database.php";

$request = $_SERVER['REQUEST_URI'];

$request = preg_replace('/^' . preg_quote('/image/', '/') . '/', '', $request);
list($table, $product, $image) = explode('/', $request, 3);

function errorImage() {
    header("Content-type: image/png");
    $im = @imagecreate(200, 200) or die("Failed to init GD library");
    $background_color = imagecolorallocate($im, 255, 255, 255);
    $text_color = imagecolorallocate($im, 233, 14, 91);
    imagestring($im, 10, 20, 100 - 10, "No image available", $text_color);
    imagepng($im);
    imagedestroy($im);
    die();
}

switch ($table) {
    case "product":
        $sql = "select r.image, r.mime
                    from (select row_number() over(partition by p.id_product) as row_num, image, mime
                          from product p
                          join image i on p.id_product = i.product
                          where p.uuid_product = ?) r
                    where r.row_num = ?";

        $image = empty($image) ? 1 : $image;

        $con = getDatabaseConnection();
        $res = databaseFindOne($con, $sql, [$product, $image]);

        if (is_null($res)) errorImage();

        header("Content-type: " . $res["mime"]);
        echo $res["image"];
        break;
    case "association":
        $sql = "select image, mime from association where uuid_association = ?";

        $con = getDatabaseConnection();
        $res = databaseFindOne($con, $sql, [$product]);

        if (is_null($res)) errorImage();

        header("Content-type: " . $res["mime"]);
        echo $res["image"];
        break;
}