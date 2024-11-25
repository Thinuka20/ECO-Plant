<?php
session_start();
include "connection.php";

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = Database::search("SELECT t.*, o.oname, ms.tsname 
        FROM team t 
        INNER JOIN occupation o ON t.occupation_id = o.o_id 
        INNER JOIN member_status ms ON t.member_status_id = ms.ms_id 
        WHERE t.f_name LIKE '%$search%' 
        OR t.l_name LIKE '%$search%'
        OR t.mobile LIKE '%$search%'
        OR t.nic LIKE '%$search%'
        OR o.oname LIKE '%$search%'
        ORDER BY t.team_id DESC");
    
    while($row = $query->fetch_assoc()) {
        $statusClass = ($row['member_status_id'] == 1) ? 'success' : 'warning';
        
        echo "<tr>
            <td>{$row['team_id']}</td>
            <td>{$row['f_name']} {$row['l_name']}</td>
            <td>{$row['mobile']}</td>
            <td>{$row['nic']}</td>
            <td>{$row['address']}</td>
            <td>{$row['oname']}</td>
            <td><span class='badge bg-{$statusClass}'>{$row['tsname']}</span></td>
            <td class='action-buttons'>
                <button class='btn btn-primary btn-sm' onclick='editTeam({$row['team_id']})'>
                    <i class='fas fa-edit'></i>
                </button>
                <button class='btn btn-danger btn-sm' onclick='deleteTeam({$row['team_id']})'>
                    <i class='fas fa-trash'></i>
                </button>
                <button class='btn btn-info btn-sm' onclick='viewTeamDetails({$row['team_id']})'>
                    <i class='fas fa-eye'></i>
                </button>
            </td>
        </tr>";
    }
}
?>