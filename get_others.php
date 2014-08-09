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

$IdNext = $_POST['IdNext']	;


$sql = "SELECT * FROM Challenges_Races WHERE IdNext = '" . $IdNext . " ORDER BY Created DESC'";
$query = mysql_query($sql);

// If we find a match, create an array of data, json_encode it and echo it out
if (mysql_num_rows($query) > 0) {

	////////////////

	$rows = Array();
	$aux2 = Array();
	$tot = Array();

	while ($row = mysql_fetch_array($query)) {
		array_push($rows, $row);

		$sql2 = "SELECT FirstName, LastName FROM Challenges_Users WHERE Id = '" . $row['IdUser'] . "'";
		$query2 = mysql_query($sql2);

		$row = mysql_fetch_array($query2);
		array_push($aux2, $row);

	}

	array_push($tot, $aux2);
	array_push($tot, $rows);

	echo json_encode($tot);

} else {
	// Else the username and/or password was invalid! Create an array, json_encode it and echo it out
	$response = array('logged' => false, 'message' => 'No Races');
	echo json_encode($response);
}
?>