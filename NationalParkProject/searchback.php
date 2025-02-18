<?php
    require 'config/config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

	$sql = "SELECT parks.name, parks.idParks, states.state FROM parks
        LEFT JOIN parks_has_states
            ON parks.idParks = parks_has_states.parks_idParks
        LEFT JOIN states
            ON  parks_has_states.states_idstates = states.idstates
    WHERE name LIKE '%" . $_GET["parkname"] . "%' AND state LIKE '%" . $_GET["statename"] ."%' LIMIT 10;";

	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}

	$results_array = [];

	// fill the results array with the results
	while ($row = $results->fetch_assoc()) {
		array_push($results_array, $row);
	}

	// Convert the results into a string
	echo json_encode($results_array);

	$mysqli->close();
?>