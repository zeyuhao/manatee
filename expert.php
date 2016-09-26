<?php
# If user is not logged in, automatically go to login page.
# Start the session:
session_start();
if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}
include 'config/setup.php';
if (isset($_POST['question_id'])) {
    # TODO FIX expert_answer post from html form below
    #$answer = $_POST['expert_answer'];
    $email = $user['email'];
    $question_id = $_POST['question_id'];
    $q = "UPDATE specific_questions SET answer='Root plants and leafy vegetables are best: mint, lettuce, carrots, etc', answerer_email='$email' WHERE id='$question_id'";
    $r = mysqli_query($dbc, $q);
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
                            <button class="btn btn-primary" id="btn-expert-for-you">Just for you</button>
                            <button class="btn btn-primary" id="btn-expert-answered">Questions you've answered</button>
                        </div>
                    </div>
                </div><!-- END row -->
                <br></br>
                <div class="row">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary" id="panel-expert-for-you">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">For You</h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        $q = "SELECT * FROM specific_questions WHERE category = 'Farming and Gardening' AND answer = ''";
                                        $r = mysqli_query($dbc, $q);
                                        if(mysqli_num_rows($r) > 0) {
                                            while($question = mysqli_fetch_assoc($r)) { 
                                                $question_date = $question['date'];
                                                $question_title = $question['title'];
                                                $question_category = $question['category'];
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
                                                        <div class="col-md-1">
                                                            <button class="btn btn-primary btn-answer-question">Write an Answer <?php if (isset($test_msg)) { echo $test_msg; } ?></button>
                                                        </div>
                                                </div><!-- END row -->
                                                <div class="row">
                                                    <form action="expert.php" class="form-expert-answer" method="post" role="form" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="container">
                                                                        <label for="expert-answer-title" class="col-sm-2 control-label">Your Answer</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="container">
                                                                        <div class="col-md-6">
                                                                            <textarea class="form-control" id="expert-answer" name="expert-answer" 
                                                                                required="yes" placeholder="Please provide an answer" rows="3"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- END row -->
                                                        <div class="row">
                                                            <div class="container">
                                                                <div class="col-md-2">
                                                                    <button type="submit" class="btn btn-primary" name="btn-answer-submit">Submit</button>
                                                                    <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                                                                    <button type="reset" class="btn btn-primary btn-clear-question">Clear</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div><!-- END row -->
                                                <hr><!-- Horizontal line between questions -->
                                        <?php }
                                        } else { ?>
                                            <p>There are no unanswered questions for you :(</p>
                                        <?php } ?>
                                    </div><!-- End panel body -->
                                </div><!-- End panel -->
                                <div class="panel panel-primary" id="panel-expert-answered">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Your Answers to Questions</h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php   
                                        $q = "SELECT * FROM specific_questions WHERE answerer_email = '$user[email]'";
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
                                                <hr><!-- Horizontal line between questions -->
                                        <?php }
                                        } else { ?>
                                            <p>You haven't answered any questions :(</p>
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