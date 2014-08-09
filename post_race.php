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
$Img = $_POST['Img'];

// $IdChallenge = 1;
// $IdUser = 116;
// $Img = 'C_1407363829230.jpg';




do {
	$sql2 = "SELECT Id FROM Challenges_Users ORDER BY RAND() LIMIT 1";

	$query3 = mysql_query($sql2);

	$random = mysql_result($query3, 0);

} while ($random == $IdUser);

$insert = "INSERT INTO Challenges_Races (IdChallenge,IdUser,IdAnterior,IdNext,Img,Latitude,Longitude,Distance,Accepted, Idinicial) 
    VALUES ('" . $IdChallenge . "','" . $IdUser . "','-1','" . $random . "','" . $Img . "','-1','-1','-1','-1','-1')";

$query = mysql_query($insert);

if ($query) {
	echo "Race Insert OK";
}
else {
		echo "Race Insert failed";
}
?>