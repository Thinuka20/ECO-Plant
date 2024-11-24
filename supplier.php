<?php
session_start();

include "connection.php";
if (isset($_SESSION["user"]) || isset($_SESSION["user2"])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Eco Plant & Energy (Pvt) Ltd | Suppliers</title>
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

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }
        </style>
    </head>






    <body style="overflow-x: hidden;">
        <?php
        require "navbar.php";
        $srs = Database::search("SELECT * FROM `supplier` ORDER BY `supplier_id` ASC");
        $sn = $srs->num_rows;

        ?>
        <div id="loading-animation">
            <div class="spinner"></div>
        </div>
        <div class="row">
            <!-- left side -->
            <?php
            require "leftside.php";
            ?>
            <!-- right side -->
            <div class="col-lg-10 offset-lg-2 offset-md-0 offset-sm-0 offset-0 p-5 mt-5 mt-lg-0">
                <div class="row">
                    <div class="col-12">
                        <p class="headings">Supplier Details</p><br>
                        <p class="sub_headings">Dashboard / Supplier Details</p>
                    </div>
                    <div class="col-lg-3">
                        <button class="btn btn-success" onclick="openModelS();">Add New Supplier</button>
                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <div class="row d-grid">
                        <div class="col-12 table-responsive">
                            <table id="example" class="display nowrap " style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Supplier Name</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Total Payments</th>
                                        <th scope="col">Paid Amount</th>
                                        <th scope="col">Due Payments</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

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
                                                <td>Rs.<?php echo $totalprice ?>.00</td>
                                                <td>Rs.<?php echo $totalpaid ?>.00</td>
                                                <td>Rs.<?php echo $totaldue ?>.00</td>
                                                <td><button class="btn btn-success" onclick="supdetails(<?php echo $sd['supplier_id'] ?>);">View</button></td>
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

        <!-- model start -->
        <div class="modal fade" id="sup_details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Supplier Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal_body">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#view_c_print" onclick="addSPayment();">Add New Payment</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- seccond model -->

        <div class="modal fade" id="view_c_print" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">New Payment</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="model_add_pay">
                        <div class="row">


                            <div class="col-12 d-flex flex-column">
                                <label class="form-label fw-bold mt-2">Due Amount:</label>
                                <label class="form-label" id="due_02_add_pay">Rs. 100000</label>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label fw-bold mt-2">New Payment:</label>

                            <div class="input-group">
                                <label class="input-group-text">Rs.</label>
                                <input type="text" class="form-control form-control-sm" id="amount_s">
                            </div>
                        </div>


                    </div>
                    <div class="d-none" id="model_add_pay_lo">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="addPay();">Add Payment</button>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="add_supplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Supplier</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-block" id="mbody">
                        <div class="row">
                            <div class="col-6 d-flex flex-column">
                                <label class="form-label fw-bold mt-2">Supplier Name :</label>
                                <input type="text" class="form-control form-control-sm" id="s_name">
                            </div>
                            <div class="col-6 d-flex flex-column">
                                <label class="form-label fw-bold mt-2">Mobile :</label>
                                <input type="text" class="form-control form-control-sm" id="s_mobile">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label fw-bold mt-2">Address :</label>
                                <input type="text" class="form-control form-control-sm" id="s_address">
                            </div>
                        </div>
                    </div>
                    <div class="d-none" id="add_new_sm">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="addNewSupplier();">Add</button>
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