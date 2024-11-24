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
        $firstDayOfMonth = date('Y-m-01');
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $lastDayOfMonth = $d->format("Y-m-d");
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
                            <label class="form-label fw-bold mt-3">Start Date :</label>
                            <input type="Date" id="startDate" class="form-control form-control-sm " value="<?php echo $firstDayOfMonth ?>">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-bold mt-3">End Date :</label>
                            <input type="Date" id="endDate" class="form-control form-control-sm " value="<?php echo $lastDayOfMonth ?>">
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end mt-3 mb-2">
                    <button class="btn btn-success col-2" onclick="searchTransactions();">Search</button>
                </div>
            </div>

            <div class="container-fluid mt-2">
                <div class="row d-grid">
                    <div class="col-12 table-responsive">
                        <table id="example" class="display nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Particulars</th>
                                    <th scope="col">Payments(LKR)</th>
                                    <th scope="col">Receipts(LKR)</th>
                                    <th scope="col">Balance(LKR)</th>
                                </tr>
                            </thead>
                            <tbody id="sum_table">
                                <?php
                                $rs = Database::search("SELECT
                                    'expenses' AS source,
                                    expenses.amount,
                                    expenses.date,
                                    expense_type.name AS particulars
                                FROM expenses 
                                INNER JOIN expense_type ON expense_type.et_id = expenses.expense_type_id 
                                WHERE expenses.date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth' AND expenses.expense_type_id != '5'
                                
                                UNION ALL

                                SELECT
                                    'expenses2' AS source,
                                    expenses.amount,
                                    expenses.date,
                                    expense_type.name AS particulars
                                FROM expenses 
                                INNER JOIN expense_type ON expense_type.et_id = expenses.expense_type_id 
                                WHERE expenses.date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth' AND expenses.expense_type_id = '5'
                                
                                UNION ALL
                                
                                SELECT
                                    'salary' AS source,
                                    salary.amount,
                                    salary.date,
                                    CONCAT('Salary for ',team.f_name, ' ',team.l_name) AS particulars
                                FROM salary 
                                INNER JOIN team ON team.team_id = salary.team_id 
                                WHERE salary.date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'
                                
                                UNION ALL
                                
                                SELECT
                                    'supplier_payments' AS source,
                                    supplier_payments.amount,
                                    supplier_payments.date,
                                    CONCAT('Supplier Payment for ',supplier.s_name) AS particulars
                                FROM supplier_payments 
                                INNER JOIN supplier ON supplier.supplier_id = supplier_payments.supplier_id 
                                WHERE supplier_payments.date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'
                                
                                UNION ALL
                                
                                SELECT
                                    'customer_payments' AS source,
                                    customer_payments.amount,
                                    customer_payments.date,
                                    CONCAT('Customer Payment From ',customer.f_name, ' ',customer.l_name) AS particulars
                                FROM customer_payments 
                                INNER JOIN customer ON customer.customer_id = customer_payments.customer_id 
                                WHERE customer_payments.date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'
                                
                                ORDER BY `date` ASC");


                                $n = $rs->num_rows;

                                if ($n > 0) {
                                    $date2 = new DateTime();
                                    $date2->modify('last month');
                                    $previousMonth = $date2->format('m');
                                    $previousYear = $date2->format('Y');
                                    $balance = 0;
                                    $sumrs = Database::search("SELECT * FROM `summary` WHERE MONTH(`date`) = '" . $previousMonth . "' AND YEAR(`date`) = '" . $previousYear . "'");
                                    $sumn = $sumrs->num_rows;
                                    if ($sumn > 0) {
                                        $sumd = $sumrs->fetch_assoc();
                                        $balance = $sumd['balance'];
                                    }
                                    while ($d = $rs->fetch_assoc()) {
                                        if ($d["source"] == 'expenses' || $d["source"] == 'salary' || $d["source"] == 'supplier_payments' || $d["source"] == 'expenses2') {
                                            $balance = $balance - $d["amount"];
                                        } else {
                                            $balance = $balance + $d["amount"];
                                        }
                                ?>
                                        <tr>
                                            <td><?php echo $d["date"]; ?></td>
                                            <td><?php echo $d["particulars"]; ?></td>
                                            <td><?php echo ($d["source"] == 'expenses' || $d["source"] == 'salary' || $d["source"] == 'supplier_payments') ? $d["amount"] : ''; ?></td>
                                            <td><?php echo ($d["source"] == 'customer_payments' || $d["source"] == 'expenses2') ? $d["amount"] : ''; ?></td>
                                            <td><?php echo $balance ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>

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