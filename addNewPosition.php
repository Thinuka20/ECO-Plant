<?php

include "connection.php";

$newP = $_POST["np"];

if(empty($newP)){
  echo ("enter Position");

}else{
    $rs = Database::search("SELECT * FROM `occupation` WHERE `oname` ='".$newP."'");
if($rs->num_rows > 0){
    echo "Already in Table";
}else{
    Database::iud("INSERT INTO `occupation`(`oname`) VALUES ('".$newP."') ");
    echo "success";
}



}









?>