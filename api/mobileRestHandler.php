<?php
require_once("simpleRest.php");
require_once("mobile.php");

class mobileRestHandler extends simpleRest {

    function getAllMobiles() {

        $mobile = new mobile();
        $rawData = $mobile->getAllMobile();

        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No mobiles found!');
        } else {
            $statusCode = 200;
        }

        $requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);

        $result["output"] = $rawData;

        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($result);
            echo $response;
        }
    }

    public function encodeJson($responseData) {
        $jsonResponse = json_encode($responseData);
        return $jsonResponse;
    }
}
?>