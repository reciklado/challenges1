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
$Img = $_POST['Img'];

// 
// $IdUser = 116;
// $IdChallenge = 2;
// $Img = 'C_1407346813420.jpg';

$sql = "SELECT * FROM Challenges_Races WHERE IdUser = '" . $IdUser . "' AND IdChallenge = '" . $IdChallenge . "' AND Img = '" . $Img . "'ORDER BY Created ASC ";

$query = mysql_query($sql);

// If we find a match, create an array of data, json_encode it and echo it out
if (mysql_num_rows($query) > 0) {

	$rows = Array();
	$fotos = Array();
	$local = Array();
	$firstname1 = Array();
	$lastname1 = Array();
	$dados = Array();
	$accepted = Array();
	
	$tot = Array();
	//
	while ($row = mysql_fetch_array($query)) {

		array_push($rows, $row);
		
		$sqlfoto = "SELECT FbId,Country,Firstname,Lastname FROM Challenges_Users WHERE Id = '" . $row['IdNext'] . "'";
    	$query12 = mysql_query($sqlfoto);
		$row12 = mysql_fetch_array($query12);

		array_push($fotos, $row12['FbId']);
        array_push($local, $row12['Country']);
		array_push($firstname1, $row12['Firstname']);
		array_push($lastname1, $row12['Lastname']);
		array_push($dados, $row['Distance']);
		array_push($accepted, $row['Accepted']);
		
	};

	array_push($tot, $dados);
	array_push($tot, $fotos);
	array_push($tot, $local);
	array_push($tot, $firstname1);
	array_push($tot, $lastname1);
	array_push($tot, $accepted);

	echo json_encode($tot);
} else {
	// Else the username and/or password was invalid! Create an array, json_encode it and echo it out
	$response = array('logged' => false, 'message' => 'NO CHALLENGES AVAILABLE');
	echo json_encode($response);
}
?>