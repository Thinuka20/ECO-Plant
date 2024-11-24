<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .footer {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
    </style>
</head>

<body>

</body>

</html>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-md-block d-lg-none d-sm-block d-block footer">
    <div class="container">
        <h5 class="pt-2 ps-2 mt-2" style="color: white;"><span style="color: #07c06a ; ">Eco </span>Plant & Energy <span style="color: gray ; font-size: 18px; font-weight: bold; ">(Pvt) Ltd.</span></h5>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 myul">
                <?php
                $us_data = isset($_SESSION["user"]) ? $_SESSION["user"] : (isset($_SESSION["user2"]) ? $_SESSION["user2"] : null);
                if ($us_data && $us_data["user_status_id"] == "1") {
                ?>
                    <li class="list-group-item mb-4 mt-5 "><a href="dashboard.php" class="text-decoration-none">Dashboard<i class="fas fa-arrow-right"></i> </a></li>
                    <li class="list-group-item mb-4  "><a href="stock.php" class="text-decoration-none ">Stock Details<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="supplier.php" class="text-decoration-none ">Supplier Details<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="customer.php" class="text-decoration-none ">Customer Details<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="team.php" class="text-decoration-none ">Team Members Details<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="invoice.php" class="text-decoration-none ">Invoices<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="expenses.php" class="text-decoration-none ">Expenses<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="comingsoon.php" class="text-decoration-none ">Monthly Salary<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 mt-5  "><a href="#" class="text-decoration-none  sinout " onclick="signOut();"><i class="fas fa-arrow-left"></i> Sign Out</a></li>
                <?php
                } else {
                    ?>
                    <li class="list-group-item mb-4  "><a href="stock.php" class="text-decoration-none ">Stock Details<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="supplier.php" class="text-decoration-none ">Supplier Details<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="customer.php" class="text-decoration-none ">Customer Details<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="invoice.php" class="text-decoration-none ">Invoices<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 "><a href="expenses.php" class="text-decoration-none ">Expenses<i class="fas fa-arrow-right"></i></a></li>
                    <li class="list-group-item mb-4 mt-5  "><a href="#" class="text-decoration-none  sinout " onclick="signOut();"><i class="fas fa-arrow-left"></i> Sign Out</a></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>