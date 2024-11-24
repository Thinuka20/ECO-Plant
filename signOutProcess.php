<?php
session_start();

if(isset($_SESSION["user"]) || isset($_SESSION["user2"])){
    session_destroy();
    echo ("success");


}else{
    echo ("error ! Something wents wrong");
}











?>