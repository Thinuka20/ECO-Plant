<?php
session_start();
include "connection.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $query = Database::search("SELECT t.*, o.oname, ms.tsname 
        FROM team t 
        INNER JOIN occupation o ON t.occupation_id = o.o_id 
        INNER JOIN member_status ms ON t.member_status_id = ms.ms_id 
        WHERE t.team_id = '$id'");
    
    $member = $query->fetch_assoc();
    
    // Get additional info like salary history
    $salaryQuery = Database::search("SELECT SUM(amount) as total_salary FROM salary WHERE team_id = '$id'");
    $totalSalary = $salaryQuery->fetch_assoc()['total_salary'] ?? 0;
    
    $member['total_salary'] = $totalSalary;
    
    echo json_encode($member);
}
?>