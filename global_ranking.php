<?php
// Connect to the database(host, username, password)
$con = mysql_connect('localhost', 'root', '');

if (!$con) {
	echo "Failed to make connection.";
	exit ;
}

$db = mysql_select_db('Challenges');

if (!$db) {
	echo "Failed to select db.";
	exit ;
}

$IdUser = $_POST['IdUser'];
$IdChallenge = $_POST['IdChallenge'];

$sql = "SELECT * FROM Challenges_Races WHERE IdUser = '" . $IdUser . "' AND IdChallenge = '" . $IdChallenge . "' ORDER BY Created ASC ";

$query = mysql_query($sql);

// If we find a match, create an array of data, json_encode it and echo it out
if (mysql_num_rows($query) > 0) {

	$rows = Array();
	while ($row = mysql_fetch_array($query)) {
		array_push($rows, $row);
	}
	echo json_encode($rows);
} else {
	// Else the username and/or password was invalid! Create an array, json_encode it and echo it out
	$response = array('logged' => false, 'message' => 'NO CHALLENGES AVAILABLE');
	echo json_encode($response);
}
?>