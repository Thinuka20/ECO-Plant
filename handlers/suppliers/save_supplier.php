<?php

session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['s_name'])) {
    $name = $_POST['s_name'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    
    if(isset($_POST['supplier_id']) && !empty($_POST['supplier_id'])) {
        // Update existing supplier
        $id = $_POST['supplier_id'];
        $query = Database::iud("UPDATE supplier SET 
            s_name = '$name',
            mobile = '$mobile',
            address = '$address'
            WHERE supplier_id = '$id'");
    } else {
        // Insert new supplier
        $query = Database::iud("INSERT INTO supplier 
            (s_name, mobile, address) 
            VALUES 
            ('$name', '$mobile', '$address')");
    }
    
    if($query) {
        $response['success'] = true;
        $response['message'] = 'Supplier saved successfully';
    } else {
        $response['message'] = 'Error saving supplier';
    }
}

echo json_encode($response);

?>