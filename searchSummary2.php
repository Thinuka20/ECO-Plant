<?php
require "connection.php";

if (isset($_POST["startDate"]) & isset($_POST["endDate"])) {

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $totalIncome = 0;
    $totalExpenses = 0;
    $totalProfit = 0;
    $totalWithdrawals = 0;
    $totalbalance = 0;

    $rs = Database::search("SELECT *, DATE_FORMAT(`date`, '%Y-%m') AS formatted_date FROM `summary` 
                                WHERE DATE_FORMAT(`date`, '%Y-%m') BETWEEN '$startDate' AND '$endDate' ORDER BY `date` ASC");


    $n = $rs->num_rows;

    if ($n > 0) {
        while ($d = $rs->fetch_assoc()) {
            $totalIncome = $totalIncome + $d["m_income"];
            $totalExpenses = $totalExpenses + $d['m_expenses'];
            $totalProfit = $totalProfit + $d['m_profit'];
            $totalWithdrawals = $totalWithdrawals + $d['withdrawals'];
            $totalbalance = $totalbalance + $d['balance'];
?>
            <tr>
                <th><?php echo $d["formatted_date"]; ?></th>
                <td><?php echo $d["m_income"]; ?></td>
                <td><?php echo $d['m_expenses']; ?></td>
                <td><?php echo $d['m_profit']; ?></td>
                <td><?php echo $d['withdrawals'] ?></td>
                <td><?php echo $d['balance'] ?></td>
            </tr>
    <?php
        }
    }
    ?>
    <tr>
        <th>Total</th>
        <td><?php echo $totalIncome; ?></td>
        <td><?php echo $totalExpenses; ?></td>
        <td><?php echo $totalProfit; ?></td>
        <td><?php echo $totalWithdrawals; ?></td>
        <td><?php echo $totalbalance; ?></td>
    </tr>


<?php
}
?>