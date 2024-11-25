<?php

session_start();
include "connection.php";

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = Database::search("SELECT i.*, c.f_name, c.l_name, ps.sname as status_name 
        FROM invoice i 
        INNER JOIN customer c ON i.customer_id = c.customer_id 
        INNER JOIN payment_status ps ON i.payment_status_id = ps.ps_id 
        WHERE c.f_name LIKE '%$search%' 
        OR c.l_name LIKE '%$search%' 
        OR i.invoice_id LIKE '%$search%'
        ORDER BY i.i_date DESC");
    
    while($row = $query->fetch_assoc()) {
        $statusClass = ($row['payment_status_id'] == 1) ? 'success' : 'warning';
        
        echo "<tr>
            <td>{$row['invoice_id']}</td>
            <td>{$row['f_name']} {$row['l_name']}</td>
            <td>Rs.{$row['i_amount']}.00</td>
            <td>{$row['i_date']}</td>
            <td><span class='badge bg-{$statusClass}'>{$row['status_name']}</span></td>
            <td class='action-buttons'>
                <button class='btn btn-primary btn-sm' onclick='editInvoice({$row['invoice_id']})'>
                    <i class='fas fa-edit'></i>
                </button>
                <button class='btn btn-info btn-sm' onclick='viewInvoice({$row['invoice_id']})'>
                    <i class='fas fa-eye'></i>
                </button>
                <button class='btn btn-success btn-sm' onclick='printInvoice({$row['invoice_id']})'>
                    <i class='fas fa-print'></i>
                </button>
            </td>
        </tr>";
    }
}

?>