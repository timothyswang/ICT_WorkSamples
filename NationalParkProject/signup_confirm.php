<?php

    require 'config/config.php';

    // var_dump($_POST);

    if ( !isset($_POST['email']) || empty($_POST['email'])
	|| !isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
	    $error = "Please fill out all of the required fields.";
    }
    else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo $mysqli->connect_error;
            exit();
        }

        $statement_registered = $mysqli->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $statement_registered->bind_param("ss", $_POST["username"], $_POST["email"]);
        $executed_registered = $statement_registered->execute();
        if (!$executed_registered) {
            echo $mysqli->error;
        }

        $statement_registered->store_result();
        $numrows = $statement_registered->num_rows;
        $statement_registered->close();
        if ($numrows > 0) {
            $error = "Username or email address has already been taken. Please choose another one.";
        }

        else {
    
            $password = hash("sha256", $_POST["password"]);
    
            $statement = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES(?,?,?)");
    
            $statement->bind_param("sss", $_POST["username"], $_POST["email"], $password);
    
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
    <title>Signup Confirm</title>
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
            <h1 class="col col-12 text-center" id = "pageTitle">Sign Up Confirmation</h1>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <?php if ( isset($error) && !empty($error) ) : ?>
            <div class="text-danger"><?php echo $error; ?></div>
        <?php else : ?>
            <h3 class="text-success"><?php echo $_POST['username']; ?> Signed Up</h3>
        <?php endif; ?>
    </div>

    <div class="row justify-content-center mt-3">
        <a href="login.php" role="button" class="btn btn-success">Login</a>
        <div class="col col-1"></div>
		<a href="homepage.php" role="button" class="btn btn-info">Home</a>
    </div>

</body>
</html>