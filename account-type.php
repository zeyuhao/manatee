<?php 
session_start();
if (isset($_SESSION['account_created'])) {
	header('Location: index.php');
}
include 'config/setup.php';
// If user submits form
if ($_POST) {
	if (isset($_POST['submitted_youth']) == 1) {
		$type = "youth";
		$q = "UPDATE users SET account_type='$type' WHERE email='$user[email]'";
		if (mysqli_query($dbc, $q)) {
			$_SESSION['account_created'] = true;
			header('Location: youth.php');
		}  else {
			$q = "DELETE from users WHERE email='$user[email]'";
			$r = mysqli_query($dbc, $q);
			$message = '<p>Your account could not be added because: '.mysqli_error($dbc).'</p>';
		}	
	} else if (isset($_POST['submitted_expert']) == 1) {
		$type = "expert";
		$q = "UPDATE users SET account_type='$type' WHERE email='$user[email]'";
		if (mysqli_query($dbc, $q)) {
			header('Location: about.php');
		}  else {
			$q = "DELETE from users WHERE email='$user[email]'";
			$r = mysqli_query($dbc, $q);
			$message = '<p>Your account could not be added because: '.mysqli_error($dbc).'</p>';
		}
	}
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
						<div class="panel-heading"><h3>I am a ...</h3></div><!-- END Panel Heading -->
						<div class ="panel-body">
							<div class="row">
								<div class="col-md-2 col-md-offset-1">
									<form action="" method="post" role="form">
										<button type="submit" class="btn btn-default">Youth</button>
										<input type="hidden" name="submitted_youth" value="1">
									</form><!-- End youth form -->
								</div><!-- End youth div -->
								<div class="col-md-2 col-md-offset-5">
									<form action="" method="post" role="form">
										<button type="submit" class="btn btn-default">Career Expert</button>
										<input type="hidden" name="submitted_expert" value="1">
									</form><!-- End expert form -->
								</div><!-- End expert div -->
							</div><!-- End Button row -->
						</div><!-- End panel-body -->
					</div><!-- End panel -->
				</div><!-- End col-md-6 col-md-offset-3 -->
			</div><!-- End row -->
		</div><!-- End container-fluid -->
		<?php include 'template/footer-full.php'; ?> <!-- Footer is here -->
	</body>
</html>