    <?php

    require "connection.php";

    if (isset($_POST["startDate"]) & isset($_POST["endDate"])) {

        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        $rs = Database::search("SELECT
                                    'expenses' AS source,
                                    expenses.amount,
                                    expenses.date,
                                    expense_type.name AS particulars
                                FROM expenses 
                                INNER JOIN expense_type ON expense_type.et_id = expenses.expense_type_id 
                                WHERE expenses.date BETWEEN '$startDate' AND '$endDate' AND expenses.expense_type_id != '5'

                                UNION ALL

                                SELECT
                                    'expenses2' AS source,
                                    expenses.amount,
                                    expenses.date,
                                    expense_type.name AS particulars
                                FROM expenses 
                                INNER JOIN expense_type ON expense_type.et_id = expenses.expense_type_id 
                                WHERE expenses.date BETWEEN '$startDate' AND '$endDate' AND expenses.expense_type_id = '5'
                                                                
                                UNION ALL
                                
                                SELECT
                                    'salary' AS source,
                                    salary.amount,
                                    salary.date,
                                    CONCAT('Salary for ',team.f_name, ' ',team.l_name) AS particulars
                                FROM salary 
                                INNER JOIN team ON team.team_id = salary.team_id 
                                WHERE salary.date BETWEEN '$startDate' AND '$endDate'
                                
                                UNION ALL
                                
                                SELECT
                                    'supplier_payments' AS source,
                                    supplier_payments.amount,
                                    supplier_payments.date,
                                    CONCAT('Supplier Payment for ',supplier.s_name) AS particulars
                                FROM supplier_payments 
                                INNER JOIN supplier ON supplier.supplier_id = supplier_payments.supplier_id 
                                WHERE supplier_payments.date BETWEEN '$startDate' AND '$endDate'
                                
                                UNION ALL
                                
                                SELECT
                                    'customer_payments' AS source,
                                    customer_payments.amount,
                                    customer_payments.date,
                                    CONCAT('Customer Payment From ',customer.f_name, ' ',customer.l_name) AS particulars
                                FROM customer_payments 
                                INNER JOIN customer ON customer.customer_id = customer_payments.customer_id 
                                WHERE customer_payments.date BETWEEN '$startDate' AND '$endDate'
                                
                                ORDER BY `date` ASC");


        $n = $rs->num_rows;

        if ($n > 0) {
            $date2 = new DateTime($startDate);
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
                if ($d["source"] == 'expenses' || $d["source"] == 'salary' || $d["source"] == 'supplier_payments') {
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
    }

    ?>