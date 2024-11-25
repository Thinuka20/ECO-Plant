<?php
session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // First check if supplier has any products
    $productCheck = Database::search("SELECT * FROM product WHERE supplier_id = '$id'");
    $paymentCheck = Database::search("SELECT * FROM supplier_payments WHERE supplier_id = '$id'");
    
    if($productCheck->num_rows > 0) {
        $response['message'] = 'Cannot delete supplier: Has associated products. Please delete products first.';
    } else if($paymentCheck->num_rows > 0) {
        $response['message'] = 'Cannot delete supplier: Has associated payments. Please delete payments first.';
    } else {
        // If no related records, proceed with deletion
        $query = Database::iud("DELETE FROM supplier WHERE supplier_id = '$id'");
        
        if($query) {
            $response['success'] = true;
            $response['message'] = 'Supplier deleted successfully';
        } else {
            $response['message'] = 'Error deleting supplier';
        }
    }
}

echo json_encode($response);
?>