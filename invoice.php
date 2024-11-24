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

    <title>Eco Plant & Energy (Pvt) Ltd | Invoices</title>

    <link rel="icon" type="image/x-icon" href="resourses/lo.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
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
    </style>
</head>

<body style="overflow-x: hidden;">
    <div id="loading-animation">
        <div class="spinner"></div>
    </div>
    <?php
    $invo_no = 1;
    $invoice_no= "";
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
                    <p class="headings">Invoice Details</p><br>
                    <p class="sub_headings">Dashboard / Invoice Details</p>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label fw-bold mt-3">Invoice No:</label>
                            <?php
                            $inrs = Database::search("SELECT `invoice_id` FROM `invoice` ORDER BY `invoice_id` DESC LIMIT 1");
                            $inn = $inrs->num_rows;
                            if ($inn > 0) {
                                $ind = $inrs->fetch_assoc();
                                $invo_no = $invo_no + $ind['invoice_id'];
                            }

                            ?>
                            <input type="text" class="form-control form-control-sm" id="invoiceno" value="<?php echo $invo_no ?>" disabled>
                            <label class="form-label fw-bold mt-3">Select Agent</label>
                            <select name="select_product" id="agent" class="form-control form-control-sm">
                                <option value="00">Select Agent</option>
                                <?php

                                $trs = Database::search("SELECT * FROM `team`");
                                $tn = $trs->num_rows;
                                if ($tn > 0) {
                                    for ($a = 0; $a < $tn; $a++) {
                                        $td = $trs->fetch_assoc();
                                ?>
                                        <option value="<?php echo $td["team_id"] ?>"><?php echo $td["f_name"] ?> <?php echo $td["l_name"] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-bold mt-3">First Name:</label>
                            <input type="text" class="form-control form-control-sm" id="fname" placeholder="First Name">
                            <label class="form-label fw-bold mt-3">Last Name:</label>
                            <input type="text" class="form-control form-control-sm" id="lname" placeholder="Last Name">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-bold mt-3">Address:</label>
                            <input type="text" class="form-control form-control-sm" id="address" placeholder="Address">
                            <label class="form-label fw-bold mt-3">Mobile:</label>
                            <input type="text" class="form-control form-control-sm" id="mobile" placeholder="Mobile">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-bold mt-3">NIC:</label>
                            <input type="text" class="form-control form-control-sm" id="nic" placeholder="NIC">
                        </div>
                        <hr class="mt-4 border-success" />
                        <div class="col-lg-3">
                            <label class="form-label fw-bold mt-3">System Capacity:</label>
                            <input type="text" class="form-control form-control-sm" id="sc" placeholder="ex : 5kW / 10kW">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-bold mt-3">System Price:</label>
                            <input type="number" min=0 class="form-control form-control-sm" id="sp" onkeyup="updateTotal();" placeholder="Ex :4000000">
                        </div>
                        <div class="col-lg-3">
                            <div class="pay_status">
                                <label class="form-label fw-bold mt-3">Payment Status:</label>
                                <select name="" id="pay_status" class="form-control form-control-sm" onchange="payOption();">
                                    <option value="02">Unpaid</option>
                                    <option value="01">Paid</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-none" id="paySelect">
                            <label class="form-label fw-bold mt-3">Payed Amount:</label>
                            <input type="text" class="form-control form-control-sm" id="amount" placeholder="Payed Amount">
                        </div>

                        <!-- discount row -->
                        <div class="col-lg-3">
                            <label class="form-label fw-bold mt-3">Discount :</label>
                            <input type="text" class="form-control form-control-sm" id="ds" onkeyup="updateTotal();" value="0">
                        </div>
                        <div class="col-lg-3" id="ds">
                            <label class="form-label fw-bold mt-3">Discounted Price :</label>
                            <input disabled type="text" class="form-control form-control-sm" id="damount" placeholder="Payed Amount">
                        </div>
                        <div class="col-lg-3">
                            <div class="pay_method d-none" id="pay_method">
                                <label class="form-label fw-bold mt-3">Payment Method:</label>
                                <select name="" id="pay_method2" class="form-control form-control-sm" onchange="payMethod();">
                                    <option value="02">Cash</option>
                                    <option value="01">Cheque</option>
                                    <option value="03">Bank Transfer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 d-none" id="cnn">
                            <label class="form-label fw-bold mt-3 ">Identification :</label>
                            <input type="text" class="form-control form-control-sm" id="idn" placeholder="Cheque number">
                        </div>
                        <div class="but mt-2 d-flex justify-content-end">
                            <div class="col-lg-2 d-grid">
                                <button class="btn btn-outline-dark" onclick="addinProduct();">Print Invoice</button>
                            </div>
                        </div>
                        <div class="mt-5 table-responsive">
                            <table id="intable" class="table  table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Product ID</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $inrs2 = Database::search("SELECT * FROM `product` GROUP BY `product_name` ORDER BY `product_id` ASC");
                                    $inn2 = $inrs2->num_rows;
                                    $b = 0;
                                    if ($inn2 > 0) {
                                        for ($z = 0; $z < $inn2; $z++) {
                                            $ind2 = $inrs2->fetch_assoc();
                                            $b = $b + 1;
                                    ?>
                                            <tr id="productRow<?php echo $ind2['product_id']; ?>">
                                                <th scope="row"><?php echo $ind2['product_id']; ?></th>
                                                <td><?php echo $ind2['product_name'] ?></td>
                                                <td><input type="number" class="qty text-center" value="0" id="<?php echo $z + 1 ?>"></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="but mt-2 d-flex justify-content-end">
                            <div class="col-lg-2 d-grid">
                                <button class="btn btn-outline-dark" onclick="updatePayment();">Update Stock</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.addEventListener('load', function() {
                var loadingAnimation = document.getElementById('loading-animation');
                loadingAnimation.style.display = 'none';
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="script.js"></script>
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