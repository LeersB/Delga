<?php
//include 'main.php';
//$pdo_function = pdo_connect_mysql();

class DBController {
    private $conn = "";
    private $host = "localhost";
    private $user = "delga";
    private $password = "Hbutciaf-2304";
    private $database = "delgatest";

    function __construct() {
        $conn = $this->connectDB();
        if(!empty($conn)) {
            $this->conn = $conn;
        }
    }

    function connectDB() {
        $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        return $conn;
    }

    function executeSelectQuery($query) {
        $result = mysqli_query($this->conn,$query);
        while($row=mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if(!empty($resultset))
            return $resultset;
    }
}
?>
