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
			<div class="col-md-offset-2">
                <div class="row">
                    <div class="container">
                        <div id="youth-btns">
                            <button type="submit" class="btn btn-primary" id="btn-expert-custom">Just for you</button>
                            <button type="submit" class="btn btn-primary" id="btn-expert-specific">Questions you've answered</button>
                        </div>
                    </div>
                </div><!-- END row -->
                <br></br>
                <div class="row">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary" id="panel-youth-general-questions">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">For You</h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        $q = "SELECT * FROM specific_questions WHERE category = 'STEM'";
                                        $r = mysqli_query($dbc, $q);
                                        if(mysqli_num_rows($r) > 0) {
                                            while($question = mysqli_fetch_assoc($r)) { 
                                                $question_date = $question['date'];
                                                $question_title = $question['title'];
                                                $question_id = $question['id']; ?>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p><?php echo $question_title; ?></p>
                                                    </div>
                                                    <div class="col-md-offset-5 col-md-3">
                                                        <p><?php echo $question_date; ?><p>
                                                    </div>
                                                </div><!-- END row -->
                                                <div class="row">
                                                    <form action="youth.php" method="post" role="form">
                                                        <div class="col-md-1">
                                                            <button type="submit" class="btn btn-primary" name="delete_general">Delete</button>
                                                            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                                                        </div>
                                                    </form>
                                                </div><!-- END row -->
                                                <hr><!-- Horizontal line between questions -->
                                        <?php }
                                        } else { ?>
                                            <p>You currently have no listed General questions :(</p>
                                        <?php } ?>
                                    </div><!-- End panel body -->
                                </div><!-- End panel -->
                                <div class="panel panel-primary" id="panel-youth-specific-questions">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Your Career Specific Questions</h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php   
                                        $q = "SELECT * FROM specific_questions WHERE user = '$user[email]'";
                                        $r = mysqli_query($dbc, $q);
                                        if(mysqli_num_rows($r) > 0) {
                                            while($question = mysqli_fetch_assoc($r)) { 
                                                $question_date = $question['date'];
                                                $question_category = $question['category'];
                                                $question_title = $question['title'];
                                                $question_id = $question['id']; ?>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p>Category: <?php echo $question_category; ?><p>
                                                    </div>
                                                    <div class="col-md-offset-5 col-md-3">
                                                        <p><?php echo $question_date; ?><p>
                                                    </div>
                                                </div><!-- END row -->
                                                <div class="row">
                                                    <div class="container">
                                                        <p><?php echo $question_title; ?></p>
                                                    </div>
                                                </div><!-- END row -->
                                                <div class="row">
                                                    <form action="youth.php" method="post" role="form">
                                                        <div class="col-md-1">
                                                            <button type="submit" class="btn btn-primary" name="delete_specific">Delete</button>
                                                            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                                                        </div>
                                                    </form>
                                                </div><!-- END row -->
                                                <hr><!-- Horizontal line between questions -->
                                        <?php }
                                        } else { ?>
                                            <p>You currently have no listed Career Specific questions :(</p>
                                        <?php } ?>
                                    </div><!-- End panel body -->
                                </div><!-- End panel -->
                            </div><!-- END col md -->
                        </div><!-- END row -->
                    </div><!-- End container -->
                </div><!-- END row -->
            </div>			
		</div><!-- END container-fluid -->
		<?php include 'template/footer.php'; ?> <!-- Footer is here -->
	</body>
</html>