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

$fbid = $_POST['FbId'];
$img = $_POST['Img'];

$password = $_POST['password'];
$firstname = $_POST['Firstname'];
$lastname = $_POST['Lastname'];
$email = $_POST['Email'];
$country = $_POST['Country'];
$city = $_POST['City'];
$longitude = $_POST['Longitude'];
$latitude = $_POST['Latitude'];
$status = $_POST['Status'];

$sql = "SELECT Id FROM Challenges_Users WHERE FbId = '$fbid'";

$query = mysql_query($sql);


if (mysql_num_rows($query) > 0) {

	
	$update = "UPDATE Challenges_Users SET Longitude='$longitude', Latitude='$latitude',Country='$country'  WHERE FbId='$fbid'";

	$query1 = mysql_query($update);

	if ($query1) {
		echo mysql_result($query, 0);
		;
	} else {
		echo "Insert Update Failed";
	}

} else {
	$insert = "INSERT INTO Challenges_Users (FbId,Img,Password,Firstname,Lastname,Email,Country, Longitude, Latitude,Status) 
    VALUES ('$fbid','$img','$password','$firstname','$lastname','$email','$country','$longitude','$latitude','$status')";

	$query = mysql_query($insert);
	if ($query) {
		echo "User Saved.";
	} else {
		echo "Insert failed";
	}
}
?>