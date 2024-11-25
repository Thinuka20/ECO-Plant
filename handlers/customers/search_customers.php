<?php 
session_start();
include "connection.php";

if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = Database::search("SELECT * FROM customer WHERE 
        f_name LIKE '%$search%' OR 
        l_name LIKE '%$search%' OR 
        mobile LIKE '%$search%' OR 
        address LIKE '%$search%' OR 
        nic LIKE '%$search%'
        ORDER BY customer_id DESC");
    
    while($row = $query->fetch_assoc()) {
        echo "<tr>
            <td>{$row['customer_id']}</td>
            <td>{$row['f_name']} {$row['l_name']}</td>
            <td>{$row['mobile']}</td>
            <td>{$row['address']}</td>
            <td>{$row['system_capacity']}</td>
            <td class='action-buttons'>
                <button class='btn btn-primary btn-sm' onclick='editCustomer({$row['customer_id']})'>
                    <i class='fas fa-edit'></i>
                </button>
                <button class='btn btn-danger btn-sm' onclick='deleteCustomer({$row['customer_id']})'>
                    <i class='fas fa-trash'></i>
                </button>
                <button class='btn btn-info btn-sm' onclick='viewCustomerDetails({$row['customer_id']})'>
                    <i class='fas fa-eye'></i>
                </button>
            </td>
        </tr>";
    }
}

?>

