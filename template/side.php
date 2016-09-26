<div class="navbar navbar-inverse navbar-fixed-left">
 	<br>
 	<br>
  	<a href="account-settings.php">
    	<div style="text-align:center" class="profile-pic"><img src="images/cat.jpg"></div>
   	</a>
    <div style="text-align:center" class="profile-description"><h2><?php echo $user['first'];?>
	    </h2><p>
	    	<?php
	    	if ($user['account_type'] == "youth") {
	    		echo "Youth";
	    	} elseif ($user['account_type'] == "expert") {
	    		echo "Career Expert";
			} elseif ($user['account_type'] == "guest") {
                echo "Guest Account"; 
            }?>
	    </p>
    </div>
  	<a class="navbar-brand">
  	Questions by Category
	</a>
  	<ul class="nav navbar-nav side-bar">
  		<li><hr></li>
	   	<li class="main-li"><a class="main-li-text" href="#">Farming and Gardening</a></li>
	   	<li><a href="#">Athletics</a></li>
	   	<li><a href="#">Education</a></li>
	   	<li><a href="#">Hospitality</a></li>
	   	<li><a href="#">Law and Politics</a></li>
	   	<li><a href="#">Medicine</a></li>
	   	<li><a href="#">STEM</a></li>
	   	<li><a href="#">Other</a></li>
	</ul>
</div>
