<?php
session_start();
$error = $_SESSION['error'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>PHP-VIKTORIA</title>
</head>
<body>
<div class="container my-2 h5">
<ul class="nav">
    <?php
    if(isset($_SESSION['user_id'])){
    ?>
        <li class="nav-item">
            <a class="nav-link" href="profile.php">LOGO</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    <?php
    } else { ?>
    <li class="nav-item">
        <a class="nav-link" href="../index.php">LOGO</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="registration.php">Registration</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
    </li>
    <?php  } ?>
</ul>
</div>
