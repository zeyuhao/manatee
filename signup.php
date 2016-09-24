<?php
session_start();
if (isset($_SESSION['username'])) {
	header('Location: index.php');
}
include 'config/setup.php';
// If user submits form
if (isset($_POST['submitted']) == 1) {
	$first = mysqli_real_escape_string($dbc, $_POST['first']);
	$last = mysqli_real_escape_string($dbc, $_POST['last']);
	// Trim the email so no whitespace occurs
	$email = trim(mysqli_real_escape_string($dbc, $_POST['email']));
	$password = SHA1(mysqli_real_escape_string($dbc, $_POST['password']));
	// If email is a valid jhu.edu address and doesn't already exist in database
	if (validate_email_unique($email, $dbc)) {
		$q = "INSERT INTO users (first, last, email, password) VALUES ('$first', '$last', '$email', '$password')";
		$r = mysqli_query($dbc, $q);
		if ($r) {
			$_SESSION['username'] = $email;
			header('Location: account-type.php');
		} else $message = '<p>Your account could not be added because: '.mysqli_error($dbc).'</p>';
	} else $message = '<p>This email has already been registered to previous account</p>';
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'template/default_head.php'; ?>
	</head>
	<body>
		<?php include 'template/navigation-full.php'; ?><!--Navigation here -->
		<!-- Page form created here -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-primary">
						<div class="panel-heading"><h3><?php echo $page['header']; ?></h3></div><!-- END Panel Heading -->
						<div class ="panel-body">
							<div class="tmp-msg">
								<?php if (isset($message)) { echo $message; } ?>
							</div>
							<form action="signup.php" method="post" role="form">
								<div class="form-group">
									<label for="title">First:</label>
									<input class="form-control" type="text" name="first" id="first" placeholder="First Name" required>
								</div>
								<!-- User select form below -->
								<div class="form-group">
									<label for="label">Last:</label>
									<input class="form-control" type="text" name="last" id="last" placeholder="Last Name" required>
								</div>
								<div class="form-group">
									<label for="label">Email:</label>
									<input class="form-control" type="email" name="email" id="email" placeholder="Valid Email Address" required>
								</div>
								<div class="form-group">
									<label for="header">Password:</label>
									<input class="form-control" type="text" name="password" id="password" placeholder="Password" required>
								</div>
								<button type="submit" class="btn btn-default">Sign Up</button>
								<!-- Reason we are using the field below is in case we have more than one submit button -->
								<!-- so we know which one was pressed -->
								<input type="hidden" name="submitted" value="1">
							</form><!-- End form -->
						</div><!-- End panel-body -->
					</div><!-- End panel -->
				</div><!-- End col-md-6 col-md-offset-3 -->
			</div><!-- End row -->
		</div><!-- End container-fluid -->
		<?php include 'template/footer-full.php'; ?> <!-- Footer is here -->
	</body>
</html>
