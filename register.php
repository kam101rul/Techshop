<?php
include "lib/connection.php";

$result = null;

if (isset($_POST['u_submit'])) {
    $f_name = $_POST['u_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $pass = md5($_POST['pass']);
    $cpass = md5($_POST['c_pass']);

    if ($pass === $cpass) {
        $insertSql = "INSERT INTO users(f_name, l_name, email, pass) VALUES ('$f_name', '$l_name', '$email', '$pass')";
        if ($conn->query($insertSql)) {
            header("location:login.php");
            exit();
        } else {
            $result = "<div class='alert alert-danger'>Something went wrong: " . $conn->error . "</div>";
        }
    } else {
        $result = "<div class='alert alert-warning'>Passwords do not match.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register | Tech Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: rgb(26, 114, 246); /* blue */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            max-width: 600px;
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
    </style>
</head>
<body>

<div class="container register-container">
    <div class="card">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Create an Account</h3>

            <?php if ($result): ?>
                <div class="text-center mb-3"><?php echo $result; ?></div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="First Name" name="u_name" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Last Name" name="l_name" required>
                    </div>
                </div>

                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <input type="password" class="form-control" placeholder="Password" name="pass" required>
                    </div>
                    <div class="col">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="c_pass" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100" name="u_submit">Register Account</button>
            </form>

            <div class="text-center mt-3">
                <a class="small" href="login.php">Already have an account? Login!</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
