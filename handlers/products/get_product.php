<?php

session_start();
include "connection.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = Database::search("SELECT * FROM product WHERE product_id='$id'");
    echo json_encode($query->fetch_assoc());
}

?>