<?php
include "connection.php";

$sname = $_POST["sn"];
$smobile = $_POST["sm"];
$saddress = $_POST["sad"];

if(empty($sname)){
    echo "Please Enter Supplier Name ";

}else if(empty($smobile)){
    echo "Please Enter mobile number ";

}else if (empty($saddress)){
    echo "Please Enter Supplier Address ";
}else{
    $srs = Database::search("SELECT * FROM `supplier` WHERE `mobile` = '".$smobile."'");
    if($srs->num_rows > 0){
        echo "Already exists this Supplier or Mobile Number";
        

    }else{
        

        Database::iud("INSERT INTO `supplier` (`s_name`, `mobile`,`address`) VALUES ('".$sname."','".$smobile."','".$saddress."')");
        echo "success";



    }
}
















?>