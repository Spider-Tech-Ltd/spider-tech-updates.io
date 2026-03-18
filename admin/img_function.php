<?php 
	function resize($width, $height) {
		// Get original image width and height
		list($w, $h) = getimagesize($_FILES['img']['tmp_name']);
		
		// Calculate new image size with ratio
		$ratio = max($width / $w, $height / $h);
		$new_height = ceil($height / $ratio);
		$x = ($w - $width / $ratio) / 2;
		$new_width = ceil($width / $ratio);
		
		// Set new file name
		$ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
		$new_name = $_SESSION['img_name'] . '.' . $ext; 
		$path = '../images/pictures/' . $new_name;
		
		// If an image with the same name exists, delete it
		if (file_exists($path)) {
			unlink($path);  // Remove the old image
		}
		
		// Read binary data from image file
		$imgString = file_get_contents($_FILES['img']['tmp_name']);
		
		// Create image from the string
		$image = imagecreatefromstring($imgString);
		$tmp = imagecreatetruecolor($width, $height);
		
		// Ensure all coordinates and dimensions are cast to integers
		imagecopyresampled(
			$tmp, $image,
			0, 0,
			(int) $x, 0,
			(int) $width, (int) $height,
			(int) $new_width, (int) $new_height
		);
		
		// Save the resized image to the desired location
		switch ($_FILES['img']['type']) {
			case 'image/jpeg':
			case 'image/JPEG':
				imagejpeg($tmp, $path, 100);
				break;
			case 'image/png':
			case 'image/PNG':
				imagepng($tmp, $path, 0);
				break;
			case 'image/gif':
			case 'image/GIF':
				imagegif($tmp, $path);
				break;
			default:
				exit('Unsupported image format.');
		}
	
		// Cleanup memory
		imagedestroy($image);
		imagedestroy($tmp);
	
		return $path;  // Return the path of the new image
	}
	
?>