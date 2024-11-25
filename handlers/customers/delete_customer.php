<?php

session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Check for related records first
    $check = Database::search("SELECT * FROM invoice WHERE customer_id='$id'");
    if($check->num_rows > 0) {
        $response['message'] = 'Cannot delete customer: Has related invoices';
    } else {
        $query = Database::iud("DELETE FROM customer WHERE customer_id='$id'");
        if($query) {
            $response['success'] = true;
            $response['message'] = 'Customer deleted successfully';
        } else {
            $response['message'] = 'Error deleting customer';
        }
    }
}

echo json_encode($response);

?>