<?php

require "connection.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $trs = Database::search("SELECT * FROM `team` INNER JOIN `occupation` ON `team`.`occupation_id`=`occupation`.`o_id` WHERE `team_id` = '$id'");
    $tn = $trs->num_rows;

    for ($x = 0; $x < $tn; $x++) {
        $td = $trs->fetch_assoc();
?>

        <div class="row">
            <div class="col-6 d-flex flex-column">
                <label class="form-label fw-bold mt-2">Name :</label>
                <label class="form-label"><?php echo $td["f_name"] ?> <?php echo $td["l_name"] ?></label>
                <label class="form-label fw-bold mt-2">Mobile :</label>
                <label class="form-label"><?php echo $td["mobile"] ?></label>
                <label class="form-label fw-bold mt-2">Job Role:</label>
                <label class="form-label">
                    <td><?php echo $td["oname"]; ?></td>
                </label>
            </div>
            <div class="col-6 d-flex flex-column">
                <label class="form-label fw-bold mt-2">NIC :</label>
                <label class="form-label"><?php echo $td["nic"] ?></label>
                <label class="form-label fw-bold mt-2">Address :</label>
                <label class="form-label"><?php echo $td["address"] ?></label>
                <label class="form-label fw-bold mt-2">Status :</label>
                <?php
                if ($td["member_status_id"] == "1") {
                ?>
                    <label class="form-label"><span class="badge rounded-pill bg-primary text-light align-items-start mt-1">Active</span></label>
                <?php
                } else {
                ?>
                    <label class="form-label"><span class="badge rounded-pill bg-danger text-light  align-items-start mt-1">Inactive</span></label>
                <?php
                }
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-4">
                <label class="form-label fw-bold mt-2 fs-5">Salary History :</label>
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

                        $srs = Database::search("SELECT * FROM `salary` WHERE `team_id` = '$id'");
                        $sn = $srs->num_rows;
                        $z = 0;
                        for ($y = 0; $y < $sn; $y++) {
                            $sd = $srs->fetch_assoc();
                            $z = $z + 1;

                        ?>
                            <tr>
                                <th scope="row"><?php echo $z ?></th>
                                <td><?php echo $sd["date"] ?></td>
                                <td>Rs.<?php echo $sd["amount"] ?>.00</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

<?php
    }
}

?>