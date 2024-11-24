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

        <title>Eco Plant & Energy (Pvt) Ltd | Expenses</title>

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
                        <p class="headings">Expenses Details</p><br>
                        <p class="sub_headings">Dashboard / Expenses Details</p>
                    </div>
                </div>
                <div class="content">
                    <div class="row mt-3">
                        <div class="col-lg-8">
                            <p class="form-label">Select Expenses Type :</p>
                            <div class="col-lg-6">
                                <select name="expenses_combo" id="expenses_type" class="form-control">
                                    <option value="00">Select</option>
                                    <?php

                                    $e_rs = Database::search("SELECT * FROM `expense_type`");
                                    $e_nums = $e_rs->num_rows;
                                    if ($e_nums > 0) {
                                        for ($o = 0; $o < $e_nums; $o++) {
                                            $e_data = $e_rs->fetch_assoc();
                                    ?>
                                            <option value="<?php echo $e_data["et_id"] ?>"><?php echo $e_data["name"] ?></option>


                                    <?php



                                        }
                                    } else {
                                    }


                                    ?>

                                </select>

                            </div>
                            <div class="row">
                                <div class="col-lg-3 mt-4">
                                    <p class="form-label">Amount :</p>
                                    <div class="input-group">
                                        <label for="" class="input-group-text">Rs.</label>
                                        <input type="number" id="amount" min=0 class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-3 mt-4">
                                    <p class="form-label">Date :</p>
                                    <input type="date" id="date_ex" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-center mt-4">
                                <div class="col-4 d-grid">
                                    <button class="btn btn-success" onclick="addexpenses();">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <div class="row d-grid">
                        <div class="col-12 table-responsive">
                            <table id="example" class="display nowrap " style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Expenses Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $ers = Database::search("SELECT * FROM `expenses` INNER JOIN `expense_type` ON `expenses`.`expense_type_id` = `expense_type`.`et_id` ORDER BY `date` DESC");
                                    $en = $ers->num_rows;
                                    if ($en > 0) {
                                        for ($i = 0; $i < $en; $i++) {
                                            $ed = $ers->fetch_assoc();
                                    ?>

                                            <tr>
                                                <th scope="row"><?php echo $ed['expenses_id'] ?></th>
                                                <td><?php echo $ed['name'] ?></td>
                                                <td>Rs.<?php echo $ed['amount'] ?>.00</td>
                                                <td><?php echo $ed['date'] ?></td>
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