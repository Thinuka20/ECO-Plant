<?php
session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['f_name'])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $mobile = $_POST['mobile'];
    $nic = $_POST['nic'];
    $address = $_POST['address'];
    $occupation_id = $_POST['occupation_id'];
    $member_status_id = $_POST['member_status_id'];
    
    // Validate NIC format if needed
    if (!preg_match("/^[0-9]{9}[vVxX]$/", $nic) && !preg_match("/^[0-9]{12}$/", $nic)) {
        $response['message'] = 'Invalid NIC format';
        echo json_encode($response);
        exit();
    }
    
    // Validate mobile number
    if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $response['message'] = 'Invalid mobile number format';
        echo json_encode($response);
        exit();
    }
    
    if(isset($_POST['team_id']) && !empty($_POST['team_id'])) {
        // Update existing team member
        $team_id = $_POST['team_id'];
        $query = Database::iud("UPDATE team SET 
            f_name = '$f_name',
            l_name = '$l_name',
            mobile = '$mobile',
            nic = '$nic',
            address = '$address',
            occupation_id = '$occupation_id',
            member_status_id = '$member_status_id'
            WHERE team_id = '$team_id'");
    } else {
        // Check if NIC already exists
        $nicCheck = Database::search("SELECT * FROM team WHERE nic = '$nic'");
        if($nicCheck->num_rows > 0) {
            $response['message'] = 'NIC already exists';
            echo json_encode($response);
            exit();
        }
        
        // Insert new team member
        $query = Database::iud("INSERT INTO team 
            (f_name, l_name, mobile, nic, address, occupation_id, member_status_id) 
            VALUES 
            ('$f_name', '$l_name', '$mobile', '$nic', '$address', '$occupation_id', '$member_status_id')");
    }
    
    if($query) {
        $response['success'] = true;
        $response['message'] = 'Team member saved successfully';
    } else {
        $response['message'] = 'Error saving team member';
    }
}

echo json_encode($response);
?>