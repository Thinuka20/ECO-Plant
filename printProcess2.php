<?php
include "connection.php";
// Assuming the above database connection is established and $pdo is your PDO instance


    $rows = $_POST["rows"];
    

    for ($i = 1; $i <= $rows-1; $i++) {
        $product_id = $_POST["p$i"];
        $rs = Database::search("SELECT * FROM `product` WHERE `product_id` = '".$product_id."'");
        if (isset($_POST["q$i"])) {
            // Assuming product_id directly relates to $i
            $data = $rs->fetch_assoc();
            $oldStock = $data["qty"];
        
            $quantity = $_POST["q$i"];

            $newStock = $oldStock - $quantity;

            // Prepare the UPDATE statement to update the stock quantity for the given product ID
            Database::iud("UPDATE `product` SET `qty` = '".$newStock."' WHERE `product_id` = '".$product_id."'");
            
            
        }
    }

    echo "Stock Updated Successfully.";

?>