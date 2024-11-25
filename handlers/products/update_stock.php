<?php

session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['id']) && isset($_POST['qty'])) {
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    
    $query = Database::iud("UPDATE product SET qty = '$qty' WHERE product_id = '$id'");
    
    if($query) {
        $response['success'] = true;
        $response['message'] = 'Stock updated successfully';
    } else {
        $response['message'] = 'Error updating stock';
    }
}

echo json_encode($response);

?>