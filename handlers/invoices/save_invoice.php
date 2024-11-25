<?php

session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['customer_id'])) {
    $customer_id = $_POST['customer_id'];
    $payment_status_id = $_POST['payment_status_id'];
    $amount = $_POST['i_amount'];
    $discount = $_POST['discount'];
    $sub_total = $_POST['sub_total'];
    $date = $_POST['i_date'];
    
    if(isset($_POST['invoice_id']) && !empty($_POST['invoice_id'])) {
        // Update existing invoice
        $id = $_POST['invoice_id'];
        $query = Database::iud("UPDATE invoice SET 
            customer_id = '$customer_id',
            payment_status_id = '$payment_status_id',
            i_amount = '$amount',
            discount = '$discount',
            sub_total = '$sub_total',
            i_date = '$date'
            WHERE invoice_id = '$id'");
    } else {
        // Insert new invoice
        $query = Database::iud("INSERT INTO invoice 
            (customer_id, payment_status_id, i_amount, i_date, discount, sub_total) 
            VALUES 
            ('$customer_id', '$payment_status_id', '$amount', '$date', '$discount', '$sub_total')");
    }
    
    if($query) {
        $response['success'] = true;
        $response['message'] = 'Invoice saved successfully';
    } else {
        $response['message'] = 'Error saving invoice';
    }
}

echo json_encode($response);

?>