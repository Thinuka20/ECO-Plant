<?php
session_start();
include "connection.php";
if (isset($_SESSION["user"])) {

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eco Plant & Energy (Pvt) Ltd | Statements</title>
    <link rel="icon" type="image/x-icon" href="resourses/lo.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" rel="stylesheet">
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
    require "navbar.php";
    ?>
    <div class="row">
        <!-- left side -->
        <?php
        require "leftside.php";
        $firstDayOfMonth = date('Y-m');
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $lastDayOfMonth = $d->format("Y-m");
        $totalIncome = 0;
        $totalExpenses = 0;
        $totalProfit = 0;
        $totalWithdrawals = 0;
        $totalbalance = 0;
        ?>
        <!-- right side -->
        <div class="col-lg-10 offset-lg-2 offset-md-0 offset-sm-0 offset-0 p-5 mt-5 mt-lg-0">
            <div class="row">
                <div class="col-12">
                    <p class="headings">Statements</p><br>
                    <p class="sub_headings">Dashboard / Statements</p>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-3 offset-lg-6">
                            <label class="form-label fw-bold mt-3">Start Month :</label>
                            <input type="month" id="startDate" class="form-control form-control-sm " value="<?php echo $firstDayOfMonth ?>">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-bold mt-3">End Month :</label>
                            <input type="month" id="endDate" class="form-control form-control-sm " value="<?php echo $lastDayOfMonth ?>">
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end mt-3 mb-2">
                    <button class="btn btn-success col-2" onclick="searchSummary();">Search</button>
                </div>
            </div>

            <div class="container-fluid mt-2">
                <div class="row d-grid">
                    <div class="col-12 table-responsive">
                        <table id="example" class="display nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Month</th>
                                    <th scope="col">Monthly Income(LKR)</th>
                                    <th scope="col">Monthly Expenses(LKR)</th>
                                    <th scope="col">Monthly Profit(LKR)</th>
                                    <th scope="col">Withdrawals(LKR)</th>
                                    <th scope="col">Balance(LKR)</th>
                                </tr>
                            </thead>
                            <tbody id="sum_table">
                                <?php
                                $rs = Database::search("SELECT *, DATE_FORMAT(`date`, '%Y-%m') AS formatted_date FROM `summary` 
                                WHERE DATE_FORMAT(`date`, '%Y-%m') BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth' ORDER BY `date` ASC");


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
                                    <td>Total</td>
                                    <td><?php echo $totalIncome; ?></td>
                                    <td><?php echo $totalExpenses; ?></td>
                                    <td><?php echo $totalProfit; ?></td>
                                    <td><?php echo $totalWithdrawals; ?></td>
                                    <td><?php echo $totalbalance; ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/script.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>

    <script>
        new DataTable('#example', {
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
    <script>
        window.addEventListener('load', function() {
            var loadingAnimation = document.getElementById('loading-animation');
            loadingAnimation.style.display = 'none';
        });
    </script>

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