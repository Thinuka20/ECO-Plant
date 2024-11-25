<?php

session_start();
include "connection.php";

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = Database::search("SELECT p.*, s.s_name FROM product p 
        LEFT JOIN supplier s ON p.supplier_id = s.supplier_id 
        WHERE p.product_name LIKE '%$search%' 
        OR s.s_name LIKE '%$search%'
        ORDER BY p.product_id DESC");
    
    while($row = $query->fetch_assoc()) {
        echo "<tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_name']}</td>
            <td>Rs.{$row['price']}.00</td>
            <td>{$row['qty']}</td>
            <td>{$row['date']}</td>
            <td>{$row['s_name']}</td>
            <td class='action-buttons'>
                <button class='btn btn-primary btn-sm' onclick='editProduct({$row['product_id']})'>
                    <i class='fas fa-edit'></i>
                </button>
                <button class='btn btn-danger btn-sm' onclick='deleteProduct({$row['product_id']})'>
                    <i class='fas fa-trash'></i>
                </button>
                <button class='btn btn-warning btn-sm' onclick='updateStock({$row['product_id']})'>
                    <i class='fas fa-boxes'></i>
                </button>
            </td>
        </tr>";
    }
}

?>