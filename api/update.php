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

$data = json_decode(file_get_contents("php://input"));

$item->product_id = $data->product_id;

// employee values
$item->product_naam = $data->product_naam;
$item->product_foto = $data->product_foto;
$item->product_info = $data->product_info;
$item->omschrijving = $data->omschrijving;
$item->verpakking = $data->verpakking;
$item->waarschuwing = $data->waarschuwing;
$item->eenheidsprijs = $data->eenheidsprijs;

if($item->updateProduct()){
    echo json_encode("Product data updated.");
} else{
    echo json_encode("Data could not be updated");
}
?>