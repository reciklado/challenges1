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

$target = getcwd();
$target = $target . '/images/' . $_POST['randomFilename'];

if (move_uploaded_file($_FILES['media']['tmp_name'], $target)) {

	$filename = $target;

	//Get dimensions of the original image

	list($current_width, $current_height) = getimagesize($filename);

	// The x and y coordinates on the original image where we  will begin cropping the image
	$left = 0;
	$top = 0;

	//This will be the final size of the image (e.g how many pixesl left and down we will be doing)
	$crop_width = $current_width;
	$crop_height = $current_height;

	//Resample the image
	$canvas = imagecreatetruecolor($crop_width, $crop_height);
	$current_image = imagecreatefromjpeg($filename);
	imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
	imagejpeg($canvas, $filename, 100);

	

} else {

	echo "0";
}
?>