<?php
$menuadmin = 3;
include 'main.php';
$connection = pdo_connect_mysql();

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
    //For Load All Data
    if($_POST["action"] == "Load")
    {
        $statement = $connection->prepare("SELECT * FROM product_opties ORDER BY optie_id DESC");
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
   <table class="table table-bordered">
    <tr>
     <th width="40%">First Name</th>
     <th width="40%">Last Name</th>
     <th width="10%">Update</th>
     <th width="10%">Delete</th>
    </tr>
  ';
        if($statement->rowCount() > 0)
        {
            foreach($result as $row)
            {
                $output .= '
    <tr>
     <td>'.$row["optie_titel"].'</td>
     <td>'.$row["optie_naam"].'</td>
     <td><button type="button" id="'.$row["optie_id"].'" class="btn btn-warning btn-xs update">Update</button></td>
     <td><button type="button" id="'.$row["optie_id"].'" class="btn btn-danger btn-xs delete">Delete</button></td>
    </tr>
    ';
            }
        }
        else
        {
            $output .= '
    <tr>
     <td align="center">Data not Found</td>
    </tr>
   ';
        }
        $output .= '</table>';
        echo $output;
    }

    //This code for Create new Records
    if($_POST["action"] == "Create")
    {
        $statement = $connection->prepare("
   INSERT INTO product_opties (first_name, last_name) 
   VALUES (:first_name, :last_name)
  ");
        $result = $statement->execute(
            array(
                ':first_name' => $_POST["firstName"],
                ':last_name' => $_POST["lastName"]
            )
        );
        if(!empty($result))
        {
            echo 'Data Inserted';
        }
    }

    //This Code is for fetch single customer data for display on Modal
    if($_POST["action"] == "Select")
    {
        $output = array();
        $statement = $connection->prepare(
            "SELECT * FROM customers 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
            $output["first_name"] = $row["first_name"];
            $output["last_name"] = $row["last_name"];
        }
        echo json_encode($output);
    }

    if($_POST["action"] == "Update")
    {
        $statement = $connection->prepare(
            "UPDATE customers 
   SET first_name = :first_name, last_name = :last_name 
   WHERE id = :id
   "
        );
        $result = $statement->execute(
            array(
                ':first_name' => $_POST["firstName"],
                ':last_name' => $_POST["lastName"],
                ':id'   => $_POST["id"]
            )
        );
        if(!empty($result))
        {
            echo 'Data Updated';
        }
    }

    if($_POST["action"] == "Delete")
    {
        $statement = $connection->prepare(
            "DELETE FROM product_opties WHERE optie_id = :optie_id"
        );
        $result = $statement->execute(
            array(
                ':optie_id' => $_POST["optie_id"]
            )
        );
        if(!empty($result))
        {
            echo 'Data Deleted';
        }
    }

}

?>
 