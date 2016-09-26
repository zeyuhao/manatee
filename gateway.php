<?php
# Start Login Session:
session_start();
include 'config/setup.php';
// Redirect user to homepage if already logged in
if(isset($_SESSION['username'])) {
	if ($user['account_type'] == "youth") {
		header('Location: youth.php');
	} elseif ($user['account_type'] == "expert") {
		header('Location: expert.php');
	}	
} else header('Location: login.php');
