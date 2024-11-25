<?php

session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = Database::iud("DELETE FROM expenses WHERE expenses_id='$id'");
    
    if($query) {
        $response['success'] = true;
        $response['message'] = 'Expense deleted successfully';
    } else {
        $response['message'] = 'Error deleting expense';
    }
}

echo json_encode($response);

?>