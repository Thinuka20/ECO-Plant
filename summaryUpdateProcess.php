<?php

require "connection.php";

if (isset($_POST["m_income"]) & isset($_POST["m_expenses"]) & isset($_POST["m_profit"]) & isset($_POST["withdrawals"]) & isset($_POST["balance"])) {

    $m_income = $_POST['m_income'];
    $m_expenses = $_POST["m_expenses"];
    $m_profit = $_POST["m_profit"];
    $withdrawals = $_POST["withdrawals"];
    $balance = $_POST["balance"];

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d");
    $currentMonth = date('m');
    $currentYear = date('Y');

    

    $rs = Database::search("SELECT * FROM `summary` WHERE MONTH(`date`) = '" . $currentMonth . "' AND YEAR(`date`) = '" . $currentYear . "'");
    $n = $rs->num_rows;
    if ($n > 0) {
        $d = $rs->fetch_assoc();
        $id = $d['id'];
        Database::iud("UPDATE `summary` SET `date`='" . $date . "',`m_income`='" . $m_income . "',`m_expenses`='" . $m_expenses . "',`m_profit`='" . $m_profit . "',`withdrawals`='" . $withdrawals . "',`balance`='" . $balance . "' WHERE `id` = '" . $id . "'");
    } else {
        Database::iud("INSERT INTO `summary` (`date`, `m_income`, `m_expenses`,`m_profit`,`withdrawals`,`balance`) VALUES ('" . $date . "', '" . $m_income . "', '" . $m_expenses . "', '" . $m_profit . "', '" . $withdrawals . "', '" . $balance . "')");
    }
    echo ("done");
}
