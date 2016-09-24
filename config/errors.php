<?php 
# This file contains templates for common error/success messages

// Errors
$error_arr['mysqli_error'] = mysqli_error($dbc);
$error_arr['max_size_bytes'] = 5000000; // Change this value to change image upload max size, currently set at 5MB
$error_arr['max_size_mb'] = $error_arr['max_size_bytes'] / 1000000;
$error_arr['upload_image_error'] = "<p>Sorry, your photo could not be uploaded.</p>";
$error_arr['not_an_image_error'] = "<p>Sorry, the file you selected is not an image.</p>";
$error_arr['image_exists_error'] = "<p>Sorry, your photo already exists.<p>";
$error_arr['image_large_error'] = "<p>Sorry, your photo exceeded the file upload limit of $error_arr[max_size_mb]MB.</p>";
$error_arr['image_unspec_error'] = "<p>Sorry, a photo must be uploaded.</p>";
$error_arr['create_listing_error'] = "<p>Listing couldn't be created because: $error_arr[mysqli_error]</p>";
$error_arr['delete_listing_error'] = "<p>Listing couldn't be deleted because: $error_arr[mysqli_error]</p>";

// Successes
$success_arr['create_listing_success'] = "<p>Listing was successfully created</p>";
$success_arr['delete_listing_success'] = "<p>Listing was successfully deleted</p>"
?>