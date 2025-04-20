<?php
include 'header.php';
session_start();

// Authentication check
if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
    header("Location: login.php");
    exit();
}

include 'lib/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <div class="container homebody mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-4">Welcome To The Admin Panel</h1>
                <p class="lead">Manage your data with ease and control.</p>
            </div>
        </div>
    </div>
</body>

</html>
