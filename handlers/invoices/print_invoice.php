<?php

session_start();
include "connection.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get invoice with related information
    $query = Database::search("SELECT i.*, 
        c.f_name, c.l_name, c.mobile, c.address,
        ps.sname as status_name
        FROM invoice i 
        INNER JOIN customer c ON i.customer_id = c.customer_id 
        INNER JOIN payment_status ps ON i.payment_status_id = ps.ps_id 
        WHERE i.invoice_id='$id'");
    
    $invoice = $query->fetch_assoc();
    
    // Get customer payments
    $payments = Database::search("SELECT * FROM customer_payments 
        WHERE customer_id='{$invoice['customer_id']}' 
        ORDER BY date DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?php echo $id; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
            @page {
                margin: 0;
            }
            body {
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <button onclick="window.print()" class="btn btn-primary mb-3 no-print">
            <i class="fas fa-print"></i> Print Invoice
        </button>
        
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-6">
                        <h4>Invoice #<?php echo $invoice['invoice_id']; ?></h4>
                        <p>Date: <?php echo $invoice['i_date']; ?></p>
                    </div>
                    <div class="col-6 text-end">
                        <img src="resourses/lo.ico" alt="Logo" style="height: 50px;">
                        <h5>Eco Plant & Energy (Pvt) Ltd</h5>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-6">
                        <h5>Bill To:</h5>
                        <p>
                            <?php echo $invoice['f_name'] . ' ' . $invoice['l_name']; ?><br>
                            <?php echo $invoice['address']; ?><br>
                            Tel: <?php echo $invoice['mobile']; ?>
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <h5>Payment Status:</h5>
                        <span class="badge bg-<?php echo ($invoice['payment_status_id'] == 1 ? 'success' : 'warning'); ?> fs-6">
                            <?php echo $invoice['status_name']; ?>
                        </span>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <tr>
                                <th>Description</th>
                                <th class="text-end">Amount</th>
                            </tr>
                            <tr>
                                <td>System Installation</td>
                                <td class="text-end">Rs.<?php echo $invoice['i_amount']; ?>.00</td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td class="text-end">Rs.<?php echo $invoice['discount']; ?>.00</td>
                            </tr>
                            <tr class="table-active">
                                <th>Total Amount</th>
                                <th class="text-end">Rs.<?php echo $invoice['sub_total']; ?>.00</th>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <h5>Payment History</h5>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
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
                            ?>
                            </tbody>
                        </table>
                        
                        <div class="row mt-3">
                            <div class="col-6">
                                <p><strong>Total Paid:</strong> Rs.<?php echo $total_paid; ?>.00</p>
                                <p><strong>Balance:</strong> Rs.<?php echo $balance; ?>.00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-6">
                        <hr style="width: 200px;">
                        <p class="text-center">Customer Signature</p>
                    </div>
                    <div class="col-6 text-end">
                        <hr style="width: 200px; margin-left: auto;">
                        <p class="text-center">Authorized Signature</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}

?>