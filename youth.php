<?php
# If user is not logged in, automatically go to login page.
# Start the session:
session_start();
if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}
include 'config/setup.php';
if($_POST) {
	if (isset($_POST['youth-question-title'])) {
		$description = $_POST['youth-question-title'];
		$user = $user['email'];
		$q = "INSERT INTO questions (description, user, theme, type, date) 
			  VALUES ('$description', '$user', 'went-well', CURDATE())";
		$r = mysqli_query($dbc, $q);
	} elseif (isset($_POST['youth-specific-title'])) {
		$description = $_POST['youth-specific-title'];
		$user = $user['email'];
		$q = "INSERT INTO questions (description, user, theme, type, date) 
			  VALUES ('$description', '$user', 'improvement', CURDATE())";
		$r = mysqli_query($dbc, $q);
	} elseif (isset($_POST['delete'])) {
		$listing_id = $_POST['listing_id'];
		$q = "DELETE FROM questions WHERE id = '$listing_id'";
		$r = mysqli_query($dbc, $q);	
	}
}
include 'config/variables.php'; // reload site variables for user after sql query executes
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'template/default_head.php'; ?>
	</head>	
	<body>
		<?php include 'template/side.php'; ?><!--Side Navigation here -->
		<?php include 'template/navigation.php'; ?><!--Navigation here -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-offset-2">
					<div class="row">
						<div class="container">
							<br></br>
							<div id="youth-btns">
								<button type="submit" class="btn btn-primary" id="btn-youth-general">General Question</button>
								<button type="submit" class="btn btn-primary" id="btn-youth-specific">Career Specific</button>
							</div>
							<br></br>
							<div class="panel panel-primary">
								<div class="panel-body">
									<form action="youth.php" class="form-horizontal" id="form-youth-general" method="post" role="form" enctype="multipart/form-data">
										<div class="form-group">
											<label for="description" class="col-sm-2 control-label">Title</label>
										    <div class="col-sm-6">
										    	<textarea class="form-control" id="youth-general-title" name="youth-general-title" 
										    		required="yes" placeholder="What is your question?" rows="2"></textarea>
											</div>
										</div><!-- END form-group -->
										<div class="col-sm-offset-2">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="reset" class="btn btn-primary">Clear</button>
										</div>
									</form>
									<form action="youth.php" class="form-horizontal" id="form-youth-specific" method="post" role="form" enctype="multipart/form-data">
										<div class="form-group">
											<label for="description" class="col-sm-2 control-label">Title</label>
										    <div class="col-sm-6">
										    	<textarea class="form-control" id="youth-specific-title" name="youth-specific-title" 
                                                    required="yes" placeholder="What is your question?" rows="2"></textarea>
											</div>
										</div><!-- END form-group -->
										<div class="form-group">
											<label for="condition" class="col-sm-2 control-label">Type</label>
										    <div class="col-sm-6">
										    	<select class="form-control" type="text" name="theme-needs-improvement" id="theme-needs-improvement" required="yes">
													<option value = "Community Presence">Community Presence</option>
													<option value = "Code Reviews">Code Reviews</option>
													<option value = "Web UI">Web UI</option>
													<option value = "Prioritization">Prioritization</option>
													<option value = "Deployments">Deployments</option>
													<option value = "Refactoring">Refactoring</option>
													<option value = "API Docs">API Docs</option>
													<option value = "Optimization">Optimization</option>
													<option value = "Partnerships">Partnerships</option>
													<option value = "Users and Roles">Users and Roles</option>
													<option value = "Backlog">Backlog</option>
													<option value = "Meetings">Meetings</option>
													<option value = "Lunch and Learns">Lunch and Learns</option>
													<option value = "Tech Debt">Tech Debt</option>
													<option value = "Team Communication">Team Communication</option>
													<option value = "Functional Tests">Functional Tests</option>
													<option value = "Unit Tests">Unit Tests</option>
													<option value = "Other">Other</option>
												</select>
											</div>
										</div><!-- END form-group -->
										<div class="col-sm-offset-2">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="reset" class="btn btn-primary">Clear</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div><!-- END row -->
					<div class="row">
						<div class="container">
							<div class="row">
								<div class="col-md-6">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title">What you thought went well</h3>
										</div>
										<div class="panel-body">
										<?php	
										$q = "SELECT * FROM questions WHERE type = 'went-well' AND user = '$user[email]'";
										$r = mysqli_query($dbc, $q);
										if(mysqli_num_rows($r) > 0) {
											while($listing = mysqli_fetch_assoc($r)) { 
												$listing_date = $listing['date'];
												$listing_theme = $listing['theme'];
												$listing_desc = $listing['description'];
												$listing_id = $listing['id']; ?>
												<div class="row">
													<div class="col-md-4">
													    <p><?php echo $listing_theme; ?></p>
													</div>
													<div class="col-md-offset-5 col-md-3">
													    <p><?php echo $listing_date; ?><p>
													</div>
												</div><!-- END row -->
												<div class="row">
													<div class="col-md-8">
													    <p><?php echo $listing_desc; ?></p>
													</div>
													<form action="youth.php" method="post" role="form">
														<div class="col-md-1 col-md-offset-1">
															<button type="submit" class="btn btn-primary" name="delete">Delete</button>
															<input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
														</div>
													</form>
												</div><!-- END row -->
												<hr><!-- Horizontal line between listings -->
										<?php }
										} else { ?>
											<p>You don't think anything went well :(</p>
										<?php } ?>
										</div><!-- End panel-body -->
									</div><!-- End panel -->
								</div><!-- END col md -->
								<div class="col-md-6">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title">What you thought needs improvement</h3>
										</div>
										<div class="panel-body">
										<?php	
										$q = "SELECT * FROM questions WHERE type = 'improvement' AND user = '$user[email]'";
										$r = mysqli_query($dbc, $q);
										if(mysqli_num_rows($r) > 0) {
											while($listing = mysqli_fetch_assoc($r)) { 
												$listing_date = $listing['date'];
												$listing_theme = $listing['theme'];
												$listing_desc = $listing['description'];
												$listing_id = $listing['id']; ?>
												<div class="row">
													<div class="col-md-4">
													    <p><?php echo $listing_theme; ?></p>
													</div>
													<div class="col-md-offset-5 col-md-3">
													    <p><?php echo $listing_date; ?><p>
													</div>
												</div><!-- END row -->
												<div class="row">
													<div class="col-md-8">
													    <p><?php echo $listing_desc; ?></p>
													</div>
													<form action="youth.php" method="post" role="form">
														<div class="col-md-1 col-md-offset-1">
															<button type="submit" class="btn btn-primary" name="delete">Delete</button>
															<input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
														</div>
													</form>
												</div><!-- END row -->
												<hr><!-- Horizontal line between listings -->
										<?php }
										} else { ?>
											<p>You don't think anything needs improvement :)</p>
										<?php } ?>
										</div><!-- End panel-body -->
									</div><!-- End panel -->
								</div><!-- END col md -->
							</div><!-- END row -->
						</div><!-- End container -->
					</div><!-- END row -->
				</div>
			</div>
		</div>
		<?php include 'template/footer.php'; ?> <!-- Footer is here -->
	</body>
</html>