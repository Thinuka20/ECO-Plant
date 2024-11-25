<?php
session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Check if the product has any dependencies before deleting
    // You might want to check invoices or other related tables
    // For now, we'll do a direct delete since the schema doesn't show direct dependencies
    
    $query = Database::iud("DELETE FROM product WHERE product_id = '$id'");
    
    if($query) {
        // Update supplier's total products and costs
        $supplier_id = $_POST['supplier_id'] ?? null;
        if($supplier_id) {
            // You might want to update supplier related calculations here
        }
        
        $response['success'] = true;
        $response['message'] = 'Product deleted successfully';
    } else {
        $response['message'] = 'Error deleting product';
    }
}

echo json_encode($response);
?>