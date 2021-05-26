<?php
class Producten{

    // Connection
    private $conn;

    // Table
    private $db_table = "producten";

    // Columns
    public $product_id;
    public $product_naam;
    public $product_foto;
    public $product_info;
    public $omschrijving;
    public $verpakking;
    public $waarschuwing;
    public $eenheidsprijs;

    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }

    // GET ALL
    public function getProducten(){
        $sqlQuery = "SELECT product_id, product_naam, product_foto, product_info, omschrijving, verpakking, waarschuwing, eenheidsprijs FROM " . $this->db_table . " WHERE product_level = 'actief'";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createProducten(){
        $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        product_naam = :product_naam, 
                        product_foto = :product_foto, 
                        product_info = :product_info, 
                        omschrijving = :omschrijving, 
                        verpakking = :verpakking,
                        waarschuwing = :waarschuwing,
                        eenheidsprijs = :eenheidsprijs";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->product_naam=htmlspecialchars(strip_tags($this->product_naam));
        $this->product_foto=htmlspecialchars(strip_tags($this->product_foto));
        $this->product_info=htmlspecialchars(strip_tags($this->product_info));
        $this->omschrijving=htmlspecialchars(strip_tags($this->omschrijving));
        $this->verpakking=htmlspecialchars(strip_tags($this->verpakking));
        $this->waarschuwing=htmlspecialchars(strip_tags($this->waarschuwing));
        $this->eenheidsprijs=htmlspecialchars(strip_tags($this->eenheidsprijs));

        // bind data
        $stmt->bindParam(":product_naam", $this->product_naam);
        $stmt->bindParam(":product_foto", $this->product_foto);
        $stmt->bindParam(":product_info", $this->product_info);
        $stmt->bindParam(":omschrijving", $this->omschrijving);
        $stmt->bindParam(":verpakking", $this->verpakking);
        $stmt->bindParam(":waarschuwing", $this->waarschuwing);
        $stmt->bindParam(":eenheidsprijs", $this->eenheidsprijs);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // UPDATE
    public function getSingleProduct(){
        $sqlQuery = "SELECT
                        product_id, 
                        product_naam, 
                        product_foto, 
                        product_info, 
                        omschrijving, 
                        verpakking,
                        waarschuwing,
                        eenheidsprijs
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       product_id = ?
                    LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->product_id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->product_naam = $dataRow['product_naam'];
        $this->product_foto = $dataRow['product_foto'];
        $this->product_info = $dataRow['product_info'];
        $this->omschrijving = $dataRow['omschrijving'];
        $this->verpakking = $dataRow['verpakking'];
        $this->waarschuwing = $dataRow['waarschuwing'];
        $this->eenheidsprijs = $dataRow['eenheidsprijs'];
    }

    // UPDATE
    public function updateProduct(){
        $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        product_naam = :product_naam, 
                        product_foto = :product_foto, 
                        product_info = :product_info, 
                        omschrijving = :omschrijving, 
                        verpakking = :verpakking,
                        waarschuwing = :waarschuwing,
                        eenheidsprijs = :eenheidsprijs
                    WHERE 
                        product_id = :product_id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->product_naam=htmlspecialchars(strip_tags($this->product_naam));
        $this->product_foto=htmlspecialchars(strip_tags($this->product_foto));
        $this->product_info=htmlspecialchars(strip_tags($this->product_info));
        $this->omschrijving=htmlspecialchars(strip_tags($this->omschrijving));
        $this->verpakking=htmlspecialchars(strip_tags($this->verpakking));
        $this->waarschuwing=htmlspecialchars(strip_tags($this->waarschuwing));
        $this->eenheidsprijs=htmlspecialchars(strip_tags($this->eenheidsprijs));

        // bind data
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":product_naam", $this->product_naam);
        $stmt->bindParam(":product_foto", $this->product_foto);
        $stmt->bindParam(":product_info", $this->product_info);
        $stmt->bindParam(":omschrijving", $this->omschrijving);
        $stmt->bindParam(":verpakking", $this->verpakking);
        $stmt->bindParam(":waarschuwing", $this->waarschuwing);
        $stmt->bindParam(":eenheidsprijs", $this->eenheidsprijs);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // DELETE
    function deleteProduct(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE product_id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id=htmlspecialchars(strip_tags($this->product_id));

        $stmt->bindParam(1, $this->product_id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

}
?>

