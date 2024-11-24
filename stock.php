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
        <title>Eco Plant & Energy (Pvt) Ltd | Stock</title>
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

        // Fetch data for current page
        $prs = Database::search("SELECT product.product_name, SUM(product.qty) AS total_quantity
        FROM `product`
        GROUP BY product.product_name");
        $pn = $prs->num_rows;
        ?>

        <?php require "navbar.php"; ?>
        <div id="loading-animation">
            <div class="spinner"></div>
        </div>

        <div class="row">
            <!-- left side -->
            <?php require "leftside.php"; ?>
            <!-- right side -->
            <div class="col-lg-10 offset-lg-2 offset-md-0 offset-sm-0 offset-0 p-5 mt-5 mt-lg-0">
                <div class="row">
                    <div class="col-12">
                        <p class="headings">Stock Details</p><br>
                        <p class="sub_headings">Dashboard / Stock Details</p>
                    </div>
                    <div class="col-lg-3">
                        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addStock">Add New Stock</button>
                    </div>
                </div>



                <div class="container-fluid mt-2">
                    <div class="row d-grid">
                        <div class="col-12 table-responsive">


                            <table id="example" class="display nowrap " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Suppliers</th>
                                        <th>Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($pn > 0) {
                                        $a = 0;
                                        while ($pd = $prs->fetch_assoc()) {
                                            $a = $a + 1;
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo $a ?></th>
                                                <td><?php echo $pd['product_name'] ?></td>
                                                <td><?php echo $pd['total_quantity'] ?></td>
                                                <td><?php
                                                    $srs = Database::search("SELECT * FROM `product` INNER JOIN `supplier` ON `product`.`supplier_id` = `supplier`.`supplier_id` WHERE `product_name` = '" . $pd['product_name'] . "' ORDER BY `date` DESC");
                                                    $sn = $srs->num_rows;
                                                    if ($sn > 0) {
                                                        while ($sd = $srs->fetch_assoc()) {
                                                            echo $sd['s_name'] . ' | ';
                                                        }
                                                    }
                                                    ?></td>
                                                <td><?php
                                                    $srs2 = Database::search("SELECT * FROM `product` INNER JOIN `supplier` ON `product`.`supplier_id` = `supplier`.`supplier_id` WHERE `product_name` = '" . $pd['product_name'] . "' ORDER BY `date` DESC");
                                                    $sn2 = $srs->num_rows;
                                                    if ($sn2 > 0) {
                                                        $sd2 = $srs2->fetch_assoc();
                                                        echo $sd2['date'];
                                                    }
                                                    ?></td>
                                            </tr>
                                    <?php }
                                    } ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Model Start -->
        <div class="modal fade" tabindex="-1" id="addStock">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-block" id="add_s_m">
                        <div class="form">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label fw-bold">Product Name :</label>
                                    <select id="product" class="form-control form-control-sm" onchange="changSupplier();">
                                        <option value="00">Select Product</option>

                                        <?php

                                        $p_rs = Database::search("SELECT * FROM `product` ORDER BY `product_name` ASC");
                                        $p_nums = $p_rs->num_rows;
                                        if ($p_nums > 0) {
                                            for ($p = 0; $p < $p_nums; $p++) {
                                                $p_data = $p_rs->fetch_assoc();
                                        ?>
                                                <option value="<?php echo $p_data["product_id"] ?>"><?php echo $p_data["product_name"] ?></option>


                                        <?php



                                            }
                                        } else {
                                        }


                                        ?>

                                    </select>
                                    <div class="input-group mt-3">
                                        <input type="text" class="form-control form-control-sm" placeholder="Enter New Product Name" id="newProduct">

                                    </div>
                                    <label class="form-label fw-bold mt-3">Price :</label>
                                    <input type="text" id="price" class="form-control form-control-sm " placeholder="Price">
                                    <label class="form-label fw-bold mt-3">Quantity :</label>
                                    <input type="number" id="qty" class="form-control form-control-sm " placeholder="Quantity" min=0>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold">Supplier Name:</label>
                                    <select id="supplier" class="form-control form-control-sm">
                                        <option value="00">Select supplier</option>
                                        <?php

                                        $s_rs = Database::search("SELECT * FROM `supplier`");
                                        $s_nums = $s_rs->num_rows;
                                        if ($s_nums > 0) {
                                            for ($s = 0; $s < $s_nums; $s++) {
                                                $s_data = $s_rs->fetch_assoc();
                                        ?>
                                                <option value="<?php echo $s_data["supplier_id"] ?>"><?php echo $s_data["s_name"] ?></option>


                                        <?php



                                            }
                                        } else {
                                        }


                                        ?>

                                    </select>
                                    <!-- add new supplier section (button start) -->
                                    <label class="form-label fw-bold mt-3">Date :</label>
                                    <input type="Date" id="dateS" class="form-control form-control-sm " placeholder="Date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none" id="loding_mo">
                        <div class="row">
                            <div class="col-12">
                                <div class="spinner2 ms-4 mt-5">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div><br>
                                <div>
                                    <h5 class="textP mt-2 mb-5">Please Wait...</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addNewStock();">Add Product</button>
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