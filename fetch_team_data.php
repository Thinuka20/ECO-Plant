<?php

include "connection.php";
$te_rs = Database::search("SELECT * FROM `team`");

while ($te_data = $te_rs->fetch_assoc()) {
    $oc_rs = Database::search("SELECT * FROM `occupation` WHERE `o_id` = '" . $te_data["occupation_id"] . "'");
    $oc_data = $oc_rs->fetch_assoc();
    ?>
    <tr>
        <th scope="row"><?php echo $te_data["team_id"] ?></th>
        <td><?php echo $te_data["f_name"] ?> <?php echo $te_data["l_name"] ?></td>
        <td><?php echo $te_data["mobile"] ?></td>
        <td><?php echo $te_data["nic"] ?></td>
        <td><?php echo $te_data["address"] ?></td>
        <td><?php echo $oc_data["oname"]; ?></td>
        <?php if ($te_data["member_status_id"] == "1") { ?>
            <td><span class="badge rounded-pill bg-primary text-light align-items-start mt-1 ">Active</span></td>
        <?php } else { ?>
            <td><span class="badge rounded-pill bg-danger text-light  align-items-start mt-1">Inactive</span></td>
        <?php } ?>
        <td><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#view_t" onclick="memberDetails(<?php echo $te_data['team_id'] ?>);">View</button></td>
    </tr>
    <?php
}
?>
