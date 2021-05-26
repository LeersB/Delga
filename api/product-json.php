<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'class/producten.php';

$database = new Database();
$db = $database->getConnection();

if (isset($_GET['id'])) {

    $item = new Producten($db);
    $item->product_id = isset($_GET['id']) ? $_GET['id'] : die();
    $item->getSingleProduct();

    if ($item->product_naam != null) {
        // create array
        $emp_arr = array(
            "product_id" => $item->product_id,
            "categorie_id" => $item->categorie_id,
            "product_naam" => $item->product_naam,
            "product_foto" => $item->product_foto,
            "product_info" => $item->product_info,
            "omschrijving" => $item->omschrijving,
            "verpakking" => $item->verpakking,
            "waarschuwing" => $item->waarschuwing,
            "eenheidsprijs" => $item->eenheidsprijs
        );

        http_response_code(200);
        echo json_encode($emp_arr);
    } else {
        http_response_code(404);
        echo json_encode("Product not found.");
    }
}

else {

    $items = new Producten($db);
    $stmt = $items->getProducten();
    $itemCount = $stmt->rowCount();

    echo json_encode($itemCount);

    if ($itemCount > 0) {

        $productArr = array();
        $productArr["body"] = array();
        $productArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "product_id" => $product_id,
                "categorie_id" => $categorie_id,
                "product_naam" => $product_naam,
                "product_foto" => $product_foto,
                "product_info" => $product_info,
                "omschrijving" => $omschrijving,
                "verpakking" => $verpakking,
                "waarschuwing" => $waarschuwing,
                "eenheidsprijs" => $eenheidsprijs
            );
            array_push($productArr["body"], $e);
        }
        echo json_encode($productArr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
}
?>