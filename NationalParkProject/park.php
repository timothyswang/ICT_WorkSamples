<?php

    if ( !isset($_GET['id']) || empty($_GET['id']) ) {
	    $error = "Invalid Park.";
    }
    else {
        require 'config/config.php';

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ( $mysqli->connect_errno ) {
            echo $mysqli->connect_error;
            exit();
        }

        $mysqli->set_charset('utf8');

        $sql = "SELECT * FROM parks WHERE idParks = " . $_GET['id'] . ";";

        $results = $mysqli->query($sql);
        if ( !$results ) {
            echo $mysqli->error;
            exit();
        }

        $row = $results->fetch_assoc();

        $sql = "SELECT * FROM states 
        LEFT JOIN parks_has_states
        ON states.idstates = parks_has_states.states_idstates
        LEFT JOIN parks
        ON  parks_has_states.parks_idParks = parks.idParks
        WHERE idParks = " . $_GET['id'] . ";";

        $resultstate = $mysqli->query($sql);
        if ( !$resultstate ) {
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
    <title>Park</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
</head>
<body id="parkbody">

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <a class="navbar-brand col-8" href="homepage.php">National Park Explorer</a>

        <a class="btn btn-success col-lg-1 col-md-5 col-sm-10 mx-3 my-3" role="button" href="login.php">Login</a>
        <a class="btn btn-success col-lg-1 col-md-5 col-sm-10 mx-3 my-3" role="button" href="signup.php">Sign Up</a>
        <a class="btn btn-success col-lg-1 col-md-5 col-sm-10 mx-3 my-3" role="button" href="profile.php">Profile</a>

    </nav>

    <div class="container" id="myParkContainer">
        <?php if ( isset($error) && !empty($error) ) : ?>
            <div class="row my-3">
                <h3 class="col col-12 text-center text-danger" id = "pageTitle"><?php echo $error; ?></h3>
            </div>

        <?php else : ?>

        <div class="row my-3">
            <h1 class="col col-12 text-center" id = "pageTitle"><?php echo $row['name']; ?></h1>
        </div>
        <?php while ( $rowstate = $resultstate->fetch_assoc() ) : ?>
            <div class="row my-3">
                <h3 class="col col-12 text-center"><?php echo $rowstate['state'];?></h3>
            </div>
        <?php endwhile; ?>
        <div class="row my-3">
            <div class="col-12 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <img src="images/<?php echo $row['image1'] ?>" alt="National Park Image" class = "img1 my-3">
                <img src="images/<?php echo $row['image2'] ?>" alt="National Park Image" class = "img1 my-3">
            </div>
            <div class="col-12 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <p>
                    <?php echo $row['description'] ?>
                </p>
                <p>
                    Year Established: <?php echo $row['date_established'] ?>
                </p>
                <p>
                    Area: <?php echo $row['area'] ?> acres
                </p>
                <p>
                    Annual Visitors: <?php echo $row['visitors'] ?>
                </p>
                <a class="btn btn-success justify-content-center my-3" role="button" href="addpark.php?id=<?php echo $_GET['id'] ?>">Save Park</a>
            </div>
            <div class="col-12 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <iframe
                width="330"
                height="450"
                frameborder="0" style="border:0"
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed/v1/view?key=AIzaSyC7cbs5BsoXov-9AULQ_bM7shC-_TaarCA&center=<?php echo $row['googlemap'] ?>&zoom=10"
                allowfullscreen>
                </iframe>
                <!-- <img src="images/googlemaps.jpg" alt="Grand Canyon Map" class = "img1 my-3"> -->
            </div>
        </div>

        <?php endif; ?>
    </div>

    
    
    
</body>
</html>