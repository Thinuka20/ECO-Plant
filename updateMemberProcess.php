<?php

include "connection.php";

$fname = $_POST["fn"];
$lname = $_POST["ln"];
$mob = $_POST["m"];
$add = $_POST["add"];
$st = $_POST["st"];
$pos = $_POST["p"];
$nic = $_POST["ni"];

if(empty($fname)){
    echo "Cannot Update with Empty First Name";
    
}else if(empty($lname)){
    echo "Cannot Update with Empty Last Name";


}else if(empty($add)){
    echo "Cannot Update with Empty Address";


}else  if(empty($mob)){
    echo "Cannot Update with Empty Mobile Number";


}else{
   $rs =  Database ::search("SELECT * FROM `team` WHERE `nic` = '".$nic."'");
    if($rs ->num_rows > 0){

        Database::iud("UPDATE `team` SET `f_name` = '".$fname."',`l_name` = '".$lname."', `mobile` = '".$mob."', `address` ='".$add."', `occupation_id` ='".$pos."', `member_status_id` ='".$st."' WHERE  `nic` ='".$nic."' ");
        echo "sucess";



    }else{
        echo "error 5";
    }


}







?>