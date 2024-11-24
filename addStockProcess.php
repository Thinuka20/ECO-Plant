<?php

include "connection.php";

$product = $_POST["p"];
$supplier = $_POST["s"];
$price = $_POST["pr"];
$qty = $_POST["q"];
$date = $_POST["d"];
$nproduct = $_POST["n"];



if($supplier == 00){
    echo "Select Supplier";

}else if(empty($price)){
    echo "enter Price";
}else if(empty($qty)){
    echo "Select Quantity";
}else if(empty($date)){
    echo "Select Date";
}else if($product == 00){
    if(empty($nproduct)){
        echo "enter new product name or select product";
    }else{
        $nrs = Database::search("SELECT * FROM `product` WHERE  `product_name`='".$nproduct."'");
        if($nrs->num_rows > 0){
            echo "New Product Name Already Exists";

        }else{
            Database::iud("INSERT INTO `product` (`price`,`qty`,`date`,`product_name`, `supplier_id`) VALUES ('".$price."','".$qty."','".$date."','".$nproduct."','".$supplier."')");
            echo "success";
        }
    }
}else{

    $rs = Database::search("SELECT * FROM `product` WHERE `product_id` = '".$product."'");
    if($rs->num_rows >0){
        $pdata = $rs->fetch_assoc();
        $productname = $pdata['product_name'];
        $haveqty = $pdata['qty'];
        $newqty = $haveqty + $qty;

        $haveprice = $pdata['price'];
        $newprice = $haveprice + $price;
        
        $qsup = $pdata["supplier_id"];
        if($supplier == $qsup){
            Database::iud("UPDATE `product` SET `price` ='".$newprice."', `qty` ='".$newqty."',`date` ='".$date."' WHERE `product_id` = '".$product."'");
            echo "success";

        }else{

            
            Database::iud("INSERT INTO `product` (`price`,`qty`,`date`,`product_name`, `supplier_id`) VALUES ('".$price."','".$qty."','".$date."','".$productname."','".$supplier."')");
            echo "success";


        }
        

    }else{
        echo "error";
    }



}

    












?>