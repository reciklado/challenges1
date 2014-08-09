<?php
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

$IdChallenge = $_POST['IdChallenge'];
$IdUser = $_POST['IdUser'];
$IdAnterior = $_POST['IdAnterior'];
$IdNext = $_POST['IdNext'];
$Img = $_POST['Img'];
$Latitude = $_POST['Latitude'];
$Longitude = $_POST['Longitude'];
$Distance = $_POST['Distance'];
$Accepted = $_POST['Accepted'];
$Normal = $_POST['Normal'];



// PROCURA UM OTHER COM ID DIFERENTE DO USER
$i = 0;
do {
	$sql2 = "SELECT Id FROM Challenges_Users ORDER BY RAND() LIMIT 1";

	$query3 = mysql_query($sql2);

	$random = mysql_result($query3, 0);
} while ($random == $IdUser);



$insert = "INSERT INTO Challenges_Races (IdChallenge,IdUser,IdAnterior,IdNext,Img,Latitude,Longitude,Distance,Accepted, Normal) 
    VALUES ('" . $IdChallenge . "','" . $IdUser . "','" . $IdAnterior . "','" . $random . "','" . $Img . "','" . $Latitude . "','
    " . $Longitude . "','" . $Distance . "','" . $Accepted . "','" . $Normal . "')";

$query = mysql_query($insert);

$insertrace = "INSERT INTO Challenges_Points (IdChallenge,IdUser)  VALUES ('" . $IdChallenge . "','" . $IdUser . "')";

$query2 = mysql_query($insertrace);

if ($query && $query2) {

	$rows = Array();
	while ($row = mysql_fetch_array($query)) {
		array_push($rows, $row);
	}
	echo json_encode($rows);
} else {
	echo "Race Insert failed";
}
?>