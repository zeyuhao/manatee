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
				<div class="col-md-offset-2 col-md-4">
					<h3>What went well</h3>
					<?php	
					$q = "SELECT * FROM retro_items WHERE type = 'went-well'";
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
												<div class="row">
													<div class="col-md-4">
													    <p><h4><?php echo $listing_desc; ?></h4></p>
													</div>
												</div><!-- END row -->
											</div>
										</div><!-- END col-md-8-->
										<div class="col-md-4">
											<form action="expert.php" method="post" role="form">
												<div class="col-md-1 col-md-offset-6">
													<button type="submit" class="btn btn-primary" name="delete">
														<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
													</button>
													<input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
												</div>
											</form>
										</div><!-- END col-md-4-->
									</div><!-- END row -->
								</div><!-- End panel-body -->
							</div><!-- END panel -->
					<?php }
					} else { ?>
						<p>No team members think anything went well :(</p>
					<?php } ?>
				</div><!-- End col-md-3 -->
				<div class="col-md-6">
					<h3>What really needs improvement</h3>
					
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
											</div>
										</div><!-- END col-md-8-->
										<div class="col-md-4">
											<div class="row">
												<div class="col-md-1">
													<button class="btn btn-primary btn-expert-action-item-add" name="add-action">
														<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add Action Item</button>
													</button>
												</div>
												<div class="col-md-offset-3">
													<form action="expert.php" method="post" role="form">
														<div class="col-md-1 col-md-offset-7">
															<button type="submit" class="btn btn-primary" name="delete">
																<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
															</button>
															<input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
														</div>
													</form>
												</div>
											</div>
										</div><!-- END col-md-4-->
									</div><!-- END row -->
								</div><!-- End panel-body -->
							</div><!-- END panel -->
							<div class="panel panel-primary form-expert-action-item">
								<div class="panel-body">
									<form action="expert.php" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
										<div class="form-group">
											<label for="description" class="col-sm-2 control-label"></label>
										    <div class="col-sm-6">
										    	<textarea class="form-control" id="action-item-description" name="action-item" 
										    		required="yes" placeholder="Describe the action item" rows="8"></textarea>
											</div>
										</div><!-- END form-group -->
											<div class="col-sm-offset-2">
											<button type="submit" class="btn btn-default" id="btn-expert-action-item-submit" name="submit">Submit</button>
											<button type="reset" class="btn btn-default btn-expert-action-item-cancel">Cancel</button>
											<input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
										</div>
									</form>
								</div><!-- End panel-body -->
							</div><!-- END panel -->
					<?php }
					} else { ?>
						<p>No team members think anything needs improvement :)</p>
					<?php } ?>
				</div><!-- End col-md-3 -->
			</div><!-- END row -->
		</div><!-- END container-fluid -->
		<?php include 'template/footer.php'; ?> <!-- Footer is here -->
	</body>
</html>