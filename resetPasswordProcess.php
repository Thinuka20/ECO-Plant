<?php

require "connection.php";

$username = $_POST["username"];
$np = $_POST["fp"];
$rnp = $_POST["fp2"];
$vc = $_POST["vc"];

if(empty($username)){
    echo("Please Enter Your Username");
}else if(empty($np)){
    echo("Please Enter Your Password");
}else if(strlen($np) < 5 || strlen($np) > 20){
    echo("Your Password Must Between 5-20 characters");
}else if(empty($rnp)){
    echo("Please Re-Enter Your Password");
}else if($np != $rnp){
    echo("Password does not match");
}else{
    $rs = Database::search("SELECT * FROM `users` WHERE `username`='".$username."' AND `v_code`='".$vc."'");
    $n = $rs -> num_rows;

    if ($n==1) {
        Database::iud("UPDATE `users` SET `password`='".$np."' WHERE `username`='".$username."' AND `v_code`='".$vc."'");
        echo("success");
    } else {
        echo("Invalid User Details");
    }
    

}

?>