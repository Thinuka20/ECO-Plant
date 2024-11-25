<?php

session_start();
include "connection.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Get supplier details
    $supplier = Database::search("SELECT * FROM supplier WHERE supplier_id='$id'")->fetch_assoc();
    
    // Get products
    $products = Database::search("SELECT * FROM product WHERE supplier_id='$id' ORDER BY date DESC");
    
    // Get payments
    $payments = Database::search("SELECT * FROM supplier_payments WHERE supplier_id='$id' ORDER BY date DESC");
    
    echo "<div class='row'>
            <div class='col-md-6'>
                <h5>Supplier Information</h5>
                <table class='table'>
                    <tr>
                        <th>Name</th>
                        <td>{$supplier['s_name']}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{$supplier['mobile']}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{$supplier['address']}</td>
                    </tr>
                </table>
            </div>
            <div class='col-md-6'>
                <h5>Payment History</h5>
                <table class='table'>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>";
    
    while($payment = $payments->fetch_assoc()) {
        echo "<tr>
                <td>{$payment['date']}</td>
                <td>Rs.{$payment['amount']}.00</td>
            </tr>";
    }
    
    echo "</tbody>
        </table>
    </div>
    <div class='col-12 mt-4'>
        <h5>Product History</h5>
        <table class='table'>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>";
    
    while($product = $products->fetch_assoc()) {
        $total = $product['price'] * $product['qty'];
        echo "<tr>
                <td>{$product['product_name']}</td>
                <td>Rs.{$product['price']}.00</td>
                <td>{$product['qty']}</td>
                <td>{$product['date']}</td>
                <td>Rs.{$total}.00</td>
            </tr>";
    }
    
    echo "</tbody>
        </table>
    </div>
</div>";
}

?>