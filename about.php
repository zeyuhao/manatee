<?php 
session_start();
if (isset($_SESSION['account_created'])) {
	header('Location: index.php');
}
include 'config/setup.php';
// If user submits form
if ($_POST) {
	if (isset($_POST['expert-bio']) && isset($_POST['expert-skills'])) {
		$bio = $_POST['expert-bio'];
        # add function later to auto-add commas
        $expertise = $_POST['expert-skills'];
		$q1 = "UPDATE users SET biography='$bio' WHERE email='$user[email]'";
        $q2 = "UPDATE users SET expertise='$expertise' WHERE email='$user[email]'";
		if (mysqli_query($dbc, $q1) && mysqli_query($dbc, $q2)) {
            $_SESSION['account_created'] = true;
            header('Location: expert.php');
		}  else {
		    $q = "DELETE from users WHERE email='$user[email]'";
            $r = mysqli_query($dbc, $q);
            # properly set redirect message later for failure
            $message = '<p>Your account could not be added because: '.mysqli_error($dbc).'</p>';
            header('Location: signup.php');
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
						<div class="panel-heading"><h3>Tell us about yourself!</h3></div><!-- END Panel Heading -->
						<div class ="panel-body">
						    <form action="" class="form-horizontal" id="expert-about-form" method="post" role="form" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <label for="expert-bio" class="col-sm-2 control-label">Bio</label>
                                        <textarea class="form-control" id="expert-bio" name="expert-bio" 
                                            required="yes" placeholder="I like long walks on the beach" rows="4">
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <label for="expert-skills" class="col-sm-2 control-label">Skills</label>
                                        <textarea class="form-control" id="expert-skills" name="expert-skills" 
                                            required="yes" placeholder="kungfu, micro-farming, astrophysics" rows="2">
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-primary">Clear</button>
                                    </div>
                                </div><!-- END form-group -->
                            </form>
						</div><!-- End panel-body -->
					</div><!-- End panel -->
				</div><!-- End col-md-6 col-md-offset-3 -->
			</div><!-- End row -->
		</div><!-- End container-fluid -->
		<?php include 'template/footer-full.php'; ?> <!-- Footer is here -->
	</body>
</html>