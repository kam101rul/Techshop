<?php
// Start output buffering to avoid "headers already sent" issue
ob_start();

include 'header.php'; // Make sure this file has no output before PHP code

include 'lib/connection.php';

// Handle cart logic
if (isset($_POST['add_to_cart'])) {
    // Check if the user is authenticated
    if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
        // Redirect to login page if not authenticated
        header("location:login.php");
        exit();
    }

    // Get data from the form
    $user_id = $_POST['user_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_id = $_POST['product_id'];
    $product_quantity = 1;

    // Check if the product is already in the cart
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE productid = '$product_id' AND userid='$user_id'");
    if (mysqli_num_rows($select_cart) > 0) {
        $_SESSION['message'] = 'Product already added to cart';
    } else {
        // Insert the product into the cart if not already added
        $insert_product = mysqli_query($conn, "INSERT INTO `cart`(userid, productid, name, quantity, price) VALUES('$user_id', '$product_id', '$product_name', '$product_quantity', '$product_price')");
        $_SESSION['message'] = 'Product added to cart successfully';
    }

    // Redirect to index page to refresh the cart
    header('location:index.php');
    exit();
}
?>

<!-- Optional: Message display -->
<?php
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-info text-center'>{$_SESSION['message']}</div>";
    unset($_SESSION['message']); // Unset the session message after displaying
}
?>

<!-- Banner Section -->
<div class="banner py-5 bg-dark text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-5 fw-bold">Welcome to <span class="text-primary">Tech Shop</span></h1>
                <p>Your one-stop destination for the latest gadgets, electronics, and accessories.</p>
                <a href="#products" class="btn btn-primary mt-3">Explore Products</a>
            </div>
            <div class="col-md-6 text-center">
                <!-- Carousel Start -->
                <div id="bannerCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="img/banner1.jpg" class="d-block w-100 img-fluid rounded" alt="Tech Banner 1">
                        </div>
                        <div class="carousel-item">
                            <img src="img/banner2.jpg" class="d-block w-100 img-fluid rounded" alt="Tech Banner 2">
                        </div>
                    </div>
                    <!-- Controls -->
                    <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <!-- Carousel End -->
            </div>
        </div>
    </div>
</div>

<!-- Product Section -->
<section id="products" class="my-5">
    <div class="container">
        <div class="text-center mb-5">
            <img src="img/techlogo.png" width="90" height="40" alt="Tech Shop Logo">
            <h3 class="mt-3">Latest Tech</h3>
            <p>Stay ahead with the newest devices and accessories.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php
            $sql = "SELECT * FROM product";
            $result = $conn->query($sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="card shadow-sm h-100 text-center">
                                <img src="admin/product_img/<?php echo $row['imgname']; ?>" class="card-img-top p-3" style="height:200px; object-fit:contain;">
                                <div class="card-body">
                                    <h6 class="card-title"><?php echo $row["name"]; ?></h6>
                                    <p class="text-primary fw-bold">$<?php echo $row["Price"]; ?></p>
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['userid']; ?>">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                                    <input type="hidden" name="product_price" value="<?php echo $row['Price']; ?>">
                                    <input type="submit" class="btn btn-outline-primary btn-sm mt-2" value="Add to Cart" name="add_to_cart">
                                </div>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                // Fallback tech products
                $fallback = [
                    ['img' => 'img/mobile.png', 'name' => 'Smartphone Pro Max', 'price' => '999'],
                    ['img' => 'img/laptop.png', 'name' => 'UltraBook X1', 'price' => '1299'],
                    ['img' => 'img/headphones.png', 'name' => 'Wireless Headphones', 'price' => '199'],
                    ['img' => 'img/keyboard.png', 'name' => 'Mechanical RGB Keyboard', 'price' => '129'],
                    ['img' => 'img/speaker.png', 'name' => 'Smart Bluetooth Speaker', 'price' => '89'],
                    ['img' => 'img/smartwatch.png', 'name' => 'Smartwatch Fit 2', 'price' => '149'],
                    ['img' => 'img/mouse.png', 'name' => 'Mouse', 'price' => '300'],
                    ['img' => 'img/tv.png', 'name' => 'TV', 'price' => '16000']
                ];
                foreach ($fallback as $item) {
            ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card shadow-sm h-100 text-center">
                            <img src="<?php echo $item['img']; ?>" class="card-img-top p-3" style="height:200px; object-fit:contain;">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $item['name']; ?></h6>
                                <p class="text-primary fw-bold">$<?php echo $item['price']; ?></p>
                                <button class="btn btn-outline-secondary btn-sm mt-2" disabled>Login to buy</button>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'footer.php'; ?>

<?php
// End the output buffering and flush the output
ob_end_flush();
?>
