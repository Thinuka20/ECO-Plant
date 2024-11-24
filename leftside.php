<?php









?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="col-lg-2 position-fixed d-md-none d-lg-block d-sm-none d-none" style="height: 100%; background-color: #282929;" id="left">
        <div class="ms-3" style=" height: 87vh; border-right: .5px solid #07c06a;">
            <div class="col-9">
                <h5 class="p-2 mt-4" style="color: white;"><span style="color: #07c06a ; ">Eco </span>Plant & Energy <span style="color: gray ; font-size: 18px; font-weight: bold; ">(Pvt) Ltd.</span></h5>
            </div>
            <ul class="form-label myul">
                <?php
                $us_data = isset($_SESSION["user"]) ? $_SESSION["user"] : (isset($_SESSION["user2"]) ? $_SESSION["user2"] : null);
                if ($us_data && $us_data["user_status_id"] == "1") {
                ?>
                    <li class="list-group-item mb-4 mt-5 "><a href="dashboard.php" class="text-decoration-none">Dashboard <i class="fas fa-arrow-right"></i> </a></li>
                    <li class="list-group-item mb-4  "><a href="stock.php" class="text-decoration-none ">Stock Details <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="supplier.php" class="text-decoration-none ">Supplier Details <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="customer.php" class="text-decoration-none ">Customer Details <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="team.php" class="text-decoration-none ">Team Member Details <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="invoice.php" class="text-decoration-none ">Invoices <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="expenses.php" class="text-decoration-none ">Expenses <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="comingsoon.php" class="text-decoration-none ">Monthly Salary <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 mt-5  " onclick="signOut();"><a href="#" class="text-decoration-none  sinout "><i class="fas fa-arrow-left"></i> Sign Out</a></li>
                <?php
                } else {
                ?>
                    <li class="list-group-item mb-4  mt-5 "><a href="stock.php" class="text-decoration-none ">Stock Details <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="supplier.php" class="text-decoration-none ">Supplier Details <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="customer.php" class="text-decoration-none ">Customer Details <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="invoice.php" class="text-decoration-none ">Invoices <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="expenses.php" class="text-decoration-none ">Expenses <i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 mt-5  " onclick="signOut();"><a href="#" class="text-decoration-none  sinout "><i class="fas fa-arrow-left"></i> Sign Out</a></li>
                <?php
                }
                ?>
            </ul>
        </div>
        <div>
            <div class="row">
                <div class="col-3 d-flex justify-content-center align-items-lg-start">
                    <div class="pro-img ms-3 mt-1 col-3">
                        <img src="resourses/smp.png" alt="" width="auto" height="40px" style="border-radius: 30%;">
                    </div>
                </div>
                <div class="col-9 d-flex flex-column  align-items-start">
                    <h6 class="text-light mb-0"><?php echo $us_data["email"]; ?></h6>
                    <small class="text-light mt-0 me-2"><?php echo $us_data["fname"] . ' ' . $us_data["lname"]; ?></small>
                    <?php if ($us_data && $us_data["user_status_id"] == "1") { ?>
                        <span class="badge rounded-pill bg-warning text-dark align-items-start mt-1">Admin</span>
                    <?php } else { ?>
                        <span class="badge rounded-pill bg-warning text-dark align-items-start mt-1">User</span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js" defer></script>

</body>

</html>