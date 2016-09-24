<?php
# Start Login Session:
session_start();
include 'config/setup.php';
// Redirect user to homepage if already logged in
if(isset($_SESSION['username'])) {
	header('Location: gateway.php');	
}
# Check if password and email entered in form match an entry from database
if($_POST) {
	$q = "SELECT * FROM users WHERE email = '$_POST[email]' AND password = SHA1('$_POST[password]')";
	$r = mysqli_query($dbc, $q);
	# if number of rows found with 'username' is found
	if(mysqli_num_rows($r) == 1) {
		# sets arbitrary variable 'username' to the 'email' value
		# index.php will then see that this 'username' value exists	
		$_SESSION['username'] = $_POST['email'];
		# Need to change this location later to return to the page from where login.php was called
		header('Location: gateway.php');
	} else $message = "Invalid email/password entered. Please try again\n\n";
}
?>
<!DOCTYPE html>
<html>	
	<head>
		<?php include 'template/default_head.php'; ?>
	</head>
	<body>
		<?php include 'template/navigation-full.php'; ?><!--Navigation here -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-primary">
						<div class="panel-heading"><h3><?php echo $page['header']; ?></h3></div><!-- END Panel Heading -->
						<div class ="panel-body">
							<div class="tmp-msg">
								<?php if (isset($message)) { echo nl2br($message); } ?>
							</div>
							<form action="login.php" method="post" role="form">
								<div class="form-group">
									<label for="email">Email address</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="Valid Email Address" required="email">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
								    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
								</div>
								<button type="submit" class="btn btn-default">Submit</button>
							</form><!-- END Form -->
						</div><!-- END Panel Body -->
					</div><!-- END Panel Main -->
				</div><!-- END Column -->
			</div><!-- END Row -->
		</div>
		<?php include 'template/footer-full.php'; ?> <!-- Footer is here -->
	</body>
</html>