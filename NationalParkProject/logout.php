<?php
    require 'config/config.php';

    if( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
        // session_start();
        session_unset();
        session_destroy();
    }
    else {
        header("Location: homepage.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <a class="navbar-brand col-8" href="homepage.php">National Park Explorer</a>

    <a class="btn btn-success col-lg-1 col-md-5 col-sm-10 mx-3 my-3" role="button" href="login.php">Login</a>
    <a class="btn btn-success col-lg-1 col-md-5 col-sm-10 mx-3 my-3" role="button" href="signup.php">Sign Up</a>
    <a class="btn btn-success col-lg-1 col-md-5 col-sm-10 mx-3 my-3" role="button" href="profile.php">Profile</a>

</nav>

<div class="container" id="myContainer">
        <div class="row my-3">
            <h1 class="col col-12 text-center" id = "pageTitle">You have logged out.</h1>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
		<a href="homepage.php" role="button" class="btn btn-info">Home</a>
    </div>

</body>
</html>