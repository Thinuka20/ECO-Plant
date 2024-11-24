<?php
session_start();
include "connection.php";
if (isset($_SESSION["user"]) || isset($_SESSION["user2"])) {


    // Query to fetch limited records from the database
    $irs = Database::search("SELECT * FROM `invoice` INNER JOIN `customer` ON `invoice`.`customer_id` = `customer`.`customer_id` ORDER BY `date` DESC");
    $in = $irs->num_rows;

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Eco Plant & Energy (Pvt) Ltd | Customers</title>
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
                        <p class="headings">Customers Details</p><br>
                        <p class="sub_headings">Dashboard / Customers Details</p>
                    </div>
                </div>

                <div class="container-fluid mt-2">
                    <div class="row d-grid">
                        <div class="col-12 table-responsive">
                            <table id="example" class="display nowrap " style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Purchasing Date</th>
                                        <th scope="col">Paid Amount</th>
                                        <th scope="col">Due Amount</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($in > 0) {
                                        while ($id = $irs->fetch_assoc()) {
                                            $totalpaid = 0;
                                            $cprs = Database::search("SELECT * FROM `customer_payments` WHERE `customer_id` = '" . $id["customer_id"] . "'");
                                            $cpn = $cprs->num_rows;
                                            if ($cpn > 0) {
                                                while ($cpd = $cprs->fetch_assoc()) {
                                                    $totalpaid += $cpd['amount'];
                                                }
                                            }
                                            $totaldue = $id["sub_total"] - $totalpaid;

                                            $in_no = $id['invoice_id'];
                                            if (strlen($in_no) == 1) {
                                                $invoice_no = ' EPS/IN/000' . $id['invoice_id'];
                                            } else if (strlen($in_no) == 2) {
                                                $invoice_no = ' EPS/IN/00' . $id['invoice_id'];
                                            } else if (strlen($in_no) == 3) {
                                                $invoice_no = ' EPS/IN/0' . $id['invoice_id'];
                                            } else if (strlen($in_no) == 4) {
                                                $invoice_no = ' EPS/IN/' . $id['invoice_id'];
                                            }
                                    ?>

                                            <tr>
                                                <th scope="row"><?php echo $invoice_no; ?></th>
                                                <td><?php echo $id["f_name"]; ?></td>
                                                <td><?php echo $id["l_name"]; ?></td>
                                                <td><?php echo $id["mobile"]; ?></td>
                                                <td><?php echo $id["address"]; ?></td>
                                                <td>Rs.<?php echo $id["sub_total"]; ?>.00</td>
                                                <td><?php echo $id["date"]; ?></td>
                                                <td>Rs.<?php echo $totalpaid ?>.00</td>
                                                <td>Rs.<?php echo $totaldue ?>.00</td>
                                                <td><button class="btn btn-success" onclick="customerDetails(<?php echo $id['invoice_id']; ?>);">View</button></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='10'>No records found</td></tr>";
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
        <div class="modal fade" id="view_c" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Customer Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal_body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" onclick="customerInvoice();" data-bs-target="#view_c_print">Print Invoice</button>
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