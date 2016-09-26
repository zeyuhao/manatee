<?php
# If user is not logged in, automatically go to login page.
# Start the session:
session_start();
if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}
include 'config/setup.php';
if($_POST) {
	if (isset($_POST['youth-general-title'])) {
		$title = $_POST['youth-general-title'];
		$user = $user['email'];
		$q = "INSERT INTO general_questions (title, user, date) 
			  VALUES ('$title', '$user', CURDATE())";
		$r = mysqli_query($dbc, $q);
	} elseif (isset($_POST['youth-specific-title'])) {
		$title = $_POST['youth-specific-title'];
		$user = $user['email'];
        $category = $_POST['youth-question-category'];
		$q = "INSERT INTO specific_questions (title, user, category, date) 
              VALUES ('$title', '$user', '$category', CURDATE())";
		$r = mysqli_query($dbc, $q);
	} elseif (isset($_POST['delete_general'])) {
		$question_id = $_POST['question_id'];
		$q = "DELETE FROM general_questions WHERE id = '$question_id'";
		$r = mysqli_query($dbc, $q);	
	} elseif (isset($_POST['delete_specific'])) {
        $question_id = $_POST['question_id'];
        $q = "DELETE FROM specific_questions WHERE id = '$question_id'";
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
								<button type="submit" class="btn btn-primary" id="btn-youth-general">General Questions</button>
								<button type="submit" class="btn btn-primary" id="btn-youth-specific">Career Specific</button>
							</div>
							<br></br>
							<div class="panel panel-primary">
							    <div class="panel-heading">
                                            <h3 class="panel-title">Submit a new question</h3>
                                        </div>
								<div class="panel-body">
								    <!-- general questions form -->
									<form action="youth.php" class="form-horizontal" id="form-youth-general" method="post" role="form" enctype="multipart/form-data">
										<div class="form-group">
											<label for="youth-general-title" class="col-sm-2 control-label">Title</label>
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
									
									<!-- specific question form -->
									<form action="youth.php" class="form-horizontal" id="form-youth-specific" method="post" role="form" enctype="multipart/form-data">
										<div class="form-group">
											<label for="youth-specific-title" class="col-sm-2 control-label">Title</label>
										    <div class="col-sm-6">
										    	<textarea class="form-control" id="youth-specific-title" name="youth-specific-title" 
                                                    required="yes" placeholder="What is your question?" rows="2"></textarea>
											</div>
										</div><!-- END form-group -->
										<div class="form-group">
											<label for="youth-question-category" class="col-sm-2 control-label">Category</label>
										    <div class="col-sm-6">
										    	<select class="form-control" type="text" name="youth-question-category" id="youth-question-category" required="yes">
													<option value = "Construction">Construction</option>
													<option value = "Farming and Gardening">Farming and Gardening</option>
													<option value = "Law and Politics">Law and Politics</option>
													<option value = "Education">Education</option>
													<option value = "Entertainment">Entertainment</option>
													<option value = "Athletics">Athletics</option>
													<option value = "Medicine">Medicine</option>
													<option value = "Personal Care Industry">Personal Care Industry</option>
													<option value = "STEM">STEM</option>
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
								<div class="col-md-12">
									<div class="panel panel-primary" id="panel-youth-general-questions">
									    <div class="panel-heading">
                                            <h3 class="panel-title">Your General Questions</h3>
                                        </div>
										<div class="panel-body">
    										<?php	
    										$q = "SELECT * FROM general_questions WHERE user = '$user[email]' ORDER BY date DESC";
    										$r = mysqli_query($dbc, $q);
    										if(mysqli_num_rows($r) > 0) {
    											while($question = mysqli_fetch_assoc($r)) { 
    												$question_date = $question['date'];
    												$question_title = $question['title'];
    												$question_id = $question['id'];
    												$question_answer = $question['answer'];?>
    												<div class="row">
    													<div class="col-md-4">
    													    <p><?php echo $question_title; ?></p>
    													</div>
    													<div class="col-md-offset-5 col-md-3">
    													    <p><?php echo $question_date; ?><p>
    													</div>
    												</div><!-- END row -->
    												<div class="row">
                                                        <div class="col-md-4">
                                                            <p>
                                                                <?php if ($question_answer != "") {
                                                                    echo "<b>$question_answer</b>";
                                                                } else echo "Needs an answer";?>
                                                            </p>
                                                        </div>
                                                    </div>
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
                                            $q = "SELECT * FROM specific_questions WHERE user = '$user[email]' ORDER BY date DESC";
                                            $r = mysqli_query($dbc, $q);
                                            if(mysqli_num_rows($r) > 0) {
                                                while($question = mysqli_fetch_assoc($r)) { 
                                                    $question_date = $question['date'];
                                                    $question_category = $question['category'];
                                                    $question_title = $question['title'];
                                                    $question_id = $question['id'];
                                                    $question_answer = $question['answer'];?>
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
                                                        <div class="col-md-4">
                                                            <p>
                                                                <?php if ($question_answer != "") {
                                                                    echo "<b>$question_answer</b>";
                                                                } else echo "Needs an answer";?>
                                                            </p>
                                                        </div>
                                                    </div>
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
			</div>
		</div>
		<?php include 'template/footer.php'; ?> <!-- Footer is here -->
	</body>
</html>