<?php

include "connection.php";

$fname = $_POST["fn"];
$lname = $_POST["ln"];
$addres = $_POST["ad"];
$mobile = $_POST["mo"];
$position = $_POST["po"];
$nic = $_POST["ni"];
$status = $_POST["st"];

if(empty($fname)){
    echo "enter First Name";
}else if(empty($lname)){
    echo "enter Last Name";

}else if(empty($addres)){
    echo "enter  Address";

}else if(empty($mobile)){
    echo "enter Mobile";

}else if($position == 00){
    echo "Select Postion";

}else if(empty($nic)){
    echo "enter NIc";

}else{

    $rs = Database ::search("SELECT * FROM `team` WHERE `nic` = '".$nic."'");
    if($rs->num_rows > 0){
        echo "Already Have this NIC Before";
    }else{
        Database::iud("INSERT INTO `team` (`f_name`,`l_name`,`mobile`,`nic`,`address`,`occupation_id`,`member_status_id`) VALUES('".$fname."','".$lname."','".$mobile."','".$nic."','".$addres."','".$position."','".$status."')");
        echo "success";
    }


}










?>