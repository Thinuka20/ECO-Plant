<?php

session_start();
include "connection.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Get customer details
    $customer = Database::search("SELECT * FROM customer WHERE customer_id='$id'")->fetch_assoc();
    
    // Get customer payments
    $payments = Database::search("SELECT * FROM customer_payments WHERE customer_id='$id' ORDER BY date DESC");
    
    // Get customer invoices
    $invoices = Database::search("SELECT * FROM invoice WHERE customer_id='$id' ORDER BY i_date DESC");
    
    echo "<div class='row'>
            <div class='col-md-6'>
                <h5>Customer Information</h5>
                <table class='table'>
                    <tr>
                        <th>Name</th>
                        <td>{$customer['f_name']} {$customer['l_name']}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{$customer['mobile']}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{$customer['address']}</td>
                    </tr>
                    <tr>
                        <th>NIC</th>
                        <td>{$customer['nic']}</td>
                    </tr>
                    <tr>
                        <th>System Capacity</th>
                        <td>{$customer['system_capacity']}</td>
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
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tbody>";
    
    while($payment = $payments->fetch_assoc()) {
        echo "<tr>
                <td>{$payment['date']}</td>
                <td>Rs.{$payment['amount']}.00</td>
                <td>{$payment['payment_methord']}</td>
            </tr>";
    }
    
    echo "</tbody>
        </table>
    </div>
    <div class='col-12 mt-4'>
        <h5>Invoice History</h5>
        <table class='table'>
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";
    
    while($invoice = $invoices->fetch_assoc()) {
        $status = ($invoice['payment_status_id'] == 1) ? 'Paid' : 'Pending';
        $statusClass = ($invoice['payment_status_id'] == 1) ? 'success' : 'warning';
        
        echo "<tr>
                <td>{$invoice['invoice_id']}</td>
                <td>{$invoice['i_date']}</td>
                <td>Rs.{$invoice['i_amount']}.00</td>
                <td>Rs.{$invoice['discount']}.00</td>
                <td>Rs.{$invoice['sub_total']}.00</td>
                <td><span class='badge bg-{$statusClass}'>{$status}</span></td>
            </tr>";
    }
    
    echo "</tbody>
        </table>
    </div>
</div>";
}

?>