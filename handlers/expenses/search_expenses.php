<?php

session_start();
include "connection.php";

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = Database::search("SELECT e.*, et.name as type_name 
        FROM expenses e 
        INNER JOIN expense_type et ON e.expense_type_id = et.et_id 
        WHERE et.name LIKE '%$search%' 
        OR e.amount LIKE '%$search%'
        ORDER BY e.date DESC");
    
    while($row = $query->fetch_assoc()) {
        echo "<tr>
            <td>{$row['expenses_id']}</td>
            <td>{$row['type_name']}</td>
            <td>Rs.{$row['amount']}.00</td>
            <td>{$row['date']}</td>
            <td class='action-buttons'>
                <button class='btn btn-primary btn-sm' onclick='editExpense({$row['expenses_id']})'>
                    <i class='fas fa-edit'></i>
                </button>
                <button class='btn btn-danger btn-sm' onclick='deleteExpense({$row['expenses_id']})'>
                    <i class='fas fa-trash'></i>
                </button>
            </td>
        </tr>";
    }
}

?>