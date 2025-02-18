<?php
    if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ) {
        header('Location: homepage.php');
    }
    if ( !isset($_GET['id']) || empty($_GET['id'])) {
	    $error = "Invalid request.";
    }
    else {
        require 'config/config.php';

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ( $mysqli->connect_errno ) {
            echo $mysqli->connect_error;
            exit();
        }

        $mysqli->set_charset('utf8');

        $sql = "DELETE FROM parks_has_users
					WHERE parks_idParks = " . $_GET['id'] . " AND users_idusers = " . $_SESSION['id'] . ";";

        $results = $mysqli->query($sql);
        if ( !$results ) {
            echo $mysqli->error;
            exit();
        }

        $mysqli->close();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Park</title>
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
            <h1 class="col col-12 text-center" id = "pageTitle">Remove Park Confirmation</h1>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <?php if ( isset($error) && !empty($error) ) : ?>
            <div class="text-danger"><?php echo $error; ?></div>
        <?php else : ?>
            <h3 class="text-success">National Park Removed</h3>
        <?php endif; ?>
    </div>

    <div class="row justify-content-center mt-3">
		<a href="profile.php" role="button" class="btn btn-info">Profile</a>
    </div>

</body>
</html>