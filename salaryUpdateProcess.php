<?php

include "connection.php";

if (isset($_POST['amount']) && isset($_POST['nic'])) {
    $amount = $_POST["amount"];
    $nic = $_POST["nic"];
    $monthlyIncome = 0;
    $monthlyExpenses = 0;
    $monthlyProfit = 0;
    $monthlyWthdrawals = 0;
    $totalBalance = 0;
    $today = date("Y-m-d");
    $currentYear = date("Y");
    $currentMonth = date("m");

    if (empty($amount)) {
        echo "You hanen't added Salary Amount";
    } else {
        $rs =  Database::search("SELECT * FROM `team` WHERE `nic` = '" . $nic . "'");
        if ($rs->num_rows > 0) {
            $d = $rs->fetch_assoc();
            $tid = $d['team_id'];
            $srs = Database::search("SELECT * FROM `salary` WHERE `team_id` = '" . $tid . "' AND YEAR(`date`) = '" . $currentYear . "' AND MONTH(`date`) = '" . $currentMonth . "'");
            if ($srs->num_rows > 0) {
                $sd = $srs->fetch_assoc();
                $id = $sd['id'];
                $amount = $amount + $sd['amount'];
                Database::iud("UPDATE `salary` SET `amount` = '" . $amount . "',`date` = '" . $today . "', `team_id` = '" . $tid . "' WHERE  `id` ='" . $id . "' ");
            } else {
                Database::iud("INSERT INTO `salary`(`amount`,`date`,`team_id`) VALUES('" . $amount . "','" . $today . "','" . $tid . "') ");
            }
            $cptrs2 = Database::search("SELECT * FROM `customer_payments` WHERE YEAR(`date`) = '" . $currentYear . "' AND MONTH(`date`) = '" . $currentMonth . "'");
            $cptn2 = $cptrs2->num_rows;
            if ($cptn2 > 0) {
                for ($a = 0; $a < $cptn2; $a++) {
                    $cptd2 = $cptrs2->fetch_assoc();
                    $monthlyIncome = $monthlyIncome + $cptd2['amount'];
                }
            }
            $exrs2 = Database::search("SELECT * FROM `expenses` WHERE YEAR(`date`) = '$currentYear' AND MONTH(`date`) = '$currentMonth' AND `expense_type_id` !='5'");
            $exn2 = $exrs2->num_rows;
            if ($exn2 > 0) {
                for ($c = 0; $c < $exn2; $c++) {
                    $exd2 = $exrs2->fetch_assoc();
                    $monthlyExpenses = $monthlyExpenses + $exd2['amount'];
                }
            }
            $sars2 = Database::search("SELECT * FROM `salary` WHERE YEAR(`date`) = '$currentYear' AND MONTH(`date`) = '$currentMonth'");
            $san2 = $sars2->num_rows;
            if ($san2 > 0) {
                for ($f = 0; $f < $san2; $f++) {
                    $sad2 = $sars2->fetch_assoc();
                    $monthlyExpenses = $monthlyExpenses + $sad2['amount'];
                }
            }
            $sprs3 = Database::search("SELECT * FROM `supplier_payments` WHERE YEAR(`date`) = '$currentYear' AND MONTH(`date`) = '$currentMonth'");
            $spn3 = $sprs3->num_rows;
            if ($spn3 > 0) {
                for ($g = 0; $g < $spn3; $g++) {
                    $spd3 = $sprs3->fetch_assoc();
                    $monthlyExpenses = $monthlyExpenses + $spd3['amount'];
                }
            }
            $monthlyProfit = $monthlyIncome - $monthlyExpenses;
            $mwrs = Database::search("SELECT * FROM `expenses` WHERE YEAR(`date`) = '$currentYear' AND MONTH(`date`) = '$currentMonth' AND `expense_type_id` ='5'");
            $mwn = $mwrs->num_rows;
            if ($mwn > 0) {
                for ($h = 0; $h < $mwn; $h++) {
                    $mwd = $mwrs->fetch_assoc();
                    $monthlyWthdrawals = $monthlyWthdrawals + $mwd['amount'];
                }
            }
            $totalBalance = $monthlyProfit - $monthlyWthdrawals;

            $rs = Database::search("SELECT * FROM `summary` WHERE MONTH(`date`) = '" . $currentMonth . "' AND YEAR(`date`) = '" . $currentYear . "'");
            $n = $rs->num_rows;
            if ($n > 0) {
                $d = $rs->fetch_assoc();
                $id = $d['id'];
                Database::iud("UPDATE `summary` SET `date`='" . $today . "',`m_income`='" . $monthlyIncome . "',`m_expenses`='" . $monthlyExpenses . "',`m_profit`='" . $monthlyProfit . "',`withdrawals`='" . $monthlyWthdrawals . "',`balance`='" . $totalBalance . "' WHERE `id` = '" . $id . "'");
            } else {
                Database::iud("INSERT INTO `summary` (`date`, `m_income`, `m_expenses`,`m_profit`,`withdrawals`,`balance`) VALUES ('" . $today . "', '" . $monthlyIncome . "', '" . $monthlyExpenses . "', '" . $monthlyProfit . "', '" . $monthlyWthdrawals . "', '" . $totalBalance . "')");
            }
            echo "success";
        }
    }
} else {
    echo "error";
}
