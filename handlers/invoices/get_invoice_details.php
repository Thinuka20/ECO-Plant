<?php

session_start();
include "connection.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Get invoice with related information
    $query = Database::search("SELECT i.*, 
        c.f_name, c.l_name, c.mobile, c.address,
        ps.sname as status_name
        FROM invoice i 
        INNER JOIN customer c ON i.customer_id = c.customer_id 
        INNER JOIN payment_status ps ON i.payment_status_id = ps.ps_id 
        WHERE i.invoice_id='$id'");
    
    $invoice = $query->fetch_assoc();
    
    // Get customer payments for this invoice
    $payments = Database::search("SELECT * FROM customer_payments 
        WHERE customer_id='{$invoice['customer_id']}' 
        ORDER BY date DESC");
    
    // Generate invoice view
    echo "<div class='container'>
            <div class='row mb-4'>
                <div class='col-6'>
                    <h4>Invoice #{$invoice['invoice_id']}</h4>
                    <p>Date: {$invoice['i_date']}</p>
                </div>
                <div class='col-6 text-end'>
                    <img src='resourses/lo.ico' alt='Logo' style='height: 50px;'>
                    <h5>Eco Plant & Energy (Pvt) Ltd</h5>
                </div>
            </div>
            
            <div class='row mb-4'>
                <div class='col-6'>
                    <h5>Bill To:</h5>
                    <p>
                        {$invoice['f_name']} {$invoice['l_name']}<br>
                        {$invoice['address']}<br>
                        Tel: {$invoice['mobile']}
                    </p>
                </div>
                <div class='col-6 text-end'>
                    <h5>Payment Status:</h5>
                    <span class='badge bg-" . ($invoice['payment_status_id'] == 1 ? 'success' : 'warning') . " fs-6'>
                        {$invoice['status_name']}
                    </span>
                </div>
            </div>
            
            <div class='row mb-4'>
                <div class='col-12'>
                    <table class='table table-bordered'>
                        <tr>
                            <th>Description</th>
                            <th class='text-end'>Amount</th>
                        </tr>
                        <tr>
                            <td>System Installation</td>
                            <td class='text-end'>Rs.{$invoice['i_amount']}.00</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td class='text-end'>Rs.{$invoice['discount']}.00</td>
                        </tr>
                        <tr class='table-active'>
                            <th>Total Amount</th>
                            <th class='text-end'>Rs.{$invoice['sub_total']}.00</th>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class='row'>
                <div class='col-12'>
                    <h5>Payment History</h5>
                    <table class='table table-sm'>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                            </tr>
                        </thead>
                        <tbody>";
    
    $total_paid = 0;
    while($payment = $payments->fetch_assoc()) {
        $total_paid += $payment['amount'];
        echo "<tr>
                <td>{$payment['date']}</td>
                <td>Rs.{$payment['amount']}.00</td>
                <td>Payment Method {$payment['payment_methord']}</td>
            </tr>";
    }
    
    $balance = $invoice['sub_total'] - $total_paid;
    
    echo "</tbody>
        </table>
        <div class='row mt-3'>
            <div class='col-6'>
                <p><strong>Total Paid:</strong> Rs.{$total_paid}.00</p>
                <p><strong>Balance:</strong> Rs.{$balance}.00</p>
            </div>
        </div>
    </div>
</div>";
}

?>