<?php
    // session_start();
    // session_unset();
    // session_destroy();

    require 'config/config.php';
    
    if( !isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        header("Location: homepage.php");
    }
    else{
        // echo $_SESSION["username"];
        // echo $_SESSION["email"];
        // echo $_SESSION["id"];

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ( $mysqli->connect_errno ) {
            echo $mysqli->connect_error;
            exit();
        }

        $mysqli->set_charset('utf8');

        $sql = "SELECT * FROM parks
                        LEFT JOIN parks_has_users
                            ON parks.idParks = parks_has_users.parks_idParks
                        WHERE parks_has_users.users_idusers = " . $_SESSION["id"] . " LIMIT 5;";
            
        
        $results = $mysqli->query($sql);

        if ( $results == false ) {
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
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <a class="navbar-brand col-8" href="homepage.php">National Park Explorer</a>

        <a class="btn btn-success col-lg-1 col-md-5 col-sm-10 mx-3 my-2" role="button" href="login.php">Login</a>
        <a class="btn btn-success col-lg-1 col-md-5 col-sm-10 mx-3 my-2" role="button" href="signup.php">Sign Up</a>
        <a class="btn btn-success col-lg-1 col-md-5 col-sm-10 mx-3 my-2" role="button" href="profile.php">Profile</a>

    </nav>

    <div class="container" id="myContainer">
        <div class="row my-2">
            <h1 class="col col-12 text-center" id = "pageTitle">Profile</h1>
        </div>
        <div class="row my-2 justify-content-center">
            <h4>Username: <?php echo $_SESSION["username"];?><h4>
        </div>
        <div class="row my-2 justify-content-center">
            <h4>Email: <?php echo $_SESSION["email"];?></h4>
        </div>
        <div class="row my-2 justify-content-center">
            <h4>Parks Liked</h4>
        </div>
        
        <div class="row my-2 justify-content-center">
            <?php while ( $row = $results->fetch_assoc() ) : ?>
            <div class="card mx-2 my-2">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['name'];?></h5>
                    <a href="park.php?id=<?php echo $row['idParks'];?>" class="card-link">See More</a>
                    <a href="removepark.php?id=<?php echo $row['idParks'];?>" class="card-link text-danger">Unlike</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
       
        <div class="row my-2 justify-content-center">
            <a class="btn btn-success mx-3" role="button" href="editprofile.php">Edit Profile</a>
            <a class="btn btn-success mx-3" role="button" href="logout.php">Log Out</a>
        </div>
    </div>

    
    
</body>
</html>