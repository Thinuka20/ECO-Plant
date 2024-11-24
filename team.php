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
        <title>Eco Plant & Energy (Pvt) Ltd | Team Members</title>
        <link rel="icon" type="image/x-icon" href="resourses/lo.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

            .spinner2 {
                width: 44.8px;
                height: 44.8px;
                animation: spinner-y0fdc1 2s infinite ease;
                transform-style: preserve-3d;
            }

            .spinner2>div {
                background-color: rgba(0, 215, 110, 0.2);
                height: 100%;
                position: absolute;
                width: 100%;
                border: 2.2px solid #00d76e;
            }

            .spinner2 div:nth-of-type(1) {
                transform: translateZ(-22.4px) rotateY(180deg);
            }

            .spinner2 div:nth-of-type(2) {
                transform: rotateY(-270deg) translateX(50%);
                transform-origin: top right;
            }

            .spinner2 div:nth-of-type(3) {
                transform: rotateY(270deg) translateX(-50%);
                transform-origin: center left;
            }

            .spinner2 div:nth-of-type(4) {
                transform: rotateX(90deg) translateY(-50%);
                transform-origin: top center;
            }

            .spinner2 div:nth-of-type(5) {
                transform: rotateX(-90deg) translateY(50%);
                transform-origin: bottom center;
            }

            .spinner2 div:nth-of-type(6) {
                transform: translateZ(22.4px);
            }

            .textP {
                color: gray;
                font-size: 20px;
                font-weight: 300;
            }

            @keyframes spinner-y0fdc1 {
                0% {
                    transform: rotate(45deg) rotateX(-25deg) rotateY(25deg);
                }

                50% {
                    transform: rotate(45deg) rotateX(-385deg) rotateY(25deg);
                }

                100% {
                    transform: rotate(45deg) rotateX(-385deg) rotateY(385deg);
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
            ?>
            <!-- right side -->
            <div class="col-lg-10 offset-lg-2 offset-md-0 offset-sm-0 offset-0 p-5 mt-5 mt-lg-0">
                <div class="row">
                    <div class="col-12">
                        <p class="headings">Team Details</p><br>
                        <p class="sub_headings">Dashboard / Team Details</p>
                    </div>
                    <div class="col-lg-3">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_t">Add New Team Member</button>
                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <div class="row d-grid">
                        <div class="col-12 table-responsive">
                            <table id="example" class="display nowrap " style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">NIC</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Job Role</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $te_rs = Database::search("SELECT * FROM `team`");
                                    $te_num = $te_rs->num_rows;

                                    if ($te_num > 0) {
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
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- add suplier model start -->
        <div class="modal fade" id="add_t" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Team Member Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal_body">

                        <div id="formModel" class="form d-block">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label fw-bold">Member Name :</label>
                                    <input type="text" id="fname" class="form-control form-control-sm" placeholder="First Name :">
                                    <div class="input-group mt-3">
                                        <input type="text" class="form-control form-control-sm" placeholder="Last Name :" id="lname">

                                    </div>
                                    <label class="form-label fw-bold mt-3">Mobile :</label>
                                    <input type="text" id="mobile" class="form-control form-control-sm " placeholder="Mobile :">
                                    <label class="form-label fw-bold mt-3">Address:</label>
                                    <input type="text" id="address" class="form-control form-control-sm " placeholder="Address :">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold">Position :</label>
                                    <div id="po">
                                        <select id="position" class="form-control form-control-sm">
                                            <option value="00">Select Position :</option>
                                            <?php
                                            $trs = Database::search("SELECT * FROM `occupation`");
                                            $tnum = $trs->num_rows;
                                            for ($t = 0; $t < $tnum; $t++) {
                                                $tdata = $trs->fetch_assoc();

                                            ?>
                                                <option value="<?php echo $tdata["o_id"]; ?>"><?php echo $tdata["oname"]; ?></option>

                                            <?php
                                            }



                                            ?>


                                        </select>

                                    </div>

                                    <!-- add new position type -->
                                    <div class="col-12 d-flex mt-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" id="newPostion" placeholder="Enter New Position">
                                            <button class="btn btn-sm btn-success" id="add" onclick="addNewPosition();">Add</button>
                                        </div>
                                    </div>
                                    <label class="form-label fw-bold mt-3">NIC :</label>
                                    <input type="text" id="nic" class="form-control form-control-sm" placeholder="nic">
                                    <label class="form-label fw-bold mt-3">Status :</label>
                                    <select name="" id="status" class="form-control form-control-sm">

                                        <?php
                                        $srs = Database::search("SELECT * FROM `member_status`");
                                        $snum = $srs->num_rows;
                                        for ($g = 0; $g < $snum; $g++) {
                                            $sdata = $srs->fetch_assoc();

                                        ?>
                                            <option value="<?php echo $sdata["ms_id"]; ?>"><?php echo $sdata["tsname"]; ?></option>

                                        <?php
                                        }



                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="lodingModel" class="d-none  d-flex flex-column justify-content-center  align-items-center p-5">



                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="addMember();">Add Member</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- seccond model view team member details -->

        <div class="modal fade" id="view_t" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Team Member details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="view_m">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="updateMember();">Update</button>
                        <button type="button" class="btn btn-primary" onclick="updateSalary();">Add Salary</button>
                    </div>
                </div>
            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/script.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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