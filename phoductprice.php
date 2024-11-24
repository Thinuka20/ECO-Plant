<?php

require "connection.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $trs = Database::search("SELECT * FROM `product` WHERE `product_id` = '$id'");
    $tn = $trs->num_rows;

    $td = $trs->fetch_assoc();

    $unitprice = $td['unit_price'];

    echo $unitprice;
}
