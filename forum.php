<?php
# If user is not logged in, automatically go to login page.
# Start the session:
session_start();
if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}
include 'config/setup.php';
if($_POST) {
	if (isset($_POST['delete'])) {
		$listing_id = $_POST['listing_id'];
		$q = "DELETE FROM retro_items WHERE id = '$listing_id'";
		$r = mysqli_query($dbc, $q);
	} elseif (isset($_POST['submit']) && isset($_POST['action-item'])) {
		$listing_id = $_POST['listing_id'];
		$action_item = $_POST['action-item'];
		$q = "UPDATE retro_items SET action_item='$action_item' WHERE id = '$listing_id'";	
		$r = mysqli_query($dbc, $q);
	}
}
include 'config/variables.php'; // reload site variables for user after sql query executes
$pageid = 11;
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'template/default_head.php'; ?>
	</head>	
	<body>
		<?php include 'template/side.php'; ?><!--Side Navigation here -->
		<?php include 'template/navigation.php'; ?><!--Navigation here -->
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2">
					<h3>Improvements and Action Items</h3>
					<?php	
					$q = "SELECT * FROM retro_items WHERE type = 'improvement'";
					$r = mysqli_query($dbc, $q);
					if(mysqli_num_rows($r) > 0) {
						while($listing = mysqli_fetch_assoc($r)) { 
							$listing_date = $listing['date'];
							$listing_theme = $listing['theme'];
							$listing_desc = $listing['description'];
							$listing_action = $listing['action_item'];
							$listing_id = $listing['id']; ?>
							<div class="panel panel-primary">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-8">
											<div class="container">
												<div class="row">
													<div class="col-md-4">
											    		<p><h4><?php echo $listing_theme; ?></h4></p>
											    	</div>
												</div>
												<div class="row">
													<div class="col-md-4">
													    <p><h4><?php echo $listing_date; ?></h4><p>
													</div>
												</div><!-- END row -->
												<hr>
												<div class="row">
													<h4>Improvement Summary:</h4>
													<div class="col-md-4">
													    <p><h4><?php echo $listing_desc; ?></h4></p>
													</div>
												</div><!-- END row -->
												<hr>
												<? if ($listing_action != "") { ?>
												<div class="row">
													<h4>Action Item:</h4>
													<div class="col-md-4">
													    <p><h4><?php echo $listing_action; ?></h4></p>
													</div>
												</div><!-- END row -->
												<?php }?>
												<div class="row">
													<form action="forum.php" method="post" role="form">
															<button type="submit" class="btn btn-primary" name="delete">Delete</button>
															<input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
													</form>
												</div><!-- END col-md-4-->
											</div>
										</div><!-- END col-md-8-->
									</div><!-- END row -->
								</div><!-- End panel-body -->
							</div><!-- END panel -->
					<?php }
					} else { ?>
						<p>No action items :)</p>
					<?php } ?>
				</div><!-- END col-md-offset-2 -->
			</div><!-- END row -->
		</div><!-- END container-fluid -->
		<?php include 'template/footer.php'; ?> <!-- Footer is here -->
	</body>
</html>