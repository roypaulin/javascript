<?php // header.php
	include 'functions/common.php';
	session_start();
	testCookie();
	// Logged user?
	
	if (isset($_SESSION['user'])){
		httpsRedirect(); // use https
		$user = $_SESSION['user'];
		$loggedin = TRUE;
	}else {
		$loggedin = FALSE;
	}
	
	
	// Side menu
	if ($loggedin){
		checkTime();	// check authentication time
		// Header
		echo "<div class='header'><a href='home.php'>
		<img id='AirBookingImg' src='img/airBooking2.jpg'></a>
		</div> ";
		echo "<div class='sidenav'>
		  <a href='home.php'>Home</a>
		  <a href='logout.php'>Logout</a>
		</div> ";
		
	}else{
	    // Header
	    echo "<div class='header'><a href='home.php'>
		<img id='AirBookingImg' src='img/airBooking2.jpg' ></a>
		</div> ";
		echo "<div class='sidenav'>
		  <a href='home.php'>Home</a>
		  <a href='login.php'>Login</a>
		  <a href='signUp.php'>Sign up</a>
		</div>";
	}
?>
<noscript style="color:blue;float:left;font-size: large;font-weight: bold;padding-left: 100px;padding-top: 20x;">Javascript is not enabled on your browser: the application could not work properly
 
</noscript>