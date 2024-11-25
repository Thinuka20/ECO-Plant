<?php

session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['product_name'])) {
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $supplier_id = $_POST['supplier_id'];
    $date = date('Y-m-d');
    
    if(isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        // Update existing product
        $id = $_POST['product_id'];
        $query = Database::iud("UPDATE product SET 
            product_name = '$name',
            price = '$price',
            qty = '$qty',
            supplier_id = '$supplier_id',
            date = '$date'
            WHERE product_id = '$id'");
    } else {
        // Insert new product
        $query = Database::iud("INSERT INTO product 
            (product_name, price, qty, date, supplier_id) 
            VALUES 
            ('$name', '$price', '$qty', '$date', '$supplier_id')");
    }
    
    if($query) {
        $response['success'] = true;
        $response['message'] = 'Product saved successfully';
    } else {
        $response['message'] = 'Error saving product';
    }
}

echo json_encode($response);

?>