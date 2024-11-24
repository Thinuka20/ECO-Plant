<?php

require "connection.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];
    $srs = Database::search("SELECT * FROM `supplier` WHERE `supplier_id`= '" . $id . "'");
    $sn = $srs->num_rows;
    if ($sn > 0) {
        for ($i = 0; $i < $sn; $i++) {
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
            <div class="row">
                <div class="col-6 d-flex flex-column">
                    <label class="form-label fw-bold mt-2">Name:</label>
                    <label class="form-label"><?php echo $sd['s_name'] ?></label>

                    <label class="form-label fw-bold mt-2">Mobile:</label>
                    <label class="form-label"><?php echo $sd['mobile'] ?></label>
                </div>
                <div class="col-6 d-flex flex-column">
                    <label class="form-label fw-bold mt-2">Address:</label>
                    <label class="form-label"><?php echo $sd['address'] ?></label>

                    <label class="form-label fw-bold mt-2">Due Payments:</label>
                    <label class="form-label" id="due">Rs.<?php echo $totaldue ?>.00</label>
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
                            $sprs2 = Database::search("SELECT * FROM `supplier_payments` WHERE `supplier_id` = '" . $sd['supplier_id'] . "'");
                            $spn2 = $sprs2->num_rows;
                            $a = 0;
                            if ($spn2 > 0) {
                                for ($z = 0; $z < $spn2; $z++) {
                                    $spd2 = $sprs2->fetch_assoc();
                                    $a = $a + 1;
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $a ?></th>
                                        <td><?php echo $spd2['date'] ?></td>
                                        <td>Rs.<?php echo $spd2['amount'] ?>.00</td>
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