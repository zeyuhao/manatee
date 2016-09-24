<?php
// This functions checks if emails belong to a specific domain e.g jhu.edu
function validate_email_format($email, $expected) {
	// Make sure the address is valid
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// Takes domain part of email after '@'
		$domain = array_pop(explode('@', $email));
		// if domain matches expected
		if ($domain == $expected) {
			return TRUE;
	    } else return FALSE;
	} else return FALSE;
}

// This function checks that the email doesn't already exist in database
function validate_email_unique($email, $dbc) {
	$q = "SELECT * from users WHERE email = '$email'";
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) == 1) {
		return FALSE;
	} else return TRUE;
}

/* 	This function checks if phone numbers are valid, and if so
 *  returns a yyy-yyy-yyyy format number.
 * 
 *  The following formats are allowed:
 *  555 555 5555
 *  (555) 555-5555
 *  (555)555-5555
 *  555-555-5555
 *  555.555.5555
 *  5555555555
 *  0-000-000-0000
 *  0.000.000.0000
 *  0 000 000 0000
 *  00000000000
 *  +0-000-000-0000
 *  +0.000.000.0000
 *  +0 000 000 0000
 *  +00000000000
 */
function validate_phone_format($phone) {
    if (preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/',$phone, $number)) {
    	$number = $number[2] . '-' . $number[3] . '-' . $number[4];
		return $number;
    } else return FALSE;
}

# If failed validation, a message is set. Also, a path index is set.
# If the 'message' index was set, then image validation has failed.
# @param $error_arr the error array with all error and success messages from errors.php
function validate_image_upload ($error_arr) {
	$data['success'] = FALSE;
	if($_FILES['photos']['tmp_name'] != '') {
		if (!isset($_FILES['photos']['error']) || is_array($_FILES['photos']['error'])) {
			throw new RuntimeException('Invalid parameters.');
		}
		switch ($_FILES['photos']['error']) {
		    case UPLOAD_ERR_OK:
		        break;
		    case UPLOAD_ERR_NO_FILE:
		    	$data['message'] = $error_arr['image_unspec_error'];
		    case UPLOAD_ERR_INI_SIZE:
		    case UPLOAD_ERR_FORM_SIZE:
		       	$data['message'] = $error_arr['image_large_error'];
		    default:
		        $data['message'] = $error_arr['upload_image_error'];
		}
		$target_dir = "images/";
		$data['path'] = $target_dir . basename($_FILES["photos"]["name"]);
		$data['image_type'] = pathinfo($data['path'], PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["photos"]["tmp_name"]);
		if($check === false) {
		    $data['message'] = $error_arr['not_an_image_error'];
		}
		// Check if file already exists
		if (file_exists($data['path'])) {
		    $data['message'] = $error_arr['image_exists_error'];
		}
		// Check file size, limit at 5MB
		if ($_FILES["photos"]["size"] > $error_arr['max_size_bytes']) {
		    $data['message'] = $error_arr['image_large_error'];
		}
		// Allow certain file formats
		if($data['image_type'] != "jpg" && $data['image_type'] != "png" && $data['image_type'] != "jpeg" && $data['image_type'] != "gif") {
		    $data['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		}
		if(!isset($data['message']) && isset($data['path']) && isset($data['image_type'])) $data['success'] = TRUE;
	} else $data['message'] = $error_arr['image_unspec_error'];
	return $data;
}
?>