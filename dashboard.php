<?php
session_start();

include "connection.php";
if (isset($_SESSION["user"])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Eco Plant & Energy (Pvt) Ltd | Dashboard</title>
        <link rel="icon" type="image/x-icon" href="resourses/lo.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="css/style.css">
        <style>
            #loading-animation {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255, 0.9);
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .spinner {
                border: 4px solid rgba(0, 0, 0, 0.1);
                border-left-color: #07c06a;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }
        </style>
    </head>

    <body style="overflow-x: hidden;">
        <div id="loading-animation">
            <div class="spinner"></div>
        </div>
        <?php
        $dailyIncome = 0;
        $monthlyIncome = 0;
        $dailyExpenses = 0;
        $monthlyExpenses = 0;
        $dailyProfit = 0;
        $monthlyProfit = 0;
        $monthlyWthdrawals = 0;
        $totalBalance = 0;
        $today = date("Y-m-d");
        $currentYear = date("Y");
        $currentMonth = date("m");

        require "navbar.php";
        ?>
        <div class="row">
            <!-- left side -->
            <?php
            require "leftside.php";
            ?>
            <!-- right side -->
            <div class="col-lg-10 offset-lg-2 offset-md-0 offset-sm-0 offset-0 p-5 mt-5 mt-lg-0">
                <div class="row">
                    <div class="col-12">
                        <p class="headings">Dashboard</p><br>
                        <p class="sub_headings">Dashboard</p>
                    </div>
                </div>
                <div class="col-12 p-lg-5 p-4 summary_div">
                    <p class="sub_headings2">Summary</p>
                    <div class="col-12">
                        <div class="row">
                            <?php
                            $cptrs = Database::search("SELECT * FROM `customer_payments` WHERE DATE(`date`) = '" . $today . "'");
                            $cptn = $cptrs->num_rows;
                            if ($cptn > 0) {
                                for ($z = 0; $z < $cptn; $z++) {
                                    $cptd = $cptrs->fetch_assoc();
                                    $dailyIncome = $dailyIncome + $cptd['amount'];
                                }
                            }
                            ?>
                            <div class="col-lg-3 mt-2">
                                <div class="blue admin_divs pt-3 pb-3 ps-lg-5 ps-4 pe-5">
                                    <p class="admin_headings">Daily Income</p>
                                    <p class="admin_headings_t">Rs.<?php echo $dailyIncome; ?>.00</p>
                                </div>
                            </div>
                            <?php
                            $cptrs2 = Database::search("SELECT * FROM `customer_payments` WHERE YEAR(`date`) = '" . $currentYear . "' AND MONTH(`date`) = '" . $currentMonth . "'");
                            $cptn2 = $cptrs2->num_rows;
                            if ($cptn2 > 0) {
                                for ($a = 0; $a < $cptn2; $a++) {
                                    $cptd2 = $cptrs2->fetch_assoc();
                                    $monthlyIncome = $monthlyIncome + $cptd2['amount'];
                                }
                            }
                            ?>
                            <div class="col-lg-3 mt-2">
                                <div class="green admin_divs pt-3 pb-3 ps-lg-5 ps-4 pe-5">
                                    <p class="admin_headings text-white">Monthly Income</p>
                                    <p class="admin_headings_t text-white">Rs.<?php echo $monthlyIncome; ?>.00</p>
                                </div>
                            </div>
                            <?php
                            $exrs = Database::search("SELECT * FROM `expenses` WHERE DATE(`date`) = '" . $today . "' AND `expense_type_id` !='5'");
                            $exn = $exrs->num_rows;
                            if ($exn > 0) {
                                for ($b = 0; $b < $exn; $b++) {
                                    $exd = $exrs->fetch_assoc();
                                    $dailyExpenses = $dailyExpenses + $exd['amount'];
                                }
                            }
                            $sars = Database::search("SELECT * FROM `salary` WHERE DATE(`date`) = '" . $today . "'");
                            $san = $sars->num_rows;
                            if ($san > 0) {
                                for ($d = 0; $d < $san; $d++) {
                                    $sad = $sars->fetch_assoc();
                                    $dailyExpenses = $dailyExpenses + $sad['amount'];
                                }
                            }
                            $sprs2 = Database::search("SELECT * FROM `supplier_payments` WHERE DATE(`date`) = '" . $today . "'");
                            $spn2 = $sprs2->num_rows;
                            if ($spn2 > 0) {
                                for ($e = 0; $e < $spn2; $e++) {
                                    $spd2 = $sprs2->fetch_assoc();
                                    $dailyExpenses = $dailyExpenses + $spd2['amount'];
                                }
                            }
                            ?>
                            <div class="col-lg-3 mt-2">
                                <div class="yellow admin_divs pt-3 pb-3 ps-lg-5 ps-4 pe-5">
                                    <p class="admin_headings">Daily Expenses</p>
                                    <p class="admin_headings_t">Rs.<?php echo $dailyExpenses; ?>.00</p>
                                </div>
                            </div>
                            <?php
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
                            ?>
                            <div class="col-lg-3 mt-2">
                                <div class="red admin_divs pt-3 pb-3 ps-lg-5 ps-4 pe-5">
                                    <p class="admin_headings text-white">Monthly Expenses</p>
                                    <p class="admin_headings_t text-white">Rs.<?php echo $monthlyExpenses; ?>.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-lg-4">
                        <div class="row">
                            <?php
                            $dailyProfit = $dailyIncome - $dailyExpenses;
                            ?>
                            <div class="col-lg-3 mt-2">
                                <div class="lblue admin_divs pt-3 pb-3 ps-lg-5 ps-4 pe-5">
                                    <p class="admin_headings">Daily Profit</p>
                                    <p class="admin_headings_t">Rs.<?php echo $dailyProfit; ?>.00</p>
                                </div>
                            </div>
                            <?php
                            $monthlyProfit = $monthlyIncome - $monthlyExpenses;
                            ?>
                            <div class="col-lg-3 mt-2">
                                <div class="lgreen admin_divs pt-3 pb-3 ps-lg-5 ps-4 pe-5">
                                    <p class="admin_headings text-white">Monthly Profit</p>
                                    <p class="admin_headings_t text-white">Rs.<?php echo $monthlyProfit; ?>.00</p>
                                </div>
                            </div>
                            <?php
                            $mwrs = Database::search("SELECT * FROM `expenses` WHERE YEAR(`date`) = '$currentYear' AND MONTH(`date`) = '$currentMonth' AND `expense_type_id` ='5'");
                            $mwn = $mwrs->num_rows;
                            if ($mwn > 0) {
                                for ($h = 0; $h < $mwn; $h++) {
                                    $mwd = $mwrs->fetch_assoc();
                                    $monthlyWthdrawals = $monthlyWthdrawals + $mwd['amount'];
                                }
                            }
                            ?>
                            <div class="col-lg-3 mt-2">
                                <div class="lyellow admin_divs pt-3 pb-3 ps-lg-5 ps-4 pe-5">
                                    <p class="admin_headings">Monthly Widrawals</p>
                                    <p class="admin_headings_t">Rs.<?php echo $monthlyWthdrawals; ?>.00</p>
                                </div>
                            </div>
                            <?php
                            $totalBalance = $monthlyProfit - $monthlyWthdrawals;
                            ?>
                            <div class="col-lg-3 mt-2">
                                <div class="lred admin_divs pt-3 pb-3 ps-lg-5 ps-4 pe-5">
                                    <p class="admin_headings text-white">Total Balance</p>
                                    <p class="admin_headings_t text-white">Rs.<?php echo $totalBalance; ?>.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-2 offset-lg-4 mt-4"> 
                                <a href="reportprint.php"><button class="btn btn-primary col-10 col-lg-12 offset-1 offset-lg-0">Print Monthly Statement</button></a>        
                        </div>
                            <div class="col-lg-2 mt-4">
                            <a href="summaryprint.php"><button class="btn btn-success col-10 col-lg-12 offset-1 offset-lg-0">Print Summary Statement</button></a>        
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class=" p-lg-5 p-4 project_div mt-4">
                            <p class="sub_headings2">Daily Income And Expences</p>
                            <div class="programming-stats">
                                <div class="chart-container mt-3">
                                    <canvas class="my-chart"></canvas>
                                </div>
                                <div class="details">
                                    <ul id="dailyExpensesUl">
                                        <li>Income: <span class='percentage' id="dailyincome">Rs.<?php echo $dailyIncome; ?>.00</span></li>
                                        <li>Expences: <span class='percentage' id="dailyexpences">Rs.<?php echo $dailyExpenses; ?>.00</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class=" p-lg-5 p-4 project_div mt-4">
                            <p class="sub_headings2">Monthly Income And Expences</p>
                            <div class="programming-stats">
                                <div class="chart-container mt-3">
                                    <canvas class="monthly-expenses-chart"></canvas>
                                </div>
                                <div class="details">
                                    <ul id="monthlyExpensesUl">
                                        <li>Income: <span class='percentage' id="monthlylyincome">Rs.<?php echo $monthlyIncome; ?>.00</span></li>
                                        <li>Expences: <span class='percentage' id="monthlyexpences">Rs.<?php echo $monthlyExpenses; ?>.00</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class=" p-lg-5 p-4 project_div mt-4">
                            <p class="sub_headings2">Projects</p>
                            <div class="col-12">
                                <div class="row">
                                    <?php
                                    $completed = 0;
                                    $all = 0;
                                    $pending = 0;

                                    $irs2 = Database::search("SELECT * FROM `invoice`");
                                    $in2 = $irs2->num_rows;
                                    if ($in2 > 0) {
                                        $all = $in2;
                                        for ($x = 0; $x < $in2; $x++) {
                                            $id2 = $irs2->fetch_assoc();

                                            if ($id2['payment_status_id'] == 1) {
                                                $completed = $completed + 1;
                                            } else {
                                                $pending = $pending + 1;
                                            }
                                        }
                                    }

                                    ?>
                                    <div class="col-lg-4 mt-2">
                                        <div class="bg-primary admin_divs pt-2 pb-2 ps-4">
                                            <p class="admin_headings">All</p>
                                            <p class="admin_headings_t mb-0"><?php echo $all; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class=" bg-success admin_divs pt-2 pb-2 ps-4">
                                            <p class="admin_headings">Completed</p>
                                            <p class="admin_headings_t mb-0"><?php echo $completed; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <div class=" bg-warning admin_divs pt-2 pb-2 ps-4">
                                            <p class="admin_headings">Pending</p>
                                            <p class="admin_headings_t mb-0"><?php echo $pending; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-5">
                                <table class="table table-hover ">
                                    <thead>
                                        <tr>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $irs = Database::search("SELECT * FROM `invoice` INNER JOIN `customer` ON `invoice`.`customer_id` = `customer`.`customer_id` ORDER BY `date` DESC LIMIT 5");
                                        $in = $irs->num_rows;
                                        if ($in > 0) {
                                            for ($i = 0; $i < $in; $i++) {
                                                $id = $irs->fetch_assoc();
                                        ?>
                                                <tr>
                                                    <th scope="row"><?php echo $id["f_name"]; ?> <?php echo $id["l_name"]; ?></th>
                                                    <td>Rs.<?php echo $id["sub_total"]; ?>.00</td>
                                                    <td><?php echo $id["date"]; ?></td>
                                                    <?php
                                                    if ($id['payment_status_id'] == 1) {
                                                    ?>
                                                        <td>Completed</td>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <td>Pending</td>
                                                    <?php
                                                    }
                                                    ?>

                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" d-flex justify-content-center mt-4">
                                        <a href="customer.php"><button class="btn btn-primary px-5">See All</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class=" p-lg-5 p-4 project_div mt-4">
                            <p class="sub_headings2">Team</p>
                            <div class="col-12">
                                <div class="row">
                                    <?php
                                    $onbord = 0;
                                    $comitioners = 0;
                                    $trs = Database::search("SELECT * FROM `team`");
                                    $tn = $trs->num_rows;
                                    for ($x = 0; $x < $tn; $x++) {
                                        $td = $trs->fetch_assoc();
                                        if ($td['occupation_id'] == 3) {
                                            $comitioners = $comitioners + 1;
                                        } else {
                                            $onbord = $onbord + 1;
                                        }
                                    }
                                    ?>
                                    <div class="col-lg-6 mt-2">
                                        <div class="bg-primary admin_divs pt-2 pb-2 ps-4">
                                            <p class="admin_headings">Onboard</p>
                                            <p class="admin_headings_t mb-0"><?php echo $onbord; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <div class=" bg-warning admin_divs pt-2 pb-2 ps-4">
                                            <p class="admin_headings">Freelancers</p>
                                            <p class="admin_headings_t mb-0"><?php echo $comitioners; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-5 ">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Mobile</th>
                                            <th scope="col">NIC</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Job Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $te_rs = Database::search("SELECT * FROM `team` LIMIT 5 OFFSET 0");
                                        $te_num = $te_rs->num_rows;

                                        for ($x = 0; $x < $te_num; $x++) {
                                            $te_data = $te_rs->fetch_assoc();
                                            $oc_rs = Database::search("SELECT * FROM `occupation` WHERE `o_id` = '" . $te_data["occupation_id"] . "'");
                                            $oc_data = $oc_rs->fetch_assoc();
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $te_data["team_id"]; ?></th>
                                                <td><?php echo $te_data["f_name"]; ?> <?php echo $te_data["l_name"]; ?></td>
                                                <td><?php echo $te_data["mobile"]; ?></td>
                                                <td><?php echo $te_data["nic"]; ?></td>
                                                <td><?php echo $te_data["address"]; ?></td>
                                                <td><?php echo $oc_data["oname"]; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" d-flex justify-content-center mt-4">
                                        <a href="team.php"><button class="btn btn-primary px-5">See All</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class=" p-lg-5 p-4 project_div mt-4">
                            <p class="sub_headings2">Expenses</p>
                            <div class="table-responsive mt-5 ">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Expenses Type</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $ers = Database::search("SELECT * FROM `expenses` INNER JOIN `expense_type` ON `expenses`.`expense_type_id` = `expense_type`.`et_id` ORDER BY `date` DESC LIMIT 5 OFFSET 0");
                                        $en = $ers->num_rows;
                                        if ($en > 0) {
                                            for ($i = 0; $i < $en; $i++) {
                                                $ed = $ers->fetch_assoc();
                                        ?>

                                                <tr>
                                                    <th scope="row"><?php echo $ed['expenses_id'] ?></th>
                                                    <td><?php echo $ed['name'] ?></td>
                                                    <td>Rs.<?php echo $ed['amount'] ?>.00</td>
                                                    <td><?php echo $ed['date'] ?></td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class=" d-flex justify-content-center mt-4">
                                        <a href="expenses.php"><button class="btn btn-primary px-5">See All</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class=" p-lg-5 p-4 project_div mt-4">
                            <p class="sub_headings2">Supplier Details</p>
                            <div class="table-responsive mt-5 ">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Supplier Name</th>
                                            <th scope="col">Mobile</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Due Payments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?PHP
                                        $srs = Database::search("SELECT * FROM `supplier` LIMIT 5 OFFSET 0");
                                        $sn = $srs->num_rows;
                                        if ($sn > 0) {
                                            for ($x = 0; $x < $sn; $x++) {
                                                $sd = $srs->fetch_assoc();

                                                $totalprice = 0;
                                                $totalpaid = 0;
                                                $totaldue = 0;

                                                $prs = Database::search("SELECT * FROM `product` WHERE `supplier_id` = '" . $sd['supplier_id'] . "'");
                                                $pn = $prs->num_rows;
                                                if ($pn > 0) {
                                                    for ($y = 0; $y < $pn; $y++) {
                                                        $pd = $prs->fetch_assoc();
                                                        $totalprice = $totalprice + $pd['price'];
                                                    }
                                                }

                                                $sprs = Database::search("SELECT * FROM `supplier_payments` WHERE `supplier_id` = '" . $sd['supplier_id'] . "'");
                                                $spn = $sprs->num_rows;
                                                if ($spn > 0) {
                                                    for ($z = 0; $z < $spn; $z++) {
                                                        $spd = $sprs->fetch_assoc();
                                                        $totalpaid = $totalpaid + $spd['amount'];
                                                    }
                                                }

                                                $totaldue = $totalprice - $totalpaid;

                                        ?>
                                                <tr>
                                                    <th scope="row"><?php echo $sd['supplier_id'] ?></th>
                                                    <td><?php echo $sd['s_name'] ?></td>
                                                    <td><?php echo $sd['mobile'] ?></td>
                                                    <td><?php echo $sd['address'] ?></td>
                                                    <td>Rs.<?php echo $totaldue ?>.00</td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class=" d-flex justify-content-center mt-4">
                                        <a href="supplier.php"><button class="btn btn-primary px-5">See All</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class=" p-lg-5 p-4 project_div mt-4">
                            <p class="sub_headings2">Monthly Salaries</p>
                            <div class="table-responsive mt-5 ">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">id</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Job Role</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sars = Database::search("SELECT * FROM `salary` INNER JOIN `team` ON `team`.`team_id` = `salary`.`team_id` INNER JOIN `occupation` ON `occupation`.`o_id` = `team`.`occupation_id` ORDER BY `date` DESC LIMIT 5 OFFSET 0");
                                        $san = $sars->num_rows;
                                        $c = 0;
                                        if ($san > 0) {
                                            for ($i = 0; $i < $san; $i++) {
                                                $sad = $sars->fetch_assoc();
                                                $c = $c + 1;
                                        ?>
                                                <tr>
                                                    <td><?php echo $c ?></td>
                                                    <th scope="row"><?php echo $sad['f_name'] ?> <?php echo $sad['l_name'] ?></th>
                                                    <td><?php echo $sad['oname'] ?></td>
                                                    <td>Rs.<?php echo $sad['amount'] ?>.00</td>
                                                    <td><?php echo $sad['date'] ?></td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class=" d-flex justify-content-center mt-4">
                                        <a href="comingsoon.php"><button class="btn btn-primary px-5">See All</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var dailyIncome = <?php echo json_encode($dailyIncome); ?>;
                    var dailyExpenses = <?php echo json_encode($dailyExpenses); ?>;
                    const chartData = {
                        labels: ["Income", "Expenses"],
                        data: [dailyIncome, dailyExpenses],
                    };

                    const myChart = document.querySelector(".my-chart");
                    const dailyExpensesUl = document.getElementById("dailyExpensesUl"); // Corrected ID

                    // Render the first chart
                    new Chart(myChart, {
                        type: "doughnut",
                        data: {
                            labels: chartData.labels,
                            datasets: [{
                                data: chartData.data,
                                backgroundColor: ["#007bff", "#ffc107"], // Example colors
                            }],
                        },
                        options: {
                            plugins: {
                                legend: {
                                    display: false,
                                },
                            },
                        },
                    });

                    var monthlyIncome = <?php echo json_encode($monthlyIncome); ?>;
                    var monthlyExpenses = <?php echo json_encode($monthlyExpenses); ?>;
                    const monthlyExpensesData = {
                        labels: ["Income", "Expenses"],
                        data: [monthlyIncome, monthlyExpenses],
                    };

                    const monthlyExpensesChartCanvas = document.querySelector(".monthly-expenses-chart");
                    const monthlyExpensesUl = document.getElementById("monthlyExpensesUl"); // Corrected ID

                    // Render the monthly expenses chart
                    new Chart(monthlyExpensesChartCanvas, {
                        type: "doughnut",
                        data: {
                            labels: monthlyExpensesData.labels,
                            datasets: [{
                                data: monthlyExpensesData.data,
                                backgroundColor: ["#007bff", "#ffc107"], // Example colors
                            }],
                        },
                        options: {
                            plugins: {
                                legend: {
                                    display: false,
                                },
                            },
                        },
                    });
                });
            </script>
            <script>
                window.addEventListener('load', function() {
                    var loadingAnimation = document.getElementById('loading-animation');
                    loadingAnimation.style.display = 'none';
                    summaryUpdate();
                });

                function summaryUpdate() {
                    var m_income = <?php echo json_encode($monthlyIncome); ?>;
                    var m_expenses = <?php echo json_encode($monthlyExpenses); ?>;
                    var m_profit = <?php echo json_encode($monthlyProfit); ?>;
                    var withdrawals = <?php echo json_encode($monthlyWthdrawals); ?>;
                    var balance2 = <?php echo json_encode($totalBalance); ?>;

                    var form = new FormData();
                    form.append("m_income", m_income);
                    form.append("m_expenses", m_expenses);
                    form.append("m_profit", m_profit);
                    form.append("withdrawals", withdrawals);
                    form.append("balance", balance2);

                    var req = new XMLHttpRequest();

                    req.onreadystatechange = function() {
                        if (req.readyState == 4 && req.status == 200) {

                        }
                    };
                    req.open("POST", "summaryUpdateProcess.php", true);
                    req.send(form);
                }
            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <script src="script.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>

    </html>
<?php
} else {
?>
    <script>
        window.location.href = "index.php";
    </script>
<?php
}
?>