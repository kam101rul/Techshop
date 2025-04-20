<?php 
session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
    header("location:index.php");
    exit();
}

include "lib/connection.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    $loginquery = "SELECT * FROM users WHERE email='$email' AND pass='$pass'";
    $loginres = $conn->query($loginquery);

    if ($loginres->num_rows > 0) {
        $result = $loginres->fetch_assoc();
        $_SESSION['username'] = $result['f_name'];
        $_SESSION['userid'] = $result['id'];
        $_SESSION['auth'] = 1;

        header("location:index.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login | Tech Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styling -->
    <style>
        body {
            background: rgb(13, 110, 253); /* blue */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 5% auto;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            border-radius: 0.5rem;
        }

        .form-error {
            color: red;
            font-size: 0.9rem;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container login-container">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">Welcome Back</h3>

                <?php if (isset($error)): ?>
                    <div class="form-error"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" required placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required placeholder="Password">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <div class="mt-3 text-center">
                    <a href="register.php" class="small">Don't have an account? Register</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
