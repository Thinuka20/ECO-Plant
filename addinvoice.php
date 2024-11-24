<?php

require "connection.php";

$nic = $_POST["nic"];
$systemCap = $_POST["systemCap"];
$systemPrice = $_POST["systemPrice"];
$agent = $_POST["agent"];
$invoice_id = $_POST["invoice_id"];
$fName = $_POST["fName"];
$lName = $_POST["lName"];
$mobile = $_POST["mobile"];
$address = $_POST["address"];
$pStatus = $_POST["pStatus"];
$paidAmount = $_POST["paidAmount"];
$discount = $_POST["discount"];
$dPrice = $_POST["dPrice"];
$pMethod = $_POST["pMethod"];
$idintifi = $_POST["idintifi"];
$monthlyIncome = 0;
$monthlyExpenses = 0;
$monthlyProfit = 0;
$monthlyWthdrawals = 0;
$totalBalance = 0;
$today = date("Y-m-d");
$currentYear = date("Y");
$currentMonth = date("m");


$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");
if (empty($fName)) {
    echo ("Please Enter the Customer First Name");
} else if (strlen($fName) > 50) {
    echo ("Customer First Name Must have less than 50 characters");
} else if (empty($lName)) {
    echo ("Please Enter the Customer Last Name");
} else if (strlen($lName) > 50) {
    echo ("Customer Last Name Must have less than 50 characters");
} else if (!preg_match("/^\d{9}[VX]$/", $nic) && !preg_match('/^\d{12}$/', $nic)) {
    echo ("Invalid NIC Number");
} else if (empty($address)) {
    echo ("Please Enter the Customer Address");
} else if (strlen($address) > 100) {
    echo ("Customer Address Must have less than 100 characters");
} else if (strlen($mobile) != 10) {
    echo ("Customer Mobile Number Must contain 10 characters");
} else if (empty($mobile)) {
    echo ("Please Enter the Customer Mobile Number");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
    echo ("Invalid Mobile Number");
} else if (empty($systemCap)) {
    echo ("Please Enter the System Capacity");
} else if (empty($systemPrice)) {
    echo ("Please Enter the System Price");
} else {

    $inrs = Database::search("SELECT * FROM `invoice` WHERE `invoice_id` = '" . $invoice_id . "'");
    $inn = $inrs->num_rows;
    if ($inn > 0) {
        if ($pStatus == "01") {
            Database::iud("UPDATE `invoice` SET `payment_status_id`='1' WHERE `invoice_id` = '" . $invoice_id . "'");
            if (empty($paidAmount)) {
                echo ("Please Enter the Payment Amount");
            } else if ($pMethod == "01") {
                if (empty($idintifi)) {
                    echo ("Please Enter the Payment Identification");
                } else {
                    $inrs2 = Database::search("SELECT * FROM `invoice` WHERE `invoice_id` = '" . $invoice_id . "'");
                    $inn2 = $inrs2->num_rows;
                    if ($inn2 > 0) {
                        $d2 = $inrs2->fetch_assoc();
                        $cid2 = $d2['customer_id'];
                        Database::iud("INSERT INTO `customer_payments` (`customer_id`,`amount`,`date`,`payment_methord`,`identification`) VALUES ('" . $cid2 . "','" . $paidAmount . "','" . $date . "','" . $pMethod . "','" . $idintifi . "')");
                                echo ("success");
                    }
                }
            } else {
                $inrs2 = Database::search("SELECT * FROM `invoice` WHERE `invoice_id` = '" . $invoice_id . "'");
                $inn2 = $inrs2->num_rows;
                if ($inn2 > 0) {
                    $d2 = $inrs2->fetch_assoc();
                    $cid2 = $d2['customer_id'];
                    Database::iud("INSERT INTO `customer_payments` (`customer_id`,`amount`,`date`,`payment_methord`,`identification`) VALUES ('" . $cid2 . "','" . $paidAmount . "','" . $date . "','" . $pMethod . "','" . $idintifi . "')");
                            echo ("success");
                }
            }
        } else {
            echo ("success");
        }
        
    } else {
        Database::iud("INSERT INTO `customer` (`f_name`,`l_name`,`mobile`,`address`,`date`,`team_id`,`nic`,`system_capacity`) VALUES ('" . $fName . "','" . $lName . "','" . $mobile . "','" . $address . "','" . $date . "','" . $agent . "','" . $nic . "','" . $systemCap . "')");
        $cid = Database::$connection->insert_id;
        Database::iud("INSERT INTO `invoice` (`invoice_id`,`customer_id`,`payment_status_id`,`i_date`,`discount`,`sub_total`,`i_amount`) VALUES ('" . $invoice_id . "','" . $cid . "','2','" . $date . "','" . $discount . "','" . $dPrice . "','" . $systemPrice . "')");

        if ($agent !== "00") {
            Database::iud("UPDATE `customer` SET `team_id`='" . $agent . "' WHERE `customer_id` = '" . $cid . "'");
        }

        if ($pStatus == "01") {
            Database::iud("UPDATE `invoice` SET `payment_status_id`='1' WHERE `invoice_id` = '" . $invoice_id . "'");
            if (empty($paidAmount)) {
                echo ("Please Enter the Payment Amount");
            } else if ($pMethod !== "02") {
                if (empty($idintifi)) {
                    echo ("Please Enter the Payment Identification");
                }else{
                    Database::iud("INSERT INTO `customer_payments` (`customer_id`,`amount`,`date`,`payment_methord`,`identification`) VALUES ('" . $cid . "','" . $paidAmount . "','" . $date . "','" . $pMethod . "','" . $idintifi . "')");
                }
            } else {
                Database::iud("INSERT INTO `customer_payments` (`customer_id`,`amount`,`date`,`payment_methord`) VALUES ('" . $cid . "','" . $paidAmount . "','" . $date . "','" . $pMethod . "')");
            }
        }
        echo ("success");
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
    Database::iud("UPDATE `summary` SET `date`='" . $date . "',`m_income`='" . $monthlyIncome . "',`m_expenses`='" . $monthlyExpenses . "',`m_profit`='" . $monthlyProfit . "',`withdrawals`='" . $monthlyWthdrawals . "',`balance`='" . $totalBalance . "' WHERE `id` = '" . $id . "'");
} else {
    Database::iud("INSERT INTO `summary` (`date`, `m_income`, `m_expenses`,`m_profit`,`withdrawals`,`balance`) VALUES ('" . $date . "', '" . $monthlyIncome . "', '" . $monthlyExpenses . "', '" . $monthlyProfit . "', '" . $monthlyWthdrawals . "', '" . $totalBalance . "')");
}
}
