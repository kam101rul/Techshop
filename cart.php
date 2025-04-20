<?php
// Start output buffering to avoid "headers already sent" issue
ob_start();

include 'header.php';
include 'lib/connection.php';

// Ensure the user is authenticated
if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
    header("location:login.php");
    exit();
}

$flag = 0; // Fix: Initialize the flag before using

// Handle order submission
if (isset($_POST['order_btn'])) {
    $userid = $_POST['user_id'];
    $name = $_POST['user_name'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $mobnumber = $_POST['mobnumber'];
    $txid = $_POST['txid'];
    $status = "pending";

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE userid='$userid'");
    $price_total = 0;

    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $product_name[] = $product_item['productid'] . ' (' . $product_item['quantity'] . ') ';
            $product_price = $product_item['price'] * $product_item['quantity'];
            $price_total += $product_price;

            $sql = "SELECT * FROM product WHERE id = '{$product_item['productid']}'";
            $product_result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($product_result) > 0) {
                $row = mysqli_fetch_assoc($product_result);
                if ($product_item['quantity'] <= $row['quantity']) {
                    $t = $row['quantity'] - $product_item['quantity'];
                    mysqli_query($conn, "UPDATE `product` SET quantity = '$t' WHERE id = '{$row['id']}'");
                    $flag = 1;
                } else {
                    $_SESSION['error'] = "Out of stock: {$row['name']} (Available: {$row['quantity']})";
                    header("location:cart.php");
                    exit();
                }
            }
        }

        if ($flag == 1) {
            $total_product = implode(', ', $product_name);
            mysqli_query($conn, "INSERT INTO `orders`(userid, name, address, phone, mobnumber, txid, totalproduct, totalprice, status) VALUES('$userid','$name','$address','$number','$mobnumber','$txid','$total_product','$price_total','$status')");
            mysqli_query($conn, "DELETE FROM `cart` WHERE userid='$userid'");

            // Set a session success message
            $_SESSION['success'] = "Your order has been successfully placed!";
            
            // Redirect to cart page to show the success message
            header("location:cart.php");
            exit();
        }
    }
}

// Load cart items
$id = $_SESSION['userid'];
$sql = "SELECT * FROM cart WHERE userid='$id'";
$result = mysqli_query($conn, $sql);

// Handle cart quantity update
if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
    header("location:cart.php");
    exit();
}

// Handle remove from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
    header("location:cart.php");
    exit();
}
?>

<div class="container pendingbody">
    <h5>Cart</h5>

    <!-- Display error message if any -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Display success message if order is placed successfully -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            $serial = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $sub_total = $row["price"] * $row["quantity"];
                    $total += $sub_total;
                    ?>
                    <tr>
                        <th scope="row"><?php echo $serial++; ?></th>
                        <td><?php echo $row["name"]; ?></td>
                        <td>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" name="update_quantity_id" value="<?php echo $row['id']; ?>">
                                <input type="number" name="update_quantity" min="1" value="<?php echo $row['quantity']; ?>" class="form-control d-inline" style="width: 80px;">
                                <input type="submit" value="Update" name="update_update_btn" class="btn btn-sm btn-outline-secondary">
                            </form>
                        </td>
                        <td>$<?php echo $sub_total; ?></td>
                        <td><a href="cart.php?remove=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Remove</a></td>
                    </tr>
                    <?php
                }
                echo "<tr><td colspan='5' class='text-end fw-bold'>Total: $$total</td></tr>";
            } else {
                echo "<tr><td colspan='5' class='text-center'>Your cart is empty.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Order Form -->
    <?php if ($total > 0): ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h5>If Cash On Delivery, Put 0 in Bkash Field</h5>

            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['userid']; ?>">
            <input type="hidden" name="user_name" value="<?php echo $_SESSION['username']; ?>">

            <div class="form-group mb-2">
                <input type="text" class="form-control" placeholder="Address" name="address" required>
            </div>
            <div class="form-group mb-2">
                <input type="number" class="form-control" placeholder="Phone Number" name="number" required>
            </div>
            <div class="form-group mb-2">
                <input type="number" class="form-control" placeholder="Bkash/Nogod/Rocket Number" name="mobnumber" required>
            </div>
            <div class="form-group mb-2">
                <input type="text" class="form-control" placeholder="Transaction ID (Txid)" name="txid" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Order Now" name="order_btn" class="btn btn-success w-100">
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<?php
// End output buffering
ob_end_flush();
?>
