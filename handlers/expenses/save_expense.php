<?php

session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['expense_type_id'])) {
    $type_id = $_POST['expense_type_id'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    
    if(isset($_POST['expenses_id']) && !empty($_POST['expenses_id'])) {
        // Update existing expense
        $id = $_POST['expenses_id'];
        $query = Database::iud("UPDATE expenses SET 
            expense_type_id = '$type_id',
            amount = '$amount',
            date = '$date'
            WHERE expenses_id = '$id'");
    } else {
        // Insert new expense
        $query = Database::iud("INSERT INTO expenses 
            (expense_type_id, amount, date) 
            VALUES 
            ('$type_id', '$amount', '$date')");
    }
    
    if($query) {
        $response['success'] = true;
        $response['message'] = 'Expense saved successfully';
    } else {
        $response['message'] = 'Error saving expense';
    }
}

echo json_encode($response);

?>