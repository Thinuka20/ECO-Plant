<?php
session_start();
include "connection.php";

$uname = $_POST["un"];
$pw = $_POST["p"];

$data_q = Database::search("SELECT * FROM `users` WHERE `username` = '".$uname."' AND `password` = '".$pw."'");

$nums = $data_q->num_rows;
if($nums == 1){
    
    $data = $data_q->fetch_assoc();
    setcookie("username",$uname,time()+(60*60*24*365));
    if($data["user_status_id"] =="1"){
        echo("admin");
        $_SESSION["user"]=$data;
    }else{
        echo("user");
        $_SESSION["user2"]=$data;
    }
}else{
    echo("wrong username or password");
}
?>