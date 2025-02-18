<?php

    require 'config/config.php';
        
    if( !isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        if ( !isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: homepage.php");
        }
        else {
            header("Location: park.php?id=" . $_GET['id']);
        }
    }
    else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ( $mysqli->connect_errno ) {
            echo $mysqli->connect_error;
            exit();
        }

        $mysqli->set_charset('utf8');

        $statement_registered = $mysqli->prepare("SELECT * FROM parks_has_users WHERE parks_idParks = ? AND users_idusers = ?");
        $statement_registered->bind_param("ii", $_GET["id"], $_SESSION["id"]);
        $executed_registered = $statement_registered->execute();
        if (!$executed_registered) {
            echo $mysqli->error;
        }
        // prepared statements require an extra method to get result
        $statement_registered->store_result();
        // $statement->num_rows will return how many results we got back.
        $numrows = $statement_registered->num_rows;
        $statement_registered->close();
        if ($numrows > 0) {
            $error = "You've already saved this park.";
        }
        else {
    
            $statement = $mysqli->prepare("INSERT INTO parks_has_users (parks_idParks, users_idusers) VALUES(?,?)");
    
            $statement->bind_param("ii", $_GET["id"], $_SESSION["id"]);
    
            $executed = $statement->execute();
            if(!$executed) {
                echo $mysqli->error;
            }
            $statement->close();
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
    <title>Add Park</title>
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
            <h1 class="col col-12 text-center" id = "pageTitle">Save Park Confirmation</h1>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <?php if ( isset($error) && !empty($error) ) : ?>
            <div class="text-danger"><?php echo $error; ?></div>
        <?php else : ?>
            <h3 class="text-success">National Park Saved</h3>
        <?php endif; ?>
    </div>

    <div class="row justify-content-center mt-3">
		<a href="homepage.php" role="button" class="btn btn-info">Home</a>
    </div>

</body>
</html>