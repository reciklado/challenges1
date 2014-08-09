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

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

	$theta = $lon1 - $lon2;

	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));

	$dist = acos($dist);

	$dist = rad2deg($dist);

	$miles = $dist * 60 * 1.1515;

	$unit = strtoupper($unit);

	if ($unit == "K") {

		return ($miles * 1.609344);

	} else if ($unit == "N") {

		return ($miles * 0.8684);

	} else {

		return $miles;

	}

}

// $accepted = 0;
// $created = '2014-08-06 23:27:00';

$accepted = $_POST['Accepted'];
$created = $_POST['Created'];

$select = "SELECT * FROM Challenges_Races WHERE Created = '$created'";
$query1 = mysql_query($select);

if ($accepted == 1) {
	echo('passei');

	if (mysql_num_rows($query1) == 1) {

		$row123 = mysql_fetch_array($query1);
		$idgrupo = $row123['IdInicial'];
		echo($idgrupo);

		//GET LATITUDE AND LONGITUDE FROM SENDER
		$selectuser = "SELECT Latitude, Longitude FROM Challenges_Users WHERE Id = '" . $row123['IdUser'] . "'";
		$queryuser = mysql_query($selectuser);
		$latuser1 = mysql_fetch_array($queryuser);
		$latuser = $latuser1['Latitude'];
		$longuser = $latuser1['Longitude'];
		//
		//GET LATITUDE AND LONGITUDE FROM RECEIVER
		$selectsorteado = "SELECT Latitude, Longitude FROM Challenges_Users WHERE Id = '" . $row123['IdNext'] . "'";
		$querysorteado = mysql_query($selectsorteado);
		$latsort1 = mysql_fetch_array($querysorteado);
		$latsort = $latsort1['Latitude'];
		$longsort = $latsort1['Longitude'];
		//
		//
		//CALCULA OS KILOMETROS ENTRE AS DUAS COORDENADAS
		$distance = distance($latuser, $longuser, $latsort, $longsort, "K");
		//
		//
		//ACTUALIZA COM DADOS E ACEITE
		$update = "UPDATE Challenges_Races SET Accepted='$accepted', Latitude='$latsort', Longitude='$longsort', Distance='$distance' WHERE Created='$created'";
		$query = mysql_query($update);

		do {
			$sql2 = "SELECT Id FROM Challenges_Users ORDER BY RAND() LIMIT 1";

			$query3 = mysql_query($sql2);
			$random = mysql_result($query3, 0);

		} while ($random == $row123['IdNext']);

		//INSERE UM NOVO
		$insert = "INSERT INTO Challenges_Races (IdChallenge,IdUser,IdAnterior,IdNext,Img,Latitude,Longitude,Distance,Accepted) 
    VALUES ('" . $row123['IdChallenge'] . "','" . $row123['IdUser'] . "','" . $row123['IdNext'] . "','" . $random . "','" . $row123['Img'] . "','-1','-1','-1','-1')";

		$query3 = mysql_query($insert);

		//ACTUALIZA PONTOS

		$sqlidpoints = "SELECT * FROM Challenges_Points WHERE Id = '" . $row123['Id'] . "'";
		$sqlidpoints1 = mysql_query($sqlidpoints);

		if (mysql_num_rows($sqlidpoints1) > 0) {

			$finaldistance = $distance + $sqlidpoints1['Distance'];
			$update = "UPDATE Challenges_Points SET Distance ='" . $distance . "' WHERE Id='" . $row123['Id'] . "'";
			$query55 = mysql_query($update);

		} else {

			$insertrace = "INSERT INTO Challenges_Points (Id,IdUser)  VALUES ('" . $row123['Id'] . "','" . $row123['IdUser'] . "')";
			$query55 = mysql_query($insertrace);
		}

		//MARCA RESTANTES COMO INVALIDOS
		$select = "SELECT * FROM Challenges_Races WHERE IdInicial = '$idgrupo'";
		$query1 = mysql_query($select);

		while ($row = mysql_fetch_array($query1)) {
			if ($row['Accepted'] == -1) {

				$update = "UPDATE Challenges_Races SET Accepted='-2' WHERE Id='" . $row['Id'] . "'";
				$query2 = mysql_query($update);

			}
		}

	}

}

if ($accepted == 0) {

	$row123 = mysql_fetch_array($query1);
	$idgrupo = $row123['IdInicial'];
	echo($idgrupo);
	//
	echo(mysql_num_rows($query1));
	if (mysql_num_rows($query1) == 1) {
		echo("passei1");

		//GET LATITUDE AND LONGITUDE FROM SENDER
		$selectuser = "SELECT Latitude, Longitude FROM Challenges_Users WHERE Id = '" . $row123['IdUser'] . "'";
		$queryuser = mysql_query($selectuser);
		$latuser1 = mysql_fetch_array($queryuser);
		$latuser = $latuser1['Latitude'];
		$longuser = $latuser1['Longitude'];
		//
		//GET LATITUDE AND LONGITUDE FROM RECEIVER
		$selectsorteado = "SELECT Latitude, Longitude FROM Challenges_Users WHERE Id = '" . $row123['IdNext'] . "'";
		$querysorteado = mysql_query($selectsorteado);
		$latsort1 = mysql_fetch_array($querysorteado);
		$latsort = $latsort1['Latitude'];
		$longsort = $latsort1['Longitude'];
		//
		//
		//CALCULA OS KILOMETROS ENTRE AS DUAS COORDENADAS
		$distance = distance($latuser, $longuser, $latsort, $longsort, "K");

		$select = "SELECT * FROM Challenges_Races WHERE IdInicial = '$idgrupo'";
		$query1 = mysql_query($select);

		if ($idgrupo != -1) {

			echo("passei2");

			$update = "UPDATE Challenges_Races SET Accepted='$accepted', Latitude='$latsort', Longitude='$longsort', Distance='$distance' WHERE Created='$created'";
			$query = mysql_query($update);

		} else {
			echo("passei3");

			$update = "UPDATE Challenges_Races SET Accepted='$accepted', Latitude='$latsort', Longitude='$longsort', Distance='$distance' WHERE Created='$created'";
			$query = mysql_query($update);

			for ($i = 1; $i < 4; $i++) {

				do {
					$sql2 = "SELECT Id FROM Challenges_Users ORDER BY RAND() LIMIT 1";

					$query3 = mysql_query($sql2);
					$random = mysql_result($query3, 0);

				} while ($random == $query1['IdUser']);

				$insert = "INSERT INTO Challenges_Races (IdChallenge,IdUser,IdAnterior,IdNext,Img,Latitude,Longitude,Distance,Accepted,IdInicial)
VALUES ('" . $row123['IdChallenge'] . "','" . $row123['IdUser'] . "','" . $row123['IdNext'] . "','" . $random . "','" . $row123['Img'] . "','-1','-1','-1','-1','" . $row123['Id'] . "')";

				$query3 = mysql_query($insert);
			}
		}
	}

}
?>