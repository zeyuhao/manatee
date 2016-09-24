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
			}?>
	    </p>
    </div>
  	<br>
  	<br>
  	<a class="navbar-brand">
  	<?php
	if ($user['account_type'] == "youth") {
		echo "Teams I'm on";
	} elseif ($user['account_type'] == "expert") {
		echo "My Managed Teams";
	}?>
	</a>
  	<ul class="nav navbar-nav side-bar">
  		<li><hr></li>
	   	<li class="main-li"><a class="main-li-text" href="#">Money Train</a></li>
	   	<li><a href="#">App Team</a></li>
	   	<li><a href="#">Zissou</a></li>
	   	<li><a href="#">Engineering DevOps</a></li>
	   	<li><a href="#">Enterprise</a></li>
	</ul>
</div>
