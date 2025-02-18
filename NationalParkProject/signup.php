<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
            <h1 class="col col-12 text-center" id = "pageTitle">Sign Up</h1>
        </div>
    </div>

    <form action="signup_confirm.php" method="POST">
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
          <label for="email-id" class="col col-5">Email: <span class="text-danger">*</span></label>
        </div>
          <div class="row justify-content-center mb-3">
            <div class="col col-5">
              <input type="email" class="form-control" placeholder="Email" id="email_id" name="email">
              <small id="email-error" class="invalid-feedback">Email is required.</small>
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
            <button type="submit" class="btn btn-success">Sign Up</button>
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
  
        if ( document.querySelector('#email_id').value.trim().length == 0 ) {
          document.querySelector('#email_id').classList.add('is-invalid');
        }
        else {
          document.querySelector('#email_id').classList.remove('is-invalid');
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