<?php
session_start();

include "connection.php";
if (isset($_SESSION["user"]) || isset($_SESSION["user2"])) {

    if (isset($_GET['invoice_id'])) {
        $invoice_id = $_GET['invoice_id'];
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
                                <?php
                                $rs = Database::search("SELECT * FROM `invoice` INNER JOIN `customer` ON `customer`.`customer_id`=`invoice`.`customer_id` WHERE `invoice_id` = '" . $invoice_id . "'");
                                $n = $rs->num_rows;
                                $agentOptions = "";
                                if ($n > 0) {
                                    $d = $rs->fetch_assoc();

                                    $trs = Database::search("SELECT * FROM `team`");
                                    $prs = Database::search("SELECT * FROM `payment_status`");
                                    $pnum = $prs->num_rows;

                                    $statusIsActive = $d["payment_status_id"] == '1';

                                    while ($tdata = $trs->fetch_assoc()) {
                                        // Check if the current occupation matches the team member's occupation
                                        $selected = ($d["team_id"] == $tdata["team_id"]) ? 'selected' : '';
                                        $agentOptions .= "<option value='{$tdata["team_id"]}' {$selected}>{$tdata["f_name"]} {$tdata["l_name"]}</option>";
                                    }



                                ?>
                                    <div class="col-lg-3">
                                        <label class="form-label fw-bold mt-3">Invoice No:</label>
                                        <input type="text" class="form-control form-control-sm" id="invoiceno" value="<?php echo $d['invoice_id'] ?>" disabled>
                                        <label class="form-label fw-bold mt-3">Select Agent</label>
                                        <select disabled name="select_product" id="agent" class="form-control form-control-sm">
                                            <option>Select Agent</option>
                                            <?php echo $agentOptions; // Echo all occupation options 
                                            ?>


                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label fw-bold mt-3">First Name:</label>
                                        <input disabled type="text" class="form-control form-control-sm" id="fname" value="<?php echo $d['f_name'] ?>" placeholder="First Name">
                                        <label class="form-label fw-bold mt-3">Last Name:</label>
                                        <input disabled type="text" class="form-control form-control-sm" id="lname" value="<?php echo $d['l_name'] ?>" placeholder="Last Name">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label fw-bold mt-3">Address:</label>
                                        <input disabled type="text" class="form-control form-control-sm" id="address" value="<?php echo $d['address'] ?>" placeholder="Address">
                                        <label class="form-label fw-bold mt-3">Mobile:</label>
                                        <input disabled type="text" class="form-control form-control-sm" id="mobile" value="<?php echo $d['mobile'] ?>" placeholder="Mobile">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label fw-bold mt-3">NIC:</label>
                                        <input disabled type="text" class="form-control form-control-sm" id="nic" value="<?php echo $d['nic'] ?>" placeholder="NIC">
                                    </div>
                                    <hr class="mt-4 border-success" />
                                    <div class="col-lg-3">
                                        <label class="form-label fw-bold mt-3">System Capacity:</label>
                                        <input disabled type="text" class="form-control form-control-sm" id="sc" value="<?php echo $d['system_capacity'] ?>" placeholder="ex : 5kW / 10kW">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label fw-bold mt-3">System Price:</label>
                                        <input disabled type="number" min=0 class="form-control form-control-sm" id="sp" value="<?php echo $d['i_amount'] ?>" onkeyup="updateTotal();" placeholder="Ex :4000000">
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
                                        <input disabled type="text" class="form-control form-control-sm" id="ds" value="<?php echo $d['discount'] ?>" onkeyup="updateTotal();" value="0">
                                    </div>
                                    <div class="col-lg-3" id="ds">
                                        <label class="form-label fw-bold mt-3">Discounted Price :</label>
                                        <input disabled type="text" class="form-control form-control-sm" id="damount" value="<?php echo $d['sub_total'] ?>" placeholder="Payed Amount">
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
                                <?php
                                }
                                ?>
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
    }
} else {
    ?>
    <script>
        window.location.href = "index.php";
    </script>
<?php
}
?>