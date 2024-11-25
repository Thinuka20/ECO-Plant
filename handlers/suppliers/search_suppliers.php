<?php

session_start();
include "connection.php";

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = Database::search("SELECT * FROM supplier 
        WHERE s_name LIKE '%$search%' 
        OR mobile LIKE '%$search%' 
        OR address LIKE '%$search%'
        ORDER BY supplier_id DESC");
    
    while($row = $query->fetch_assoc()) {
        // Calculate totals as before
        $products = Database::search("SELECT COUNT(*) as total FROM product WHERE supplier_id = '{$row['supplier_id']}'");
        $productsCount = $products->fetch_assoc()['total'];
        
        $totalDue = 0;
        $payments = Database::search("SELECT SUM(amount) as paid FROM supplier_payments WHERE supplier_id = '{$row['supplier_id']}'");
        $productCosts = Database::search("SELECT SUM(price * qty) as total FROM product WHERE supplier_id = '{$row['supplier_id']}'");
        
        $paid = $payments->fetch_assoc()['paid'] ?? 0;
        $total = $productCosts->fetch_assoc()['total'] ?? 0;
        $totalDue = $total - $paid;
        
        echo "<tr>
            <td>{$row['supplier_id']}</td>
            <td>{$row['s_name']}</td>
            <td>{$row['mobile']}</td>
            <td>{$row['address']}</td>
            <td>{$productsCount}</td>
            <td>Rs.{$totalDue}.00</td>
            <td class='action-buttons'>
                <button class='btn btn-primary btn-sm' onclick='editSupplier({$row['supplier_id']})'>
                    <i class='fas fa-edit'></i>
                </button>
                <button class='btn btn-danger btn-sm' onclick='deleteSupplier({$row['supplier_id']})'>
                    <i class='fas fa-trash'></i>
                </button>
                <button class='btn btn-info btn-sm' onclick='viewSupplierDetails({$row['supplier_id']})'>
                    <i class='fas fa-eye'></i>
                </button>
                <button class='btn btn-success btn-sm' onclick='addPayment({$row['supplier_id']})'>
                    <i class='fas fa-dollar-sign'></i>
                </button>
            </td>
        </tr>";
    }
}

?>