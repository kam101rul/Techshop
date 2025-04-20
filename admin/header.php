<?php
include 'lib/connection.php';

$sql = "SELECT * FROM orders WHERE status='pending'";
$result = $conn->query($sql);
$pendingCount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
</head>
<body>

<section class="header" id="header">
    <i class="fas fa-bars fixed" onclick="openside()"></i>
    <div class="line-fixed">Admin Panel</div>

    <span>(New Orders)</span>
    <span class="badge bg-danger rounded-pill px-3 py-1">
        <?php echo $pendingCount; ?>
    </span>

    <a href="logout.php" class="ms-3 text-decoration-none">(Logout)</a>
</section>

<div class="sidenav" id="sidenav">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link d" href="home.php">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link po" href="pending_orders.php">Order Status</a>
        </li>
        <li class="nav-item">
            <a class="nav-link ap" href="add_product.php">Add Product</a>
        </li>
        <li class="nav-item">
            <a class="nav-link vp" href="all_product.php">All Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link ao" href="all_orders.php">Delivered Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link u" href="users.php">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link u" href="report.php">Report</a>
        </li>
    </ul>
</div>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
        integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/3b83a3096d.js" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</body>
</html>
