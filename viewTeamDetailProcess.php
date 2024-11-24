<?php
include "connection.php";

$tid = $_GET["id"];


$rs = Database::search("SELECT * FROM `team` WHERE `team_id` = '" . $tid . "'");

if ($rs->num_rows > 0) {


    $rdata = $rs->fetch_assoc();
    $prs = Database::search("SELECT * FROM `occupation` WHERE `o_id` = '" . $rdata["occupation_id"] . "'");
    $pnums = $prs->num_rows;
    $occupationOptions = "";
    if ($pnums > 0) {
        $pdata = $prs->fetch_assoc();
        $ars = Database::search("SELECT * FROM `member_status`");
        $anums = $ars->num_rows;

        $ors = Database::search("SELECT * FROM `occupation`");
        while ($odata = $ors->fetch_assoc()) {
            // Check if the current occupation matches the team member's occupation
            $selected = ($rdata["occupation_id"] == $odata["o_id"]) ? 'selected' : '';
            $occupationOptions .= "<option value='{$odata["o_id"]}' {$selected}>{$odata["oname"]}</option>";
        }



        $statusIsActive = false;


        $statusIsActive = $rdata["member_status_id"] == '1';
    }
}

?>
<div class="row">
    <div class="col-6">
        <div class="d-flex flex-column">

            <label class="form-label fw-bold mt-2">Name:</label>
            <input type="text" id="fn" class="form-control form-control-sm" value="<?php echo $rdata["f_name"]; ?>">
            <input type="text" id="ln" class="form-control form-control-sm mt-1" value="<?php echo $rdata["l_name"]; ?>">





        </div>
        <div class="d-flex flex-column mt-2">
            <label class="form-label fw-bold mt-2">Mobile:</label>
            <input type="text" id="mob" class="form-control form-control-sm" value="<?php echo $rdata["mobile"]; ?>">
        </div>

        <div class="d-flex flex-column mt-2">
            <label class="form-label fw-bold mt-2">Address:</label>
            <input type="text" id="addr" class="form-control form-control-sm" value="<?php echo $rdata["address"]; ?>">
        </div>

    </div>
    <div class="col-6">
        <label class="form-label fw-bold mt-2">Position :</label>
        <select name="" id="pos" class="form-control form-control-sm">
            <?php echo $occupationOptions; // Echo all occupation options 
            ?>
        </select>
        <div class="d-flex flex-column mt-2">
            <label class="form-label fw-bold mt-2">NIC:</label>
            <input disabled type="text" id="ni" class="form-control form-control-sm" value="<?php echo $rdata["nic"]; ?>">
        </div>
        <div>
            <label class="form-label fw-bold mt-3">Status :</label>
            <select name="" id="st" class="form-control form-control-sm">
                <?php

                for ($i = 0; $i < $anums; $i++) {
                    $adata = $ars->fetch_assoc();
                ?>
                    <option value="<?php echo $adata["ms_id"]; ?>" <?php echo !$statusIsActive ? 'selected' : ''; ?>><?php echo $adata["tsname"]; ?></option>


                <?php



                }



                ?>
            </select>

        </div>



    </div>
    <hr class="mt-4 border-success">
    <div class="col-12">
        <p class="fw-bold fs-4">Add Salary</p>
        <div class="d-flex flex-column mt-2">
            <label class="form-label fw-bold mt-2">Amount:</label>
            <input type="number" id="amount" class="form-control form-control-sm">
        </div>
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

                $srs = Database::search("SELECT * FROM `salary` WHERE `team_id` = '$tid'");
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



?>