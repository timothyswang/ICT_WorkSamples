<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
            <h1 class="col col-12 text-center" id = "pageTitle">Explore America's Parks</h1>
        </div>

        <form action="" method="">
            <div class="row justify-content-center mt-3">
                <label for="parkname_id" class="col col-8">Park Name:</label>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col col-8">
                <input type="text" class="form-control form-control-lg" placeholder="Grand Canyon" id="parkname_id" name="parkname">
                </div>
                <small id="parkname-error" class="invalid-feedback">Park name or state name is required.</small>
            </div>

            <div class="row justify-content-center mt-3">
                <label for="statename_id" class="col col-8">State Name:</label>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col col-8">
                <input type="text" class="form-control form-control-lg" placeholder="California" id="statename_id" name="statename">
                </div>
                <small id="statename-error" class="invalid-feedback">Park name or state name is required.</small>
            </div>

            <div class="row justify-content-center my-3">
                <button type="submit" class="btn btn-success" id="mySearchButton">Search</button>
            </div>
        </form>

        <div class="row my-3">
            <div class="col col-12">
                <ul class="list-group align-items-center" id = "myList">
                </ul>
            </div>
        </div>
    </div>

    <script>
        function ajaxGet(endpointUrl, returnFunction){
			var xhr = new XMLHttpRequest();
			xhr.open('GET', endpointUrl, true);
			xhr.onreadystatechange = function(){
				if (xhr.readyState == XMLHttpRequest.DONE) {
					if (xhr.status == 200) {
						// When ajax call is complete, call this function, pass a string with the response
						returnFunction( xhr.responseText );
					} else {
						alert('AJAX Error.');
						console.log(xhr.status);
					}
				}
			}
			xhr.send();
		};

        document.querySelector("form").onsubmit = function(event) {

            if ( document.querySelector('#parkname_id').value.trim().length == 0 && document.querySelector('#statename_id').value.trim().length == 0) {
                document.querySelector('#parkname_id').classList.add('is-invalid');
                document.querySelector('#statename_id').classList.add('is-invalid');
                return ( !document.querySelectorAll('.is-invalid').length > 0 );
            }
            else {
                document.querySelector('#parkname_id').classList.remove('is-invalid');
                document.querySelector('#statename_id').classList.remove('is-invalid');

            }

            // console.log("Hello!!")

            event.preventDefault();

			// Get the user's search input
			let parkInput = document.querySelector("#parkname_id").value.trim();
			let stateInput = document.querySelector("#statename_id").value.trim();

			// Call the ajax function, pass in the search input, log out results
			ajaxGet("searchback.php?parkname=" + parkInput + "&statename=" + stateInput, function(results) {

				// this function runs when we get a response from backend.php
				console.log(results);

				// convert the data into js object
				let jsResults = JSON.parse(results);
				console.log(jsResults);

				let resultsList = document.querySelector("#myList");

				// Clear the previous list of results
				resultsList.replaceChildren();

				// Run through the list of results and dynamically create a <li> tag for each of the result
				for(let i=0; i<jsResults.length; i++) {
					let htmlString = `<a href="park.php?id=${jsResults[i].idParks}" class="list-group-item list-group-item-action col col-8 text-center">${jsResults[i].name} in ${jsResults[i].state}</a>`;
					// Append to the <ol> tag
					resultsList.innerHTML += htmlString;
				}

			});
		}

        document.querySelector("#mySearchButton").onmouseenter = function() {
            this.classList.add("btn-info")
            this.classList.remove("btn-success")

            this.innerHTML = "SEARCH!!"
        }
        document.querySelector("#mySearchButton").onmouseleave = function() {
            this.classList.add("btn-success")
            this.classList.remove("btn-info")

            this.innerHTML = "Search"
        }


    </script>
    
    
</body>
</html>