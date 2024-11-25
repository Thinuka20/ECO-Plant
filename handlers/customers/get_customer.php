<?php

session_start();
include "connection.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = Database::search("SELECT * FROM customer WHERE customer_id='$id'");
    $customer = $query->fetch_assoc();
    echo json_encode($customer);
}

?>