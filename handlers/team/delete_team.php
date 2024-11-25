<?php
session_start();
include "connection.php";

$response = ['success' => false, 'message' => ''];

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Check for salary records
    $salaryCheck = Database::search("SELECT * FROM salary WHERE team_id = '$id'");
    
    if($salaryCheck->num_rows > 0) {
        $response['message'] = 'Cannot delete team member: Has salary records';
    } else {
        $query = Database::iud("DELETE FROM team WHERE team_id = '$id'");
        
        if($query) {
            $response['success'] = true;
            $response['message'] = 'Team member deleted successfully';
        } else {
            $response['message'] = 'Error deleting team member';
        }
    }
}

echo json_encode($response);
?>