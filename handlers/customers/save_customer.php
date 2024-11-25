<?php

session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['f_name'])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $nic = $_POST['nic'];
    $system_capacity = $_POST['system_capacity'];
    $date = date('Y-m-d H:i:s');
    
    if(isset($_POST['customer_id']) && !empty($_POST['customer_id'])) {
        // Update existing customer
        $customer_id = $_POST['customer_id'];
        $query = Database::iud("UPDATE customer SET 
            f_name = '$f_name',
            l_name = '$l_name',
            mobile = '$mobile',
            address = '$address',
            nic = '$nic',
            system_capacity = '$system_capacity'
            WHERE customer_id = '$customer_id'");
    } else {
        // Insert new customer
        $query = Database::iud("INSERT INTO customer 
            (f_name, l_name, mobile, address, date, team_id, nic, system_capacity) 
            VALUES 
            ('$f_name', '$l_name', '$mobile', '$address', '$date', '0', '$nic', '$system_capacity')");
    }
    
    if($query) {
        $response['success'] = true;
        $response['message'] = 'Customer saved successfully';
    } else {
        $response['message'] = 'Error saving customer';
    }
}

echo json_encode($response);

?>