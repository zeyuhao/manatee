<?php
# If user is not logged in, automatically go to login page.
# Start the session:
session_start();
include 'config/setup.php';
if (isset($_POST['question_id'])) {
        #$answer = $_POST['expert_answer'];
        $email = $user['email'];
        $question_id = $_POST['question_id'];
        $q = "UPDATE specific_questions SET answer='This is a test answer', answerer_email='$email' WHERE id='$question_id'";
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
                            <button class="btn btn-primary" id="btn-forum-general">General Questions</button>
                            <button class="btn btn-primary" id="btn-forum-specific">Career Specific Questions</button>
                        </div>
                    </div>
                </div><!-- END row -->
                <br></br>
                <div class="row">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary" id="panel-forum-general">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">General Questions</h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        $q = "SELECT * FROM general_questions ORDER BY date DESC";
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
                                                <hr><!-- Horizontal line between questions -->
                                        <?php }
                                        } else { ?>
                                            <p>There are general questions :(</p>
                                        <?php } ?>
                                    </div><!-- End panel body -->
                                </div><!-- End panel -->
                                <div class="panel panel-primary" id="panel-forum-specific">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Career Specific Questions</h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php   
                                        $q = "SELECT * FROM specific_questions ORDER BY date DESC";
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