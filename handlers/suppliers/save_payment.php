<?php

session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['supplier_id']) && isset($_POST['amount'])) {
    $supplier_id = $_POST['supplier_id'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    
    $query = Database::iud("INSERT INTO supplier_payments (supplier_id, amount, date) 
        VALUES ('$supplier_id', '$amount', '$date')");
    
    if($query) {
        $response['success'] = true;
        $response['message'] = 'Payment saved successfully';
    } else {
        $response['message'] = 'Error saving payment';
    }
}

echo json_encode($response);

?>