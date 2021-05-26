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

$item = new Producten($db);

$item->product_id = isset($_GET['id']) ? $_GET['id'] : die();

$item->getSingleProduct();

if($item->product_naam != null){
    // create array
    $emp_arr = array(
        "product_id" =>  $item->product_id,
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
}

else{
    http_response_code(404);
    echo json_encode("Product not found.");
}
?>