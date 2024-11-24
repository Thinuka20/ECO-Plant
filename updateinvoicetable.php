<?php

require "connection.php";

if (isset($_GET["id"]) & isset($_GET['discount']) & isset($_GET['total'])) {

    $id = $_GET["id"];
    $discount = $_GET["discount"];
    $total = $_GET["total"];

    Database::iud("UPDATE `invoice` SET `i_amount`='" . $total . "',`discount`='" . $discount . "' WHERE `invoice_id` = '" . $id . "'");

}

?>