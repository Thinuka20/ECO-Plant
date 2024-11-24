<?php

require "connection.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];
    $irs = Database::search("SELECT * FROM `invoice` INNER JOIN `customer` ON `invoice`.`customer_id` = `customer`.`customer_id` WHERE `invoice_id`= '" . $id . "'");
    $in = $irs->num_rows;
    if ($in > 0) {
        for ($i = 0; $i < $in; $i++) {
            $id = $irs->fetch_assoc();
            $totalpaid = 0;


            $cprs = Database::search("SELECT * FROM `customer_payments` WHERE `customer_id` = '" . $id["customer_id"] . "'");
            $cpn = $cprs->num_rows;
            if ($cpn > 0) {
                for ($y = 0; $y < $cpn; $y++) {
                    $cpd = $cprs->fetch_assoc();
                    $totalpaid = $totalpaid + $cpd['amount'];
                }
            }

            $totaldue = $id["sub_total"] - $totalpaid;
?>
            <div class="row">
                <div class="col-6 d-flex flex-column">
                    <label class="form-label fw-bold mt-2">Name:</label>
                    <label class="form-label"><?php echo $id["f_name"] ?> <?php echo $id["l_name"] ?></label>

                    <label class="form-label fw-bold mt-2">Mobile:</label>
                    <label class="form-label"><?php echo $id["mobile"] ?></label>

                    <label class="form-label fw-bold mt-2">Address:</label>
                    <label class="form-label"><?php echo $id["address"] ?></label>

                    <label class="form-label fw-bold mt-2">Purchesed Date:</label>
                    <label class="form-label"><?php echo $id["date"] ?></label>



                </div>
                <div class="col-6 d-flex flex-column">
                    <label class="form-label fw-bold mt-2">Price:</label>
                    <label class="form-label">Rs.<?php echo $id["sub_total"]; ?>.00</label>

                    <label class="form-label fw-bold mt-2">Paid Amount :</label>
                    <label class="form-label">Rs.<?php echo $totalpaid ?>.00</label>

                    <?php

                    if ($totalpaid >= $id["sub_total"]) {
                    ?>
                        <label class="form-label fw-bold mt-2">Payment Status:</label>
                        <label class="form-label"><span class="badge text-bg-success">Paid</span></label>
                    <?php
                    } else {
                    ?>
                        <label class="form-label fw-bold mt-2">Due Amount :</label>
                        <label class="form-label">Rs.<?php echo $totaldue ?>.00</label>
                    <?php
                    }
                    $trs = Database::search("SELECT * FROM `team` WHERE `team_id`= '" . $id['team_id'] . "'");
                    $tn = $trs->num_rows;
                    if ($tn > 0) {
                        $td = $trs->fetch_assoc();
                    ?>
                    <label class="form-label fw-bold mt-2">Agent Name :</label>
                    <label class="form-label"><?php echo $td['f_name'].' '.$td['l_name'] ?></label>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mt-4">
                    <label class="form-label fw-bold mt-2 fs-5">Payment History :</label>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cprs2 = Database::search("SELECT * FROM `customer_payments` WHERE `customer_id` = '" . $id["customer_id"] . "'");
                            $cpn2 = $cprs2->num_rows;
                            $a = 0;
                            if ($cpn2 > 0) {
                                for ($z = 0; $z < $cpn2; $z++) {
                                    $cpd2 = $cprs2->fetch_assoc();
                                    $a = $a + 1;
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $a; ?></th>
                                        <td><?php echo $cpd2["date"]; ?></td>
                                        <td>Rs.<?php echo $cpd2["amount"]; ?>.00</td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php
        }
    }
}

?>