<?php
require_once("mobileRestHandler.php");

$view = "";
if(isset($_GET["view"]))
    $view = $_GET["view"];
/*
controls the RESTful services
URL mapping
*/
switch($view){

    case "all":
        // to handle REST Url /mobile/list/
        $mobileRestHandler = new mobileRestHandler();
        $mobileRestHandler->getAllMobiles();
        break;

    case "" :
        //404 - not found;
        break;
}
?>
