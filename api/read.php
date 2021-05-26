<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'config/database.php';
include_once 'class/producten.php';

$database = new Database();
$db = $database->getConnection();

$items = new Producten($db);

$stmt = $items->getProducten();
$itemCount = $stmt->rowCount();


echo json_encode($itemCount);

if($itemCount > 0){

    $productArr = array();
    $productArr["body"] = array();
    $productArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
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
}

else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}
?>