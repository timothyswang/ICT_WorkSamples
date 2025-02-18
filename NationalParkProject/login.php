<?php
    require 'config/config.php';
    if( !isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        if ( isset($_POST['username']) && isset($_POST['password']) ) {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                $error = "Please enter both a username and a password.";
            }
            else {
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                if($mysqli->connect_errno) {
                    echo $mysqli->connect_error;
                    exit();
                }

                $passwordInput = hash("sha256", $_POST["password"]);

                $statement = $mysqli->prepare("SELECT * FROM users
                WHERE username = ? AND password = ?;");
        
                $statement->bind_param("ss", $_POST["username"], $passwordInput);
        
                $executed = $statement->execute();
                if(!$executed) {
                    echo $mysqli->error;
                }
                $result = $statement->get_result();
                $numrows = $result->num_rows;

                if ($numrows == 1) {
                    while($row = $result->fetch_assoc()) {
                        $_SESSION["logged_in"] = true;
                        $_SESSION["username"] = $_POST["username"];
                        $_SESSION["email"] = $row['email'];
                        $_SESSION["id"] = $row['idusers'];

                        $statement->close();

                        header("Location: homepage.php");

                        $success_message = "You have successfully logged in!";
                    }
                }
                else {
                    $error = "Invalid username or password";
                }

                $statement->close();

                $mysqli->close();
            }
            
        }
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
    <title>Login</title>
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
            <h1 class="col col-12 text-center" id = "pageTitle">Log In</h1>
        </div>
    </div>

    <form action="login.php" method="POST">
        <div class="row justify-content-center mt-3">
            <div class="font-italic text-danger">
                <?php
                    if ( isset($error) && !empty($error) ) {
                        echo $error;
                    }
                ?>
            </div>
            <div class="font-italic text-success">
                <?php
                    if ( isset($success_message) && !empty($success_message) ) {
                        echo $success_message;
                    }
                ?>
            </div>
        </div>

    <div class="row justify-content-center mt-3">
        <label for="username-id" class="col col-5">Username: <span class="text-danger">*</span></label>
      </div>
        <div class="row justify-content-center mb-3">
          <div class="col col-5">
            <input type="text" class="form-control" placeholder="Username" id="username_id" name="username">
            <small id="username-error" class="invalid-feedback">Username is required.</small>
          </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="password-id" class="col col-5">Password: <span class="text-danger">*</span></label>
          </div>
            <div class="row justify-content-center mb-3">
              <div class="col col-5">
                <input type="password" class="form-control" placeholder="Password" id="password_id" name="password">
                <small id="password-error" class="invalid-feedback">Password is required.</small>
              </div>
            </div>

        <div class="row justify-content-center my-3">
            <button type="submit" class="btn btn-success">Log In</button>
        </div>
      </form>

    <script>
      document.querySelector('form').onsubmit = function(){
        if ( document.querySelector('#username_id').value.trim().length == 0 ) {
          document.querySelector('#username_id').classList.add('is-invalid');
        }
        else {
          document.querySelector('#username_id').classList.remove('is-invalid');
        }
  
        if ( document.querySelector('#password_id').value.trim().length == 0 ) {
          document.querySelector('#password_id').classList.add('is-invalid');
        }
        else {
          document.querySelector('#password_id').classList.remove('is-invalid');
        }
  
        return ( !document.querySelectorAll('.is-invalid').length > 0 );
      }
    </script>
    
    
</body>
</html>