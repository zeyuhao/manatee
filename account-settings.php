<?php
# If user is not logged in, automatically go to login page.
# Start the session:
session_start();
if(!isset($_SESSION['username'])) {
	header('Location: index.php');
}
include 'config/setup.php';
// Check if form submitted, and execute corresponding account changes
if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
	$first = mysqli_real_escape_string($dbc, $_POST['firstname']);
	$last = mysqli_real_escape_string($dbc, $_POST['lastname']);	
	$q = "UPDATE users SET first='$first', last='$last' WHERE email='$user[email]'";
	if(mysqli_query($dbc, $q)) {
		$message = "Successfully updated your name";
	} else $message = '<p>Your name could not be changed because: '.mysqli_error($dbc).'</p>';
} elseif (isset($_POST['email'])) {
	$email = trim(mysqli_real_escape_string($dbc, $_POST['email']));
	if (validate_email_unique($email, $dbc)) {
		$q = "UPDATE users SET email='$email' WHERE email='$user[email]'";
		if (mysqli_query($dbc, $q)) {
			$message = '<p>Please verify your email to complete the last step in changing your email</p>';
			$_SESSION['username'] = $email; // set session username to new email
		} else $message = '<p>Your email could not be changed because: '.mysqli_error($dbc).'</p>';
	} else $message = '<p>This email has already been registered to a previous account</p>';
} elseif (isset($_POST['phone'])) {
	$phone = mysqli_real_escape_string($dbc, $_POST['phone']);
	if ($phone = validate_phone_format($phone)) {	
		$q = "UPDATE users SET phone_primary='$phone' WHERE email='$user[email]'";
		if (mysqli_query($dbc, $q)) {
			$message = "Successfully updated your phone number";
		} else $message = '<p>Your phone number could not be changed because: '.mysqli_error($dbc).'</p>';
	} else $message = '<p>A valid phone number format is required</p>';
} elseif (isset($_POST['password']) and isset($_POST['confirm-password'])) {
	if ($_POST['password'] == $_POST['confirm-password']) {
		$password = SHA1(mysqli_real_escape_string($dbc, $_POST['password']));	
		$q = "UPDATE users SET password='$password' WHERE email='$user[email]'";
		if (mysqli_query($dbc, $q)) {
			$message = "Successfully updated your password";
		} else $message = "<p>Your password could not be changed because: '.mysqli_error($dbc).'</p>";
	} else $message = "<p>You must correctly confirm your new password<p>";
} elseif (isset($_POST['submitted_youth']) == 1) {
	$type = "youth";
	$q = "UPDATE users SET account_type='$type' WHERE email='$user[email]'";
	if (mysqli_query($dbc, $q)) {
		$message = "Successfully updated your account type";
	} else $message = "<p>Your account type could not be changed because: '.mysqli_error($dbc).'</p>";
} elseif (isset($_POST['submitted_expert']) == 1) {
	$type = "expert";
	$q = "UPDATE users SET account_type='$type' WHERE email='$user[email]'";
	$r = mysqli_query($dbc, $q);
	if (mysqli_query($dbc, $q)) {
		$message = "Successfully updated your account type";
	} else $message = "<p>Your account type could not be changed because: '.mysqli_error($dbc).'</p>";
}
include 'config/variables.php'; // reload site variables for user after sql query executes
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'template/account_head.php'; ?>
	</head>
		
	<body>
		<?php include 'template/side.php'; ?><!--Side Navigation here -->
		<?php include 'template/navigation.php'; ?><!--Navigation here -->
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">
							<?php include 'template/page_header.php'; ?>
							<div class="list-group">
								<a class="list-group-item">
									<div class="tmp-msg-5">
										<?php if (isset($_POST['firstname']) && isset($_POST['lastname'])) { if (isset($message)) { echo $message; } }?>
									</div>
									<div id="account-settings-name">
										<div id="account-settings-name-data">
											<button class="btn btn-default pull-right" id="btn-account-name-edit">Edit</button>
											<?php echo "Name:"; ?>
											<p class="list-group-item-text"><?php echo $user['fullname']; ?></p>
										</div><!-- END account-settings-name-data div -->
										<div id="form-account-name">
											<div class="row">
												<div class="form-account-name-heading">
													<div class="col-sm-10 col-sm-offset-1">
														<h4>Change your name</h4>
													</div>
												</div><!-- END form-account-name-heading div -->
											</div><!-- End row -->
											<form action="account-settings.php" class="form-horizontal" method="post" role="form">
												<div class="form-group">
													<label for="firstname" class="col-sm-2 control-label">First</label>
													<div class="col-sm-6">
														<input class="form-control" id="firstname" name="firstname"
															placeholder="Your first name" required="yes">
													</div>
												</div>
												<div class="form-group">
													<label for="lastname" class="col-sm-2 control-label">Last</label>
												    <div class="col-sm-6">
												    	<input class="form-control" id="lastname" name="lastname"
												    		placeholder="Your last name" required="yes">
													</div>
												</div>
												<div class="col-sm-offset-2">
													<button type="submit" class="btn btn-default" id="btn-account-name-submit">Submit</button>
													<button type="reset" class="btn btn-default" id="btn-account-name-cancel">Cancel</button>
												</div>
											</form><!-- END Form -->
										</div><!-- END form-account-name div -->
									</div><!-- END account-settings-name div -->
								</a><!-- END list-group-item for name -->
								<a class="list-group-item">
									<div class="tmp-msg-5">
										<?php if (isset($_POST['email'])) { if (isset($message)) { echo $message; } } ?>
									</div>
									<div id="account-settings-email">
										<div id="account-settings-email-data">
											<button class="btn btn-default pull-right" id="btn-account-email-edit">Edit</button>
											<?php echo "Email:"; ?>
											<p class="list-group-item-text"><?php echo $user['email']; ?></p>
										</div><!-- END account-settings-email-data div -->
										<div id="form-account-email">
											<div class="row">
												<div class="form-account-edit-heading">
													<div class="col-sm-10 col-sm-offset-1">
														<h4>Change your email</h4>
													</div>
												</div><!-- END form-account-email-heading div -->
											</div><!-- END row -->
											<form action="account-settings.php" class="form-horizontal" method="post" role="form">
												<div class="form-group">
													<label for="email" class="col-sm-2 control-label">Email</label>
													<div class="col-sm-6">
														<input type="email" class="form-control" id="email" name="email" 
															placeholder="Valid email address" required="yes">
													</div>
												</div>
												<div class="col-sm-offset-2">
													<button type="submit" class="btn btn-default" id="btn-account-email-submit">Submit</button>
													<button type="reset" class="btn btn-default" id="btn-account-email-cancel">Cancel</button>
												</div>
											</form><!-- END Form -->
										</div><!-- END form-account-email div -->
									</div><!-- END account-settings-email div -->
								</a><!-- END list-group-item for email -->
								<a class="list-group-item">
									<div class="tmp-msg-5">
										<?php if (isset($_POST['phone'])) { if (isset($message)) { echo $message; } } ?>
									</div>
									<div id="account-settings-phone">
										<div id="account-settings-phone-data">
											<?php
												// If no phone number is set
												if (empty($user['phone_primary'])) {
													$phone_button = "Add";
													$phone_msg = "Add a phone number";
												} else {
													$phone_button = "Edit";
													$phone_msg = $user['phone_primary'];
												}
											?>
											<button class="btn btn-default pull-right" id="btn-account-phone-edit"><?php echo $phone_button ?></button>
											<?php echo "Phone:"; ?>
											<p class="list-group-item-text"><?php echo $phone_msg; ?></p>
										</div><!-- END account-settings-phone-data div -->
										<div id="form-account-phone">
											<div class="row">
												<div class="form-account-edit-heading">
													<div class="col-sm-10 col-sm-offset-1">
														<h4>Change/Add your phone number</h4>
													</div>
												</div><!-- END form-account-phone-heading div -->
											</div><!-- End row -->
											<form action="account-settings.php" class="form-horizontal" method="post" role="form">
												<div class="form-group">
													<label for="phone" class="col-sm-2 control-label">Phone</label>
													<div class="col-sm-6">
														<!-- input type of 'tel' only works in safari -->
														<input type="tel" class="form-control" id="phone" name="phone" 
															placeholder="Valid primary phone number" required="yes">
													</div>
												</div>
												<div class="col-sm-offset-2">
													<button type="submit" class="btn btn-default" id="btn-account-phone-submit">Submit</button>
													<button type="reset" class="btn btn-default" id="btn-account-phone-cancel">Cancel</button>
												</div>
											</form><!-- END Form -->
										</div><!-- END form-account-phone div -->
									</div><!-- END account-settings-phone div -->
								</a><!-- END list-group-item for phone -->
								<a class="list-group-item">
									<div class="tmp-msg-5">
										<?php if (isset($_POST['password'])) { if (isset($message)) { echo $message; } } ?>
									</div>
									<div id="account-settings-password">
										<div id="account-settings-password-data">
											<button class="btn btn-default pull-right" id="btn-account-password-edit">Edit</button>
											<?php echo "Password:"; ?>
											<p class="list-group-item-text"><?php echo "***********"; ?></p>
										</div><!-- END account-settings-password-data div -->
										<div id="form-account-password">
											<div class="row">
												<div class="form-account-edit-heading">
													<div class="col-sm-10 col-sm-offset-1">
														<h4>Change your password</h4>
													</div>
												</div><!-- END form-account-password-heading div -->
											</div><!-- End row -->
											<form action="account-settings.php" class="form-horizontal" method="post" role="form">
												<div class="form-group">
													<label for="password" class="col-sm-2 control-label">Password</label>
													<div class="col-sm-6">
														<div class="form-group">
															<input type="password" class="form-control" id="password" name="password" 
																placeholder="New password" required="yes">
														</div>
														<div class="form-group">
															<input type="password" class="form-control" id="confirm-password" name="confirm-password" 
																placeholder="Confirm new password" required="yes">
														</div>
													</div>
												</div>
												<div class="col-sm-offset-2">
													<button type="submit" class="btn btn-default" id="btn-account-password-submit">Submit</button>
													<button type="reset" class="btn btn-default" id="btn-account-password-cancel">Cancel</button>
												</div>
											</form><!-- END Form -->
										</div><!-- END form-account-password div -->
									</div><!-- END account-settings-password div -->
								</a><!-- END list-group-item for password -->
								<a class="list-group-item">
									<div class="tmp-msg-5">
										<?php if (isset($_POST['account_type'])) { if (isset($message)) { echo $message; } } ?>
									</div>
									<div id="account-settings-account-type">
										<div id="account-settings-account-type-data">
											<button class="btn btn-default pull-right" id="btn-account-type-edit">Edit</button>
											<?php echo "Account Type:"; ?>
											<p class="list-group-item-text"><?php echo $user['account_type']; ?></p>
										</div><!-- END account-settings-account-type-data div -->
										<div id="form-account-type">
											<div class="row">
												<div class="form-account-edit-heading">
													<div class="col-sm-10 col-sm-offset-1">
														<h4>Change your account type</h4>
													</div>
												</div><!-- END form-account-password-heading div -->
											</div><!-- End row -->
											<div class="row">
												<div class="col-md-2 col-md-offset-1">
													<form action="" method="post" role="form">
														<button type="submit" class="btn btn-default">Youth</button>
														<input type="hidden" name="submitted_youth" value="1">
													</form><!-- End youth form -->
													<form action="" method="post" role="form">
														<button type="submit" class="btn btn-default">Expert</button>
														<input type="hidden" name="submitted_expert" value="1">
													</form><!-- End expert form -->
												</div><!-- End div -->
											</div><!-- End Button row -->
											<div class="row">
												<div class="col-md-2">
													<button type="reset" class="btn btn-default" id="btn-account-type-cancel">Cancel</button>
												</div>
											</div>
										</div><!-- END form-account-password div -->
									</div><!-- END account-settings-password div -->
								</a><!-- END list-group-item for password -->
							</div><!-- End list-group -->
						</div>
					</div><!-- END panel -->
				</div><!-- End col-md-3 -->
			</div><!-- End row -->
		</div><!-- End container -->
		<?php include 'template/footer.php'; ?> <!-- Footer is here -->
	</body>
	
</html>