<?php
session_start();
include "connection.php";
if (isset($_SESSION["user"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Control Panel | Eco Plant & Energy</title>
        <link rel="icon" type="image/x-icon" href="resourses/lo.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <style>
            .nav-tabs .nav-link {
                color: #333;
                border: 1px solid #dee2e6;
                margin-right: 5px;
                border-radius: 5px 5px 0 0;
            }

            .nav-tabs .nav-link.active {
                background-color: #007bff;
                color: white;
                border-color: #007bff;
            }

            .tab-pane {
                padding: 20px;
                border: 1px solid #dee2e6;
                border-top: none;
                border-radius: 0 0 5px 5px;
            }

            .action-buttons .btn {
                margin-right: 5px;
            }
        </style>
    </head>

    <body>
        <?php require "navbar.php"; ?>

        <div class="row">
            <?php require "leftside.php"; ?>

            <!-- Main Content -->
            <div class="col-lg-10 offset-lg-2 p-4">
                <div class="container">
                    <!-- Header -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h2 class="headings">Admin Control Panel</h2><br>
                            <p class="sub_headings">Manage All System Data</p>
                        </div>
                    </div>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="controlTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="customers-tab" data-bs-toggle="tab" href="#customers" role="tab">
                                <i class="fas fa-users"></i> Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="team-tab" data-bs-toggle="tab" href="#team" role="tab">
                                <i class="fas fa-user-tie"></i> Team
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="products-tab" data-bs-toggle="tab" href="#products" role="tab">
                                <i class="fas fa-box"></i> Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="suppliers-tab" data-bs-toggle="tab" href="#suppliers" role="tab">
                                <i class="fas fa-truck"></i> Suppliers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="expenses-tab" data-bs-toggle="tab" href="#expenses" role="tab">
                                <i class="fas fa-money-bill"></i> Expenses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="invoices-tab" data-bs-toggle="tab" href="#invoices" role="tab">
                                <i class="fas fa-file-invoice"></i> Invoices
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="controlTabContent">
                        <!-- Customers Tab -->
                        <div class="tab-pane fade show active" id="customers" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="customerSearch" class="form-control" placeholder="Search customers...">
                                        <button class="btn btn-primary" onclick="searchCustomers()">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success w-100" onclick="showAddCustomer()">
                                        <i class="fas fa-plus"></i> Add New Customer
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>System Capacity</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customerTableBody">
                                        <?php
                                        $query = Database::search("SELECT * FROM customer ORDER BY customer_id DESC");
                                        while ($row = $query->fetch_assoc()) {
                                            echo "<tr>
                                            <td>{$row['customer_id']}</td>
                                            <td>{$row['f_name']} {$row['l_name']}</td>
                                            <td>{$row['mobile']}</td>
                                            <td>{$row['address']}</td>
                                            <td>{$row['system_capacity']}</td>
                                            <td class='action-buttons'>
                                                <button class='btn btn-primary btn-sm' onclick='editCustomer({$row['customer_id']})'>
                                                    <i class='fas fa-edit'></i>
                                                </button>
                                                <button class='btn btn-danger btn-sm' onclick='deleteCustomer({$row['customer_id']})'>
                                                    <i class='fas fa-trash'></i>
                                                </button>
                                                <button class='btn btn-info btn-sm' onclick='viewCustomerDetails({$row['customer_id']})'>
                                                    <i class='fas fa-eye'></i>
                                                </button>
                                            </td>
                                        </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Other tabs similar structure -->
                        <div class="tab-pane fade" id="team" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="teamSearch" class="form-control" placeholder="Search team members...">
                                        <button class="btn btn-primary" onclick="searchTeam()">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success w-100" onclick="showAddTeam()">
                                        <i class="fas fa-plus"></i> Add New Team Member
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>NIC</th>
                                            <th>Address</th>
                                            <th>Occupation</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="teamTableBody">
                                        <?php
                                        $query = Database::search("SELECT t.*, o.oname, ms.tsname 
                    FROM team t 
                    INNER JOIN occupation o ON t.occupation_id = o.o_id 
                    INNER JOIN member_status ms ON t.member_status_id = ms.ms_id 
                    ORDER BY t.team_id DESC");

                                        while ($row = $query->fetch_assoc()) {
                                            $statusClass = ($row['member_status_id'] == 1) ? 'success' : 'warning';

                                            echo "<tr>
                        <td>{$row['team_id']}</td>
                        <td>{$row['f_name']} {$row['l_name']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['nic']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['oname']}</td>
                        <td><span class='badge bg-{$statusClass}'>{$row['tsname']}</span></td>
                        <td class='action-buttons'>
                            <button class='btn btn-primary btn-sm' onclick='editTeam({$row['team_id']})'>
                                <i class='fas fa-edit'></i>
                            </button>
                            <button class='btn btn-danger btn-sm' onclick='deleteTeam({$row['team_id']})'>
                                <i class='fas fa-trash'></i>
                            </button>
                            <button class='btn btn-info btn-sm' onclick='viewTeamDetails({$row['team_id']})'>
                                <i class='fas fa-eye'></i>
                            </button>
                        </td>
                    </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Products Tab Content -->
                        <div class="tab-pane fade" id="products" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="productSearch" class="form-control" placeholder="Search products...">
                                        <button class="btn btn-primary" onclick="searchProducts()">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success w-100" onclick="showAddProduct()">
                                        <i class="fas fa-plus"></i> Add New Product
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Date</th>
                                            <th>Supplier</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody">
                                        <?php
                                        $query = Database::search("SELECT p.*, s.s_name FROM product p 
                    LEFT JOIN supplier s ON p.supplier_id = s.supplier_id 
                    ORDER BY p.product_id DESC");

                                        while ($row = $query->fetch_assoc()) {
                                            echo "<tr>
                        <td>{$row['product_id']}</td>
                        <td>{$row['product_name']}</td>
                        <td>Rs.{$row['price']}.00</td>
                        <td>{$row['qty']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['s_name']}</td>
                        <td class='action-buttons'>
                            <button class='btn btn-primary btn-sm' onclick='editProduct({$row['product_id']})'>
                                <i class='fas fa-edit'></i>
                            </button>
                            <button class='btn btn-danger btn-sm' onclick='deleteProduct({$row['product_id']})'>
                                <i class='fas fa-trash'></i>
                            </button>
                            <button class='btn btn-warning btn-sm' onclick='updateStock({$row['product_id']})'>
                                <i class='fas fa-boxes'></i>
                            </button>
                        </td>
                    </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Suppliers Tab Content -->
                        <div class="tab-pane fade" id="suppliers" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="supplierSearch" class="form-control" placeholder="Search suppliers...">
                                        <button class="btn btn-primary" onclick="searchSuppliers()">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success w-100" onclick="showAddSupplier()">
                                        <i class="fas fa-plus"></i> Add New Supplier
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>Total Products</th>
                                            <th>Total Due</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="supplierTableBody">
                                        <?php
                                        $query = Database::search("SELECT * FROM supplier ORDER BY supplier_id DESC");

                                        while ($row = $query->fetch_assoc()) {
                                            // Calculate total products
                                            $products = Database::search("SELECT COUNT(*) as total FROM product WHERE supplier_id = '{$row['supplier_id']}'");
                                            $productsCount = $products->fetch_assoc()['total'];

                                            // Calculate total due
                                            $totalDue = 0;
                                            $payments = Database::search("SELECT SUM(amount) as paid FROM supplier_payments WHERE supplier_id = '{$row['supplier_id']}'");
                                            $productCosts = Database::search("SELECT SUM(price * qty) as total FROM product WHERE supplier_id = '{$row['supplier_id']}'");

                                            $paid = $payments->fetch_assoc()['paid'] ?? 0;
                                            $total = $productCosts->fetch_assoc()['total'] ?? 0;
                                            $totalDue = $total - $paid;

                                            echo "<tr>
                        <td>{$row['supplier_id']}</td>
                        <td>{$row['s_name']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['address']}</td>
                        <td>{$productsCount}</td>
                        <td>Rs.{$totalDue}.00</td>
                        <td class='action-buttons'>
                            <button class='btn btn-primary btn-sm' onclick='editSupplier({$row['supplier_id']})'>
                                <i class='fas fa-edit'></i>
                            </button>
                            <button class='btn btn-danger btn-sm' onclick='deleteSupplier({$row['supplier_id']})'>
                                <i class='fas fa-trash'></i>
                            </button>
                            <button class='btn btn-info btn-sm' onclick='viewSupplierDetails({$row['supplier_id']})'>
                                <i class='fas fa-eye'></i>
                            </button>
                            <button class='btn btn-success btn-sm' onclick='addPayment({$row['supplier_id']})'>
                                <i class='fas fa-dollar-sign'></i>
                            </button>
                        </td>
                    </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Expenses Tab Content -->
                        <div class="tab-pane fade" id="expenses" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="expenseSearch" class="form-control" placeholder="Search expenses...">
                                        <button class="btn btn-primary" onclick="searchExpenses()">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success w-100" onclick="showAddExpense()">
                                        <i class="fas fa-plus"></i> Add New Expense
                                    </button>
                                </div>
                            </div>

                            <!-- Expense Summary Cards -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Daily Expenses</h6>
                                            <?php
                                            $today = date('Y-m-d');
                                            $daily = Database::search("SELECT SUM(amount) as total FROM expenses WHERE DATE(date) = '$today'");
                                            $dailyTotal = $daily->fetch_assoc()['total'] ?? 0;
                                            ?>
                                            <h4>Rs.<?php echo number_format($dailyTotal, 2); ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Monthly Expenses</h6>
                                            <?php
                                            $month = date('Y-m');
                                            $monthly = Database::search("SELECT SUM(amount) as total FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = '$month'");
                                            $monthlyTotal = $monthly->fetch_assoc()['total'] ?? 0;
                                            ?>
                                            <h4>Rs.<?php echo number_format($monthlyTotal, 2); ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning">
                                        <div class="card-body">
                                            <h6 class="card-title">Average Daily</h6>
                                            <?php
                                            $avg = Database::search("SELECT AVG(daily_total) as avg FROM 
                        (SELECT DATE(date) as expense_date, SUM(amount) as daily_total 
                        FROM expenses 
                        GROUP BY DATE(date)) as daily_expenses");
                                            $avgDaily = $avg->fetch_assoc()['avg'] ?? 0;
                                            ?>
                                            <h4>Rs.<?php echo number_format($avgDaily, 2); ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Expense Types</h6>
                                            <?php
                                            $types = Database::search("SELECT COUNT(*) as count FROM expense_type");
                                            $typeCount = $types->fetch_assoc()['count'];
                                            ?>
                                            <h4><?php echo $typeCount; ?> Categories</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expenseTableBody">
                                        <?php
                                        $query = Database::search("SELECT e.*, et.name as type_name 
                    FROM expenses e 
                    INNER JOIN expense_type et ON e.expense_type_id = et.et_id 
                    ORDER BY e.date DESC");

                                        while ($row = $query->fetch_assoc()) {
                                            echo "<tr>
                        <td>{$row['expenses_id']}</td>
                        <td>{$row['type_name']}</td>
                        <td>Rs.{$row['amount']}.00</td>
                        <td>{$row['date']}</td>
                        <td class='action-buttons'>
                            <button class='btn btn-primary btn-sm' onclick='editExpense({$row['expenses_id']})'>
                                <i class='fas fa-edit'></i>
                            </button>
                            <button class='btn btn-danger btn-sm' onclick='deleteExpense({$row['expenses_id']})'>
                                <i class='fas fa-trash'></i>
                            </button>
                        </td>
                    </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Invoices Tab Content -->
                        <div class="tab-pane fade" id="invoices" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="invoiceSearch" class="form-control" placeholder="Search invoices...">
                                        <button class="btn btn-primary" onclick="searchInvoices()">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success w-100" onclick="showAddInvoice()">
                                        <i class="fas fa-plus"></i> Create New Invoice
                                    </button>
                                </div>
                            </div>

                            <!-- Invoice Summary Cards -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Total Invoices</h6>
                                            <?php
                                            $total = Database::search("SELECT COUNT(*) as count FROM invoice");
                                            $totalCount = $total->fetch_assoc()['count'];
                                            ?>
                                            <h4><?php echo $totalCount; ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Paid Invoices</h6>
                                            <?php
                                            $paid = Database::search("SELECT COUNT(*) as count FROM invoice WHERE payment_status_id = 1");
                                            $paidCount = $paid->fetch_assoc()['count'];
                                            ?>
                                            <h4><?php echo $paidCount; ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning">
                                        <div class="card-body">
                                            <h6 class="card-title">Pending Payments</h6>
                                            <?php
                                            $pending = Database::search("SELECT COUNT(*) as count FROM invoice WHERE payment_status_id = 2");
                                            $pendingCount = $pending->fetch_assoc()['count'];
                                            ?>
                                            <h4><?php echo $pendingCount; ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Total Revenue</h6>
                                            <?php
                                            $revenue = Database::search("SELECT SUM(i_amount) as total FROM invoice WHERE payment_status_id = 1");
                                            $totalRevenue = $revenue->fetch_assoc()['total'] ?? 0;
                                            ?>
                                            <h4>Rs.<?php echo number_format($totalRevenue, 2); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoiceTableBody">
                                        <?php
                                        $query = Database::search("SELECT i.*, c.f_name, c.l_name, ps.sname as status_name 
                    FROM invoice i 
                    INNER JOIN customer c ON i.customer_id = c.customer_id 
                    INNER JOIN payment_status ps ON i.payment_status_id = ps.ps_id 
                    ORDER BY i.i_date DESC");

                                        while ($row = $query->fetch_assoc()) {
                                            $statusClass = ($row['payment_status_id'] == 1) ? 'success' : 'warning';

                                            echo "<tr>
                        <td>{$row['invoice_id']}</td>
                        <td>{$row['f_name']} {$row['l_name']}</td>
                        <td>Rs.{$row['i_amount']}.00</td>
                        <td>{$row['i_date']}</td>
                        <td><span class='badge bg-{$statusClass}'>{$row['status_name']}</span></td>
                        <td class='action-buttons'>
                            <button class='btn btn-primary btn-sm' onclick='editInvoice({$row['invoice_id']})'>
                                <i class='fas fa-edit'></i>
                            </button>
                            <button class='btn btn-info btn-sm' onclick='viewInvoice({$row['invoice_id']})'>
                                <i class='fas fa-eye'></i>
                            </button>
                            <button class='btn btn-success btn-sm' onclick='printInvoice({$row['invoice_id']})'>
                                <i class='fas fa-print'></i>
                            </button>
                        </td>
                    </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add/Edit Customer Modal -->
                <div class="modal fade" id="customerModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="customerModalTitle">Add New Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="customerForm">
                                    <input type="hidden" name="customer_id" id="customerId">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="f_name" id="customerFname" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="l_name" id="customerLname" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mobile</label>
                                        <input type="tel" class="form-control" name="mobile" id="customerMobile" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="address" id="customerAddress" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIC</label>
                                        <input type="text" class="form-control" name="nic" id="customerNic" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">System Capacity</label>
                                        <input type="text" class="form-control" name="system_capacity" id="customerCapacity" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="saveCustomer()">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Details Modal -->
                <div class="modal fade" id="customerDetailsModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Customer Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" id="customerDetailsContent">
                                <!-- Content will be loaded dynamically -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add/Edit Team Modal -->
                <div class="modal fade" id="teamModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="teamModalTitle">Add New Team Member</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="teamForm">
                                    <input type="hidden" name="team_id" id="teamId">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="f_name" id="teamFname" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="l_name" id="teamLname" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mobile</label>
                                        <input type="tel" class="form-control" name="mobile" id="teamMobile" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIC</label>
                                        <input type="text" class="form-control" name="nic" id="teamNic" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="address" id="teamAddress" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Occupation</label>
                                        <select class="form-select" name="occupation_id" id="teamOccupation" required>
                                            <?php
                                            $occupations = Database::search("SELECT * FROM occupation");
                                            while ($occ = $occupations->fetch_assoc()) {
                                                echo "<option value='{$occ['o_id']}'>{$occ['oname']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="member_status_id" id="teamStatus" required>
                                            <?php
                                            $statuses = Database::search("SELECT * FROM member_status");
                                            while ($status = $statuses->fetch_assoc()) {
                                                echo "<option value='{$status['ms_id']}'>{$status['tsname']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="saveTeam()">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Modal -->
                <div class="modal fade" id="productModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalTitle">Add New Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="productForm">
                                    <input type="hidden" name="product_id" id="productId">
                                    <div class="mb-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control" name="product_name" id="productName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="number" class="form-control" name="price" id="productPrice" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" class="form-control" name="qty" id="productQty" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Supplier</label>
                                        <select class="form-select" name="supplier_id" id="productSupplier" required>
                                            <?php
                                            $suppliers = Database::search("SELECT * FROM supplier");
                                            while ($sup = $suppliers->fetch_assoc()) {
                                                echo "<option value='{$sup['supplier_id']}'>{$sup['s_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="saveProduct()">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supplier Modal -->
                <div class="modal fade" id="supplierModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="supplierModalTitle">Add New Supplier</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="supplierForm">
                                    <input type="hidden" name="supplier_id" id="supplierId">
                                    <div class="mb-3">
                                        <label class="form-label">Supplier Name</label>
                                        <input type="text" class="form-control" name="s_name" id="supplierName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mobile</label>
                                        <input type="tel" class="form-control" name="mobile" id="supplierMobile" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="address" id="supplierAddress" required></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="saveSupplier()">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Modal -->
                <div class="modal fade" id="paymentModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Payment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="paymentForm">
                                    <input type="hidden" name="supplier_id" id="paymentSupplierId">
                                    <div class="mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="number" class="form-control" name="amount" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" class="form-control" name="date" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="savePayment()">Save Payment</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expense Modal -->
                <div class="modal fade" id="expenseModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="expenseModalTitle">Add New Expense</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="expenseForm">
                                    <input type="hidden" name="expenses_id" id="expenseId">
                                    <div class="mb-3">
                                        <label class="form-label">Expense Type</label>
                                        <select class="form-select" name="expense_type_id" id="expenseType" required>
                                            <?php
                                            $types = Database::search("SELECT * FROM expense_type");
                                            while ($type = $types->fetch_assoc()) {
                                                echo "<option value='{$type['et_id']}'>{$type['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="number" class="form-control" name="amount" id="expenseAmount" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" class="form-control" name="date" id="expenseDate" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="saveExpense()">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Modal -->
                <div class="modal fade" id="invoiceModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="invoiceModalTitle">Create New Invoice</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="invoiceForm">
                                    <input type="hidden" name="invoice_id" id="invoiceId">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer</label>
                                            <select class="form-select" name="customer_id" id="invoiceCustomer" required>
                                                <?php
                                                $customers = Database::search("SELECT * FROM customer");
                                                while ($cust = $customers->fetch_assoc()) {
                                                    echo "<option value='{$cust['customer_id']}'>{$cust['f_name']} {$cust['l_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Payment Status</label>
                                            <select class="form-select" name="payment_status_id" id="invoiceStatus" required>
                                                <?php
                                                $statuses = Database::search("SELECT * FROM payment_status");
                                                while ($status = $statuses->fetch_assoc()) {
                                                    echo "<option value='{$status['ps_id']}'>{$status['sname']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Amount</label>
                                            <input type="number" class="form-control" name="i_amount" id="invoiceAmount" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Discount</label>
                                            <input type="number" class="form-control" name="discount" id="invoiceDiscount" value="0">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Sub Total</label>
                                            <input type="number" class="form-control" name="sub_total" id="invoiceSubTotal" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="datetime-local" class="form-control" name="i_date" id="invoiceDate" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="saveInvoice()">Save Invoice</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice View Modal -->
                <div class="modal fade" id="invoiceViewModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Invoice Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" id="invoiceViewContent">
                                <!-- Content will be loaded dynamically -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="printInvoiceDetails()">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script>
            // Customer Management Functions
            function searchCustomers() {
                const searchTerm = document.getElementById('customerSearch').value;
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/customers/search_customers.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('customerTableBody').innerHTML = this.responseText;
                    }
                };

                xhr.send('search=' + searchTerm);
            }

            function showAddCustomer() {
                document.getElementById('customerModalTitle').textContent = 'Add New Customer';
                document.getElementById('customerForm').reset();
                document.getElementById('customerId').value = '';
                new bootstrap.Modal(document.getElementById('customerModal')).show();
            }

            function editCustomer(id) {
                document.getElementById('customerModalTitle').textContent = 'Edit Customer';

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/customers/get_customer.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        const customer = JSON.parse(this.responseText);
                        document.getElementById('customerId').value = customer.customer_id;
                        document.getElementById('customerFname').value = customer.f_name;
                        document.getElementById('customerLname').value = customer.l_name;
                        document.getElementById('customerMobile').value = customer.mobile;
                        document.getElementById('customerAddress').value = customer.address;
                        document.getElementById('customerNic').value = customer.nic;
                        document.getElementById('customerCapacity').value = customer.system_capacity;

                        new bootstrap.Modal(document.getElementById('customerModal')).show();
                    }
                };

                xhr.send('id=' + id);
            }

            function saveCustomer() {
                const form = document.getElementById('customerForm');
                const formData = new FormData(form);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/customers/save_customer.php', true);

                xhr.onload = function() {
                    if (this.status === 200) {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            alert('Customer saved successfully!');
                            location.reload();
                        } else {
                            alert('Error saving customer: ' + response.message);
                        }
                    }
                };

                xhr.send(formData);
            }

            function deleteCustomer(id) {
                if (confirm('Are you sure you want to delete this customer?')) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'handlers/customers/delete_customer.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        if (this.status === 200) {
                            const response = JSON.parse(this.responseText);
                            if (response.success) {
                                alert('Customer deleted successfully!');
                                location.reload();
                            } else {
                                alert('Error deleting customer: ' + response.message);
                            }
                        }
                    };

                    xhr.send('id=' + id);
                }
            }

            function viewCustomerDetails(id) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/customers/get_customer_details.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('customerDetailsContent').innerHTML = this.responseText;
                        new bootstrap.Modal(document.getElementById('customerDetailsModal')).show();
                    }
                };

                xhr.send('id=' + id);
            }

            // Product Management Functions
            function searchProducts() {
                const searchTerm = document.getElementById('productSearch').value;
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/products/search_products.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('productTableBody').innerHTML = this.responseText;
                    }
                };

                xhr.send('search=' + searchTerm);
            }

            function showAddProduct() {
                document.getElementById('productModalTitle').textContent = 'Add New Product';
                document.getElementById('productForm').reset();
                document.getElementById('productId').value = '';
                new bootstrap.Modal(document.getElementById('productModal')).show();
            }

            function editProduct(id) {
                document.getElementById('productModalTitle').textContent = 'Edit Product';

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/products/get_product.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        const product = JSON.parse(this.responseText);
                        document.getElementById('productId').value = product.product_id;
                        document.getElementById('productName').value = product.product_name;
                        document.getElementById('productPrice').value = product.price;
                        document.getElementById('productQty').value = product.qty;
                        document.getElementById('productSupplier').value = product.supplier_id;

                        new bootstrap.Modal(document.getElementById('productModal')).show();
                    }
                };

                xhr.send('id=' + id);
            }

            function saveProduct() {
                const form = document.getElementById('productForm');
                const formData = new FormData(form);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/products/save_product.php', true);

                xhr.onload = function() {
                    if (this.status === 200) {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            alert('Product saved successfully!');
                            location.reload();
                        } else {
                            alert('Error saving product: ' + response.message);
                        }
                    }
                };

                xhr.send(formData);
            }

            function updateStock(id) {
                const qty = prompt('Enter new stock quantity:');
                if (qty !== null) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'handlers/products/update_stock.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        if (this.status === 200) {
                            const response = JSON.parse(this.responseText);
                            if (response.success) {
                                alert('Stock updated successfully!');
                                location.reload();
                            } else {
                                alert('Error updating stock: ' + response.message);
                            }
                        }
                    };

                    xhr.send('id=' + id + '&qty=' + qty);
                }
            }

            function deleteProduct(productId, supplierId) {
                if (confirm('Are you sure you want to delete this product?')) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'handlers/products/delete_product.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        if (this.status === 200) {
                            const response = JSON.parse(this.responseText);
                            if (response.success) {
                                alert('Product deleted successfully!');
                                location.reload();
                            } else {
                                alert('Error deleting product: ' + response.message);
                            }
                        }
                    };

                    xhr.send('id=' + productId + '&supplier_id=' + supplierId);
                }
            }

            // Supplier Management Functions
            function searchSuppliers() {
                const searchTerm = document.getElementById('supplierSearch').value;
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/suppliers/search_suppliers.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('supplierTableBody').innerHTML = this.responseText;
                    }
                };

                xhr.send('search=' + searchTerm);
            }

            // Continue Supplier Management Functions
            function showAddSupplier() {
                document.getElementById('supplierModalTitle').textContent = 'Add New Supplier';
                document.getElementById('supplierForm').reset();
                document.getElementById('supplierId').value = '';
                new bootstrap.Modal(document.getElementById('supplierModal')).show();
            }

            function editSupplier(id) {
                document.getElementById('supplierModalTitle').textContent = 'Edit Supplier';

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/suppliers/get_supplier.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        const supplier = JSON.parse(this.responseText);
                        document.getElementById('supplierId').value = supplier.supplier_id;
                        document.getElementById('supplierName').value = supplier.s_name;
                        document.getElementById('supplierMobile').value = supplier.mobile;
                        document.getElementById('supplierAddress').value = supplier.address;

                        new bootstrap.Modal(document.getElementById('supplierModal')).show();
                    }
                };

                xhr.send('id=' + id);
            }

            function saveSupplier() {
                const form = document.getElementById('supplierForm');
                const formData = new FormData(form);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/suppliers/save_supplier.php', true);

                xhr.onload = function() {
                    if (this.status === 200) {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            alert('Supplier saved successfully!');
                            location.reload();
                        } else {
                            alert('Error saving supplier: ' + response.message);
                        }
                    }
                };

                xhr.send(formData);
            }

            function deleteSupplier(id) {
                if (confirm('Are you sure you want to delete this supplier? This will affect related products.')) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'handlers/suppliers/delete_supplier.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        if (this.status === 200) {
                            const response = JSON.parse(this.responseText);
                            if (response.success) {
                                alert('Supplier deleted successfully!');
                                location.reload();
                            } else {
                                alert('Error deleting supplier: ' + response.message);
                            }
                        }
                    };

                    xhr.send('id=' + id);
                }
            }

            function viewSupplierDetails(id) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/suppliers/get_supplier_details.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('supplierDetailsContent').innerHTML = this.responseText;
                        new bootstrap.Modal(document.getElementById('supplierDetailsModal')).show();
                    }
                };

                xhr.send('id=' + id);
            }

            function addPayment(id) {
                document.getElementById('paymentSupplierId').value = id;
                document.getElementById('paymentForm').reset();
                new bootstrap.Modal(document.getElementById('paymentModal')).show();
            }

            function savePayment() {
                const form = document.getElementById('paymentForm');
                const formData = new FormData(form);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/suppliers/save_payment.php', true);

                xhr.onload = function() {
                    if (this.status === 200) {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            alert('Payment saved successfully!');
                            location.reload();
                        } else {
                            alert('Error saving payment: ' + response.message);
                        }
                    }
                };

                xhr.send(formData);
            }

            function searchExpenses() {
                const searchTerm = document.getElementById('expenseSearch').value;
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/expenses/search_expenses.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('expenseTableBody').innerHTML = this.responseText;
                    }
                };

                xhr.send('search=' + searchTerm);
            }

            function showAddExpense() {
                document.getElementById('expenseModalTitle').textContent = 'Add New Expense';
                document.getElementById('expenseForm').reset();
                document.getElementById('expenseId').value = '';
                document.getElementById('expenseDate').value = new Date().toISOString().split('T')[0];
                new bootstrap.Modal(document.getElementById('expenseModal')).show();
            }

            function editExpense(id) {
                document.getElementById('expenseModalTitle').textContent = 'Edit Expense';

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/expenses/get_expense.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        const expense = JSON.parse(this.responseText);
                        document.getElementById('expenseId').value = expense.expenses_id;
                        document.getElementById('expenseType').value = expense.expense_type_id;
                        document.getElementById('expenseAmount').value = expense.amount;
                        document.getElementById('expenseDate').value = expense.date;

                        new bootstrap.Modal(document.getElementById('expenseModal')).show();
                    }
                };

                xhr.send('id=' + id);
            }

            function saveExpense() {
                const form = document.getElementById('expenseForm');
                const formData = new FormData(form);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/expenses/save_expense.php', true);

                xhr.onload = function() {
                    if (this.status === 200) {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            alert('Expense saved successfully!');
                            location.reload();
                        } else {
                            alert('Error saving expense: ' + response.message);
                        }
                    }
                };

                xhr.send(formData);
            }

            function deleteExpense(id) {
                if (confirm('Are you sure you want to delete this expense?')) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'handlers/expenses/delete_expense.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        if (this.status === 200) {
                            const response = JSON.parse(this.responseText);
                            if (response.success) {
                                alert('Expense deleted successfully!');
                                location.reload();
                            } else {
                                alert('Error deleting expense: ' + response.message);
                            }
                        }
                    };

                    xhr.send('id=' + id);
                }
            }

            // Invoice Management Functions
            function calculateSubTotal() {
                const amount = parseFloat(document.getElementById('invoiceAmount').value) || 0;
                const discount = parseFloat(document.getElementById('invoiceDiscount').value) || 0;
                const subTotal = amount - discount;
                document.getElementById('invoiceSubTotal').value = subTotal;
            }

            document.getElementById('invoiceAmount').addEventListener('input', calculateSubTotal);
            document.getElementById('invoiceDiscount').addEventListener('input', calculateSubTotal);

            function searchInvoices() {
                const searchTerm = document.getElementById('invoiceSearch').value;
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/invoices/search_invoices.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('invoiceTableBody').innerHTML = this.responseText;
                    }
                };

                xhr.send('search=' + searchTerm);
            }

            function showAddInvoice() {
                document.getElementById('invoiceModalTitle').textContent = 'Create New Invoice';
                document.getElementById('invoiceForm').reset();
                document.getElementById('invoiceId').value = '';
                document.getElementById('invoiceDate').value = new Date().toISOString().slice(0, 16);
                new bootstrap.Modal(document.getElementById('invoiceModal')).show();
            }

            function editInvoice(id) {
                document.getElementById('invoiceModalTitle').textContent = 'Edit Invoice';

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/invoices/get_invoice.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        const invoice = JSON.parse(this.responseText);
                        document.getElementById('invoiceId').value = invoice.invoice_id;
                        document.getElementById('invoiceCustomer').value = invoice.customer_id;
                        document.getElementById('invoiceStatus').value = invoice.payment_status_id;
                        document.getElementById('invoiceAmount').value = invoice.i_amount;
                        document.getElementById('invoiceDiscount').value = invoice.discount;
                        document.getElementById('invoiceSubTotal').value = invoice.sub_total;
                        document.getElementById('invoiceDate').value = invoice.i_date.slice(0, 16);

                        new bootstrap.Modal(document.getElementById('invoiceModal')).show();
                    }
                };

                xhr.send('id=' + id);
            }

            function saveInvoice() {
                const form = document.getElementById('invoiceForm');
                const formData = new FormData(form);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/invoices/save_invoice.php', true);

                xhr.onload = function() {
                    if (this.status === 200) {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            alert('Invoice saved successfully!');
                            location.reload();
                        } else {
                            alert('Error saving invoice: ' + response.message);
                        }
                    }
                };

                xhr.send(formData);
            }

            function viewInvoice(id) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/invoices/get_invoice_details.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('invoiceViewContent').innerHTML = this.responseText;
                        new bootstrap.Modal(document.getElementById('invoiceViewModal')).show();
                    }
                };

                xhr.send('id=' + id);
            }

            function printInvoice(id) {
                window.open('handlers/invoices/print_invoice.php?id=' + id, '_blank');
            }

            function printInvoiceDetails() {
                const content = document.getElementById('invoiceViewContent').innerHTML;
                const printWindow = window.open('', '', 'height=600,width=800');

                printWindow.document.write('<html><head><title>Invoice</title>');
                printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">');
                printWindow.document.write('</head><body>');
                printWindow.document.write(content);
                printWindow.document.write('</body></html>');

                printWindow.document.close();
                printWindow.focus();
                setTimeout(function() {
                    printWindow.print();
                    printWindow.close();
                }, 1000);
            }
            // Team Management Functions
            function searchTeam() {
                const searchTerm = document.getElementById('teamSearch').value;
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/team/search_team.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('teamTableBody').innerHTML = this.responseText;
                    }
                };

                xhr.send('search=' + searchTerm);
            }

            function showAddTeam() {
                document.getElementById('teamModalTitle').textContent = 'Add New Team Member';
                document.getElementById('teamForm').reset();
                document.getElementById('teamId').value = '';
                new bootstrap.Modal(document.getElementById('teamModal')).show();
            }

            function editTeam(id) {
                document.getElementById('teamModalTitle').textContent = 'Edit Team Member';

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/team/get_team.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        const member = JSON.parse(this.responseText);
                        document.getElementById('teamId').value = member.team_id;
                        document.getElementById('teamFname').value = member.f_name;
                        document.getElementById('teamLname').value = member.l_name;
                        document.getElementById('teamMobile').value = member.mobile;
                        document.getElementById('teamNic').value = member.nic;
                        document.getElementById('teamAddress').value = member.address;
                        document.getElementById('teamOccupation').value = member.occupation_id;
                        document.getElementById('teamStatus').value = member.member_status_id;

                        new bootstrap.Modal(document.getElementById('teamModal')).show();
                    }
                };

                xhr.send('id=' + id);
            }

            function saveTeam() {
                const form = document.getElementById('teamForm');
                const formData = new FormData(form);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/team/save_team.php', true);

                xhr.onload = function() {
                    if (this.status === 200) {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            alert('Team member saved successfully!');
                            location.reload();
                        } else {
                            alert('Error saving team member: ' + response.message);
                        }
                    }
                };

                xhr.send(formData);
            }

            function deleteTeam(id) {
                if (confirm('Are you sure you want to delete this team member?')) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'handlers/team/delete_team.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        if (this.status === 200) {
                            const response = JSON.parse(this.responseText);
                            if (response.success) {
                                alert('Team member deleted successfully!');
                                location.reload();
                            } else {
                                alert('Error deleting team member: ' + response.message);
                            }
                        }
                    };

                    xhr.send('id=' + id);
                }
            }

            function viewTeamDetails(id) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'handlers/team/get_team_details.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('teamDetailsContent').innerHTML = this.responseText;
                        new bootstrap.Modal(document.getElementById('teamDetailsModal')).show();
                    }
                };

                xhr.send('id=' + id);
            }

        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
}
?>