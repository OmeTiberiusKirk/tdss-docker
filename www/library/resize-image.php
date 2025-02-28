<?php
	
		// The file
	$filename = $_REQUEST['filename'];
	$width = $_REQUEST['width'];
	$height = $_REQUEST['height'];
	
	// Content type
	header('Content-type: image/jpeg');
	
	// Get new dimensions
	list($width_orig, $height_orig) = getimagesize($filename);

	// Resample
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefromjpeg($filename);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	
	// Output
	imagejpeg($image_p);
?>