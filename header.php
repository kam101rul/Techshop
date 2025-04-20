<?php 
session_start();
include "lib/connection.php";
$id = $_SESSION['userid'] ?? 0;

$sql = "SELECT * FROM cart WHERE userid='$id'";
$result = $conn->query($sql);
$total = ($result && mysqli_num_rows($result) > 0) ? mysqli_num_rows($result) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tech Shop</title>
    <meta charset="UTF-8">
    <meta name="description" content="Tech Shop - Electronics, Gadgets & More">
    <meta name="keywords" content="Tech, Electronics, Gadgets, Devices, Bootstrap">
    <meta name="author" content="Siam">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="icon" type="image/png" href="img/fav.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">

    <!-- Hover Dropdown CSS -->
    <style>
/* Reset and style dropdown menu */
.nav-item.dropdown .dropdown-menu {
  border: none !important;
  outline: none !important;
  box-shadow: none !important;
  opacity: 0;
  visibility: hidden;
  display: block;
  transition: opacity 0.3s ease, visibility 0.3s ease;
  margin-top: 0;
  padding: 0.5rem 0;
}

/* Show on hover */
.nav-item.dropdown:hover .dropdown-menu {
  opacity: 1;
  visibility: visible;
}

/* Prevent sticky open from Bootstrap focus */
.nav-item.dropdown .dropdown-toggle:focus,
.nav-item.dropdown .dropdown-toggle:active,
.nav-item.dropdown .dropdown-menu:focus,
.nav-item.dropdown .dropdown-menu:active {
  outline: none !important;
  border: none !important;
  box-shadow: none !important;
}
/* Hover effect for dropdown items */
.dropdown-menu .dropdown-item:hover {
  background-color: #f0f0f0; /* light gray */
  color: #000; /* black text (or change to match your theme) */
  transition: background-color 0.3s ease;
}

</style>



</head>

<body>
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm px-3">
  <a class="navbar-brand" href="index.php">
    <img src="img/techlogo.png" alt="Tech Shop Logo" height="50">
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" 
          data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
          aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    
    <!-- Left Nav Links -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="categoriesDropdown">
          <a class="dropdown-item" href="categories.php?type=phones">Smartphones</a>
          <a class="dropdown-item" href="categories.php?type=laptops">Laptops</a>
          <a class="dropdown-item" href="categories.php?type=accessories">Accessories</a>
          <a class="dropdown-item" href="categories.php?type=gaming">Gaming</a>
          <a class="dropdown-item" href="categories.php?type=smart-home">Smart Home</a>
        </div>
      </li>
      <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
    </ul>

    <!-- Search -->
    <form class="form-inline my-2 my-lg-0" action="search.php" method="post">
      <input class="form-control mr-sm-2" type="search" placeholder="Search tech..." name="name">
      <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">
        <img src="img/search.png" alt="Search" style="height: 20px;">
      </button>
    </form>

    <!-- Cart Icon -->
    <a href="cart.php" class="btn btn-outline-primary ml-3 position-relative">
      <img src="img/cart.png" alt="Cart" style="height: 20px;">
      <span class="badge badge-danger position-absolute" style="top: -8px; right: -10px;"><?php echo $total; ?></span>
    </a>

    <!-- Auth Buttons -->
    <div class="ml-3 d-flex align-items-center">
      <?php 
        if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
          echo '<span class="mr-2">Hello, ' . $_SESSION['username'] . '</span>';
          echo '<a href="profile.php" class="btn btn-sm btn-outline-info mx-1">My Orders</a>';
          echo '<a href="logout.php" class="btn btn-sm btn-outline-danger">Logout</a>';
        } else {
          echo '<a href="login.php" class="btn btn-sm btn-outline-secondary mx-1">Login</a>';
          echo '<a href="Register.php" class="btn btn-sm btn-primary">Signup</a>';
        }
      ?>
    </div>

  </div>
</nav>
<!-- Navbar End -->

<!-- Content Start -->

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<!-- Optional JS to help dropdown toggle behave nicely -->
<script>
  $('.nav-item.dropdown').hover(function () {
    $(this).find('.dropdown-toggle').dropdown('toggle');
  });
</script>

</body>
</html>
