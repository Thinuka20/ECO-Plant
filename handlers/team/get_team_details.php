<?php
session_start();
include "connection.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Get team member details
    $member = Database::search("SELECT t.*, o.oname, ms.tsname 
        FROM team t 
        INNER JOIN occupation o ON t.occupation_id = o.o_id 
        INNER JOIN member_status ms ON t.member_status_id = ms.ms_id 
        WHERE t.team_id = '$id'")->fetch_assoc();
    
    // Get salary history
    $salaries = Database::search("SELECT * FROM salary WHERE team_id = '$id' ORDER BY date DESC");
    
    echo "<div class='row'>
            <div class='col-md-6'>
                <h5>Team Member Information</h5>
                <table class='table'>
                    <tr>
                        <th>Name</th>
                        <td>{$member['f_name']} {$member['l_name']}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{$member['mobile']}</td>
                    </tr>
                    <tr>
                        <th>NIC</th>
                        <td>{$member['nic']}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{$member['address']}</td>
                    </tr>
                    <tr>
                        <th>Occupation</th>
                        <td>{$member['oname']}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class='badge bg-" . ($member['member_status_id'] == 1 ? 'success' : 'warning') . "'>
                                {$member['tsname']}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class='col-md-6'>
                <h5>Salary History</h5>
                <table class='table'>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>";
    
    $totalSalary = 0;
    while($salary = $salaries->fetch_assoc()) {
        $totalSalary += $salary['amount'];
        echo "<tr>
                <td>{$salary['date']}</td>
                <td>Rs.{$salary['amount']}.00</td>
            </tr>";
    }
    
    echo "</tbody>
        </table>
        <div class='alert alert-info'>
            <strong>Total Salary Paid:</strong> Rs.{$totalSalary}.00
        </div>
    </div>
</div>";
}
?>