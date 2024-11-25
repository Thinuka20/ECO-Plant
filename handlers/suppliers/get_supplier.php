<?php
session_start();
include "connection.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Get basic supplier info
    $query = Database::search("SELECT * FROM supplier WHERE supplier_id = '$id'");
    $supplier = $query->fetch_assoc();
    
    // Get additional info if needed
    $productsQuery = Database::search("SELECT COUNT(*) as product_count FROM product WHERE supplier_id = '$id'");
    $productCount = $productsQuery->fetch_assoc()['product_count'];
    
    $paymentsQuery = Database::search("SELECT SUM(amount) as total_paid FROM supplier_payments WHERE supplier_id = '$id'");
    $totalPaid = $paymentsQuery->fetch_assoc()['total_paid'] ?? 0;
    
    $productCostsQuery = Database::search("SELECT SUM(price * qty) as total_cost FROM product WHERE supplier_id = '$id'");
    $totalCost = $productCostsQuery->fetch_assoc()['total_cost'] ?? 0;
    
    // Add additional info to supplier array
    $supplier['product_count'] = $productCount;
    $supplier['total_paid'] = $totalPaid;
    $supplier['total_cost'] = $totalCost;
    $supplier['balance'] = $totalCost - $totalPaid;
    
    echo json_encode($supplier);
}
?>