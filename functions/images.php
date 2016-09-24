<?php
# Image related functions will be located here

function rescale_image($src, $dst, $type, $new_h, $new_w) {
	// Get image dimensions
	list($width, $height) = getimagesize($src);
	$ratio = $width/$height;
	if ($new_w/$new_h > $ratio) {
	   $new_w = $new_h * $ratio;
	} else {
	   $new_h = $new_w/$ratio;
	}
	
	// Resample
	$image_p = imagecreatetruecolor($new_w, $new_h);
	switch ($type) {
        case "jpg":
        case "jpeg":
            $image = imagecreatefromjpeg($src);
            break;
        case "gif":
            $image = imagecreatefromgif($src);
            break;
        case "png":
            $image = imagecreatefrompng($src);
            break;
    }
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
	// Output
	switch ($type) {
        case "jpg":
        case "jpeg":
            if(imagejpeg($image_p, $dst, 100)) {
				return true;
			} else return false;
            break;
        case "gif":
            if(imagegif($image_p, $dst)) {
				return true;
			} else return false;
            break;
        case "png":
            if(imagepng($image_p, $dst)) {
				return true;
			} else return false;
            break;
    }
}

function upload_thumbnail($error_arr) {
	# First validate the uploaded image	
	$data = validate_image_upload($error_arr);
	# If 'reason' index has been set, image is not valid
	if($data['success']) {
		if(!rescale_image($_FILES["photos"]["tmp_name"], $data['path'], $data['image_type'], 200, 200)) {
			$data['message'] = $error_arr['upload_image_error'];
			$data['success'] = FALSE;
		}
	}
	return $data;
}
?>