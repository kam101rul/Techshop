<?php
SESSION_START();

// Check if user is already authenticated
if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
    header("location:home.php");
    exit();
}

include "lib/connection.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $loginquery = "SELECT * FROM admin WHERE userid='$email' AND pass='$pass'";
    $loginres = $conn->query($loginquery);

    // Check if login is successful
    if ($loginres->num_rows > 0) {
        while ($result = $loginres->fetch_assoc()) {
            $username = $result['userid'];
        }

        $_SESSION['username'] = $username;
        $_SESSION['auth'] = 1;
        header("location:home.php");
        exit();
    } else {
        $error_message = "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="card mt-5">
                <div class="card-header">
                    <h3 class="text-center">Sign In</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <!-- Username input -->
                        <div class="input-group form-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" name="email" required>
                        </div>
                        <!-- Password input -->
                        <div class="input-group form-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>
                        <!-- Login button -->
                        <div class="form-group text-center">
                            <input type="submit" value="Login" class="btn btn-primary" name="submit">
                        </div>
                    </form>
                    <?php
                    if (isset($error_message)) {
                        echo "<div class='alert alert-danger mt-3'>$error_message</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>
